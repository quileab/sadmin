<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Career;

class CareerComponent extends Component
{
    public $uid, $name, $resol, $active_suscribe,$active_eval;
    public $formCareerAction = "store";
    public $updateCareerForm = false;

    public function render()
    {
        $careers=Career::all();
        return view('livewire.career-component',compact('careers'));
    }

    public function saveChange(){
        $career=Career::find($this->uid);
        $career->name=$this->name;
        $career->resol=$this->resol;
        $career->active_suscribe=$this->active_suscribe;
        $career->active_eval=$this->active_eval;
        
        $career->save();
        // cerrar Update Modal
        $this->updateCareerForm=false;
    }

    public function showModalForm(Career $career){
        $this->uid=$career->id;
        $this->name=$career->name;
        $this->resol=$career->resol;
        $this->active_suscribe=$career->active_suscribe;
        $this->active_eval=$career->active_eval;
        // Modificar (Edit)-> true
        $this->updateCareerForm=true;
    }
}
