<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Career;

class CareerComponent extends Component
{
    public $uid, $name, $resol, $active_suscribe,$active_eval;
    public $formAction = "store";
    public $updateCareerForm = false;

    public function render()
    {
        $careers=Career::all();
        return view('livewire.career-component',compact('careers'));
    }

    public function store(){
        Career::create([
            'id'=>$this->uid,
            'name'=>$this->name,
            'resol'=>$this->resol,
            'active_suscribe'=>1,
            'active_eval'=>1
        ]);
        // $this->reset(['uid','name','resol']);
        $this->updateCareerForm=false;
    }

    public function edit(Career $career){
        $this->uid=$career->id;
        $this->name=$career->name;
        $this->resol=$career->resol;
        $this->active_suscribe=$career->active_suscribe;
        $this->active_eval=$career->active_eval;

        $this->formAction = "update";
        $this->updateCareerForm=true;
    }

    public function create(){
        $this->reset(['uid','name','resol']);
        // $this->uid=$career->id;
        // $this->name=$career->name;
        // $this->resol=$career->resol;
        $this->active_suscribe=true;
        $this->active_eval=true;

        $this->formAction = "store";
        $this->updateCareerForm=true;
    }


    public function saveCareerChange(){
        $this->formAction = "update";
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

    public function destroy(Career $career){
        try{
            $career->delete();
        }catch(\Exception $e){
            $this->emit('toast','ERROR: Esta CARRERA puede contener ESTUDIANTES','error');
        }
    }

}
