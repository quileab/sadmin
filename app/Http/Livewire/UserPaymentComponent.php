<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Config;
use Livewire\Component;
use App\Models\PlansDetail;
use App\Models\PlansMaster;
use App\Models\UserPayments;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Auth;

class UserPaymentComponent extends Component
{
    // record payment
    public $uid;
    public $payment=0;
    public $paymentAmount=0;
    public $paymentDescription="";
    public $paymentOriginalDate;
    public $paymentActualDate;

    // auxiliar variables
    public $user;
    public $selectedPlan;
    public $payplans=[];
    public $userPayments=[];
    public $readyToLoad=false;
    public $openModal=false;
    public $hasCounter;
    public $paymentModal=false;
    public $formAction="";
    public $totalDebt=0;
    public $totalPaid=0;

    // validation rules
    protected $rules = [
        'selectedPlan' => 'required',
    ];

    public function mount($uid)
    {
        // check if user has a payBox account 
        $this->hasCounter=Config::find(Auth::user()->email."-paybox");

        $this->uid=$uid;
        $this->user=User::find($uid);
        $this->payplans=PlansMaster::all();
            // $this->userPayments=UserPayments::where('user_id',$uid)->orderBy('date')->get() ?? [];
            // foreach ($this->userPayments as $payment) {
            //     $this->totalDebt+=$payment->amount;
            //     $this->totalPaid+=$payment->paid;
            // }
        $this->updateInfo();
        $this->readyToLoad=true;
        $this->selectedPlan=0;
        //dd($this->userPayments);
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $payplans = $this->payplans;
            $user = $this->user;
            $userPayments = $this->userPayments;
            } else {
            $payplans=[];
            $user = [];
            $userPayments=[];
        }

        return view('livewire.user-payment-component',
            compact('payplans', 'user', 'userPayments'));
    }

    public function loadData(){
        $this->payplans = PlansMaster::all();
        $this->user=User::find($this->uid);
        $this->selectedPlan=$this->payplans[0]->id;
        //dd($this->uid,$this->user);
        $this->readyToLoad=true;
    }

    private function updateInfo(){
        $this->userPayments=UserPayments::where('user_id',$this->uid)->orderBy('date')->get() ?? [];
        $this->totalDebt=0;
        $this->totalPaid=0;
        foreach ($this->userPayments as $payment) {
            $this->totalDebt+=$payment->amount;
            $this->totalPaid+=$payment->paid;
        }
    }

    public function assignPayPlan($pid){
        $planDetails=PlansDetail::where('plans_master_id',$pid)->get();
        foreach ($planDetails as $planDetail) {
            UserPayments::create([
                'user_id'=>$this->uid,
                'date'=>$planDetail->date,
                'paiddate'=>null,
                'title'=>$planDetail->title,
                'paid'=>0,
                'amount'=>$planDetail->amount,
            ]);
        }
        $this->openModal=false;
        // $this->userPayments=UserPayments::where('user_id',$this->uid)->orderBy('date')->get() ?? [];
        $this->updateInfo();
    }

    public function addPaymentToUser(bool $change){
        foreach ($this->userPayments as $payment) {
            if ($payment->amount > $payment->paid) {
                if ($change) {
                    $this->payment=$payment->amount-$payment->paid;
                    $this->paymentDescription=$payment->title;
                    $this->paymentAmount=$payment->amount;
                    $this->paymentModal=true;
                }
                break;
            }
        }
        return $payment->id;
    }

    public function registerUserPayment(){
        if ($this->payment > $this->totalDebt-$this->totalPaid) {
            $this->emit('toast','El pago ingresado es MAYOR que la DEUDA','warning');
            return;
        }

        // mientras haya dinero pagar siguiente cuota
        while ($this->payment > 0) {
            // buscar siguiente cuota
            $paymentID=$this->addPaymentToUser(false);

            // registrar pago en plan
            $payment=UserPayments::find($paymentID);
            //$payment->date=$paimentRecord->created_at; //date('Y-m-d');

            // revisar este cálculo porque no está bien
            $payment->paid=$payment->paid+$this->payment;
            $payment->save();
            $this->payment=$this->payment-$payment->amount;
        }
        // si sobra "algo" registrarlo como pago adicional a cuenta
        // hacer si no registra correctamente    
        
        // registrar pago individual
        $paimentRecord=new PaymentRecord();
        $paimentRecord->user_id=$this->uid;
        $paimentRecord->userpayments_id=$paymentID;
        $paimentRecord->paymentBox=Auth::user()->email;
        $paimentRecord->paymentAmount=$this->payment;
        $paimentRecord->description=$this->paymentDescription;
        $paimentRecord->save();

        // cerar modal y actualizar valores
        $this->paymentModal=false;
        // $this->userPayments=UserPayments::where('user_id', $this->uid)->orderBy('date')->get() ?? [];
        $this->updateInfo();
    }
}
