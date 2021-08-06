<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PlansMaster;
use App\Models\PlansDetail;
use Livewire\WithPagination;

class PayPlans extends Component
{
    use WithPagination;
    public $master_uid, $master_title;
    public $detail_uid, $detail_date,
        $detail_title, $detail_amount;

    public $PlansMasters=[], $PlansDetail=[];

    public $payplan=1;
    public $openModal=false;
    public $updatePayPlanForm=false;
    public $updatePaymentForm=false;

    public $readyToLoad=false;

    public function render()
    {
        $PlansMasters=$this->PlansMasters;
        $PlansDetail=$this->PlansDetail;
        if ($this->readyToLoad)
        {
            $this->PlansMasters=PlansMaster::all();

        }

        return view('livewire.pay-plans',compact('PlansMasters','PlansDetail'));
    }

    public function loadData(){
        $this->readyToLoad=true;
        $this->payplanChanged($this->payplan);
    }

    public function payplanChanged($id){
        $this->payplan=$id;
        $this->PlansDetail=PlansDetail::where('plans_master_id','=',$this->payplan)->get();
    }

    public function populateDetailData($id){
        $detail=PlansDetail::find($id);
        //dd($detail);
        $this->detail_date=$detail->date;
        $this->detail_title=$detail->title;
        $this->detail_amount=$detail->amount;
        $this->updatePaymentForm=true;
    }

    public function populateMasterData($id){
        $master=PlansMaster::find($id);
        //dd($master);
        $this->master_uid=$master->uid;
        $this->master_title=$master->title;
        $this->updatePayPlanForm=true;
    }
    
}