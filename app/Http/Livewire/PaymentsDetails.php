<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PaymentsDetails extends Component
{
    use WithPagination;
    // record payment
    public $uid;
    public $user;

    // auxiliar variables
    public $updating=false;
    public $sort='id';
    public $cant=10;
    public $direction='desc';
    public $loadData=false;
    public $openModal=false;


    public function mount($id)
    {
        $this->user=\App\Models\User::find($id);
    }    
    
    public function render()
    {
        $payments=$this->user->payments()
            ->orderBy('created_at','desc')
            ->paginate($this->cant);
        return view('livewire.payments-details',
            compact('payments'));
    }

    public function loadData()
    {
        $this->loadData=true;
    }

    public function cancelPayment($id){
        //set Paymentrecord description=CAN and paymentAmount=0
        $payment=\App\Models\PaymentRecord::find($id);
        $amount=$payment->paymentAmount;
        //set UserPayment paid=paid-paymentAmount
        $userPayment=\App\Models\UserPayments::find($payment->userpayments_id); 
        $amountPaid=$userPayment->paid;

        do{
            if ($amountPaid<$amount) {
                $amount=$amount-$userPayment->paid;
                $userPayment->paid=0;
            }
            else{
                $userPayment->paid=$userPayment->paid-$amount;
                $amount=0;
            }
            $userPayment->save();
            if ($amount>0) {
                // search for previous payment
                $userPayment=
                \App\Models\UserPayments::where('user_id',$this->user->id)
                    ->where('id','<',$userPayment->id)
                    ->orderBy('id','desc')
                    ->first();
                $amountPaid=$userPayment->paid;
            }
        }while($amount>0);

        //set PaymentRecord description=CAN and paymentAmount=0
        $payment->description='ANULADO';
        $payment->paymentAmount=0;
        $payment->save();
    }


}
