<?php

namespace App\Http\Livewire;

use App\Models\Config;
use App\Models\PaymentRecord;
use App\Models\PlansDetail;
use App\Models\PlansMaster;
use App\Models\User;
use App\Models\UserPayments;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserPaymentComponent extends Component
{
    // record payment
    public $uid, $paymentId;

    public $payment = 0;

    public $paymentAmount = 0;

    public $paymentDescription = '';

    public $paymentOriginalDate;

    public $paymentActualDate;

    // auxiliar variables
    public $user;

    public $selectedPlan;

    public $payplans = [];

    public $userPayments = [];

    public $readyToLoad = false;

    public $openModal = false;
    public $modifyPaymentModal = false;

    public $hasCounter;

    public $paymentModal = false;

    public $formAction = '';

    public $totalDebt = 0;

    public $totalPaid = 0;

    public $combinePlans = null;

    // validation rules
    protected $rules = [
        'selectedPlan' => 'required',
    ];

    public function mount($uid)
    {
        // check if user has a payBox account
        $this->hasCounter = Config::find(Auth::user()->email.'-paybox');

        $this->uid = $uid;
        $this->user = User::find($uid);
        $this->payplans = PlansMaster::all();

        $this->updateInfo();
        $this->selectedPlan = 0;
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $payplans = $this->payplans;
            $user = $this->user;
            $userPayments = $this->userPayments;
        } else {
            $payplans = [];
            $user = [];
            $userPayments = [];
        }

        return view('livewire.user-payment-component',
            compact('payplans', 'user', 'userPayments'));
    }

    public function loadData()
    {
        $this->payplans = PlansMaster::all();
        $this->user = User::find($this->uid);
        $this->selectedPlan = $this->payplans[0]->id;
        //dd($this->uid,$this->user);
        $this->readyToLoad = true;
    }

    private function updateInfo()
    {
        $this->userPayments = UserPayments::where('user_id', $this->uid)->orderBy('date')->get() ?? [];
        $this->totalDebt = 0;
        $this->totalPaid = 0;
        foreach ($this->userPayments as $payment) {
            $this->totalDebt += $payment->amount;
            $this->totalPaid += $payment->paid;
        }

    }

    public function assignPayPlan($pid)
    {
        function createUserpayments($uid, $planDetail)
        {
            UserPayments::create([
                'user_id' => $uid,
                'date' => $planDetail->date,
                'paiddate' => null,
                'title' => $planDetail->title,
                'paid' => 0,
                'amount' => $planDetail->amount,
            ]);
        }

        function updateUserpayments($userPaymentsId, $planDetail)
        {
            $userPayments = UserPayments::find($userPaymentsId);
            $userPayments->date = $planDetail->date;
            $userPayments->title = $planDetail->title;
            $userPayments->amount = $planDetail->amount;
            $userPayments->save();
        }

        $planDetails = PlansDetail::where('plans_master_id', $pid)->get();
        // check if Plans has to be combined with other plans
        if ($this->combinePlans) {
            foreach ($planDetails as $planDetail) {
                $userPayments = UserPayments::where('user_id', $this->uid)
                    ->where('date', $planDetail->date)
                    ->orderBy('id', 'desc')->first() ?? [];
                if ($userPayments) { // if user has a payment for this date
                    if ($userPayments->amount > $userPayments->paid) {
                        $planDetail->amount += $userPayments->amount;
                        updateUserpayments($userPayments->id, $planDetail);
                    }
                } else {
                    createUserpayments($this->uid, $planDetail);
                }
            }
        } else { // create new user payments
            foreach ($planDetails as $planDetail) {
                createUserpayments($this->uid, $planDetail);
            }
        }
        $this->openModal = false;
        // $this->userPayments=UserPayments::where('user_id',$this->uid)->orderBy('date')->get() ?? [];
        $this->updateInfo();
    }

    public function addPaymentToUser(bool $change)
    {
        foreach ($this->userPayments as $payment) {
            if ($payment->amount > $payment->paid) {
                if ($change) {
                    $this->payment = $payment->amount - $payment->paid;
                    $this->paymentDescription = $payment->title;
                    $this->paymentAmount = $payment->amount;
                    $this->paymentModal = true;
                }
                break;
            }
        }

        return $payment->id;
    }

    public function registerUserPayment()
    {
        if ($this->payment > $this->totalDebt - $this->totalPaid) {
            $this->emit('toast', 'El pago ingresado es MAYOR que la DEUDA', 'warning');
            return;
        }

        // mientras haya dinero pagar siguiente cuota
        $this->paymentDescription = '';
        $money = $this->payment;
        while ($money > 0) {
            // buscar siguiente cuota impaga
            $this->userPayments = UserPayments::where('user_id', $this->uid)->orderBy('date')->get();
            $paymentID = $this->addPaymentToUser(false);

            // registrar pago en plan
            $payment = UserPayments::find($paymentID);
            //$payment->date=$paimentRecord->created_at; //date('Y-m-d');

            // Calcula si sobra para pagar la/s cuota/s
            if ($money > $payment->amount - $payment->paid) {
                $money = $money - ($payment->amount - $payment->paid);
                // armar la "descripción" del pago
                if ($payment->paid == 0) {
                    $this->paymentDescription = $this->paymentDescription.$payment->title.'/ ';
                } else {
                    $this->paymentDescription = $this->paymentDescription.'saldo '.$payment->title.'/ ';
                }
                $payment->paid = $payment->amount;
                $payment->save();

                // descuento del dinero disponible
            } else { // sino... salda o entrega a cuenta
                // armar la "descripción" del pago
                $this->paymentDescription = $this->paymentDescription.'a cta. '.$payment->title;
                $payment->paid = $payment->paid + $money;
                $payment->save();
                // pongo el dinero disponible en cero
                $money = 0;
            }
        }
        $this->paymentDescription = $this->paymentDescription.'.';

        // registrar pago individual en PaymentRecord
        $paymentRecord = new PaymentRecord();
        $paymentRecord->user_id = $this->uid;
        $paymentRecord->userpayments_id = $paymentID;
        $paymentRecord->paymentBox = Auth::user()->email;
        $paymentRecord->paymentAmount = $this->payment;
        $paymentRecord->description = $this->paymentDescription;
        $paymentRecord->save();

        // cerar modal y actualizar valores
        $this->paymentModal = false;

        // generar PDF de pago
        $data = [
            'user' => $this->user,
            'payment' => $paymentRecord,
            'paymentDescription' => $this->paymentDescription,
            'paymentAmount' => $this->paymentAmount,
            'paymentDate' => $this->paymentActualDate,
        ];

        $this->updateInfo();

        // $timestamp = yyyymmdd-hhmmss
        $timestamp = \Illuminate\Support\Carbon::now()->format('Ymd-His');
        $filename = 'rc-'.$this->user->lastname
            .', '.$this->user->firstname
            .'-'.$timestamp.'.pdf';
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadView('pdf.paymentReceipt', [
            'data' => $data,
        ]);

        $pdf->save(storage_path('app/public/pdfs/'.$filename));

        return response()->download(storage_path('app/public/pdfs/'.$filename, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]));
    }

    public function setAlterPayment($userPayment)
    {
        // alter amount to pay or remove payment
        $this->paymentId= $userPayment['id'];
        $this->totalDebt = $userPayment['amount'];
        $this->totalPaid = $userPayment['paid'];
        $this->paymentDescription = $userPayment['title'].'/ '.
            date_format(date_create($userPayment['date']),'m/Y');
        $this->paymentAmount = $userPayment['amount'];
        $this->modifyPaymentModal = true;
    }

    public function modifyAmount($paymentId){
        $payment = UserPayments::find($paymentId);
        $this->totalDebt=floatval($this->totalDebt);
        $payment->paid=floatval($payment->paid);
        if ($this->totalDebt<$payment->paid){
            $this->emit('toast', 'El pago realizado sería mayor que la deuda', 'warning');
            return;
        }
        
        $payment->amount = $this->totalDebt;
        $payment->save();
        $this->modifyPaymentModal = false;
        $this->updateInfo();
    }

    public function deletePayment($paimentId){
        $payment = UserPayments::find($paimentId);
        if($payment->paid>0) {
            $this->emit('toast', 'Existe un pago realizado', 'warning');
            return;
        }

        $payment->delete();
        $this->modifyPaymentModal = false;
        $this->updateInfo();
    }

}
