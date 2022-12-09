<?php

namespace App\Http\Livewire;

use App\Models\PlansDetail;
use App\Models\PlansMaster;
use Livewire\Component;
use Livewire\WithPagination;

class PayPlans extends Component
{
    use WithPagination;

    public $master_uid;

    public $master_title;

    public $detail_uid;

    public $detail_date;

    public $detail_title;

    public $detail_amount;

    public $PlansMasters = [];

    public $PlansDetail = [];

    public $payplan = 1;

    public $openModal = false;

    public $updatePayPlanForm = false;

    public $updatePaymentForm = false;

    public $readyToLoad = false;

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners = ['deleteMasterData', 'deleteDetailData'];

    public function render()
    {
        $PlansMasters = $this->PlansMasters;
        $PlansDetail = $this->PlansDetail;
        if ($this->readyToLoad) {
            $this->PlansMasters = PlansMaster::all();
        }

        return view('livewire.pay-plans', compact('PlansMasters', 'PlansDetail'));
    }

    public function loadData()
    {
        $this->readyToLoad = true;
        $this->payplanChanged($this->payplan);
    }

    public function payplanChanged($id)
    {
        $this->payplan = $id;
        $this->PlansDetail = PlansDetail::where('plans_master_id', '=', $this->payplan)->
            orderBy('date')->get();
    }

    public function populateDetailData($id)
    {
        $detail = PlansDetail::find($id);
        //dd($detail);
        $this->detail_uid = $detail->id;
        $this->detail_date = $detail->date;
        $this->detail_title = $detail->title;
        $this->detail_amount = $detail->amount;
        $this->updatePaymentForm = true;
    }

    public function populateMasterData($id)
    {
        $master = PlansMaster::find($id);
        $this->master_uid = $master->id;
        $this->master_title = $master->title;
        $this->updatePayPlanForm = true;
    }

    public function updateMasterData($id)
    {
        $master = PlansMaster::find($id);
        $master->title = $this->master_title;
        $master->save();
        $this->updatePayPlanForm = false;
    }

    public function deleteMasterData($id)
    {
        $master = PlansMaster::find($id);
        $master->delete();
        $this->updatePayPlanForm = false;
        $this->render();
    }

    public function updateDetailData($id)
    {
        $detail = PlansDetail::find($id);
        $detail->date = $this->detail_date;
        $detail->title = $this->detail_title;
        $detail->amount = $this->detail_amount;
        $detail->save();
        $this->updatePaymentForm = false;
        $this->payplanChanged($this->payplan);
    }

    public function deleteDetailData($id)
    {
        $detail = PlansDetail::find($id);
        $detail->delete();
        $this->updatePaymentForm = false;
        // livewire render
        $this->payplanChanged($this->payplan);
    }

    public function createMasterData()
    {
        $master = new PlansMaster;
        $master->title = $this->master_title;
        $master->save();
        $this->updatePayPlanForm = false;
    }

    public function createDetailData()
    {
        $detail = new PlansDetail;
        $detail->date = $this->detail_date;
        $detail->title = $this->detail_title;
        $detail->amount = $this->detail_amount;
        $detail->plans_master_id = $this->payplan;
        $detail->save();
        $this->payplanChanged($this->payplan);
        $this->updatePaymentForm = false;
    }

    public function openCreateMasterForm()
    {
        $this->master_uid = 0;
        $this->master_title = '';
        $this->updatePayPlanForm = true;
    }

    public function openCreateDetailForm()
    {
        $this->detail_uid = 0;
        $this->detail_date = '';
        $this->detail_title = '';
        $this->detail_amount = '';
        $this->updatePaymentForm = true;
    }

    // show items joined master-detail
    public function showMasterDetail()
    {
        $this->PlansMasters = PlansMaster::all();
        $this->PlansDetail = PlansDetail::all();

        return view('livewire.pay-plans-master-detail', compact('this->PlansMasters', 'this->PlansDetail'));
    }
}
