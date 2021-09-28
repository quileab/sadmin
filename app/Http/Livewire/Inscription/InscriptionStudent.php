<?php

namespace App\Http\Livewire\Inscription;

use Livewire\Component;
use App\Models\Studentinscription;
use Illuminate\Support\Facades\Auth;

class InscriptionStudent extends Component
{
    public $adminID=null;
    public $studentID=null;
    public $inscription;
    public $inscriptionValues;
    public $inscriptionUpdated;
    public $inscriptionStudent;
    public $career;
    public $inputType;
    public $careers;
    public $subjects=[];

    protected $rules = [
        'subjects.*.value' => 'string',
    ];

    public function getSubjects($id)
    {
        return $this->subjects=\App\Models\Subject::where('career_id', $id)->get();
    }

    public function mount($inscription)
    {
        $this->inscription = $inscription;
        $this->studentID=Auth::user()->id;
        $this->adminID=\App\Models\User::where('name','admin')->first()->id;
        $this->careers = Auth::user()->careers()->get();
        if ($this->career==null) {
            $this->career = $this->careers[0]->id;
        }
        $this->updatedCareer();
        //obtengo el primer valor de la inscripcion como DEFAULT -> lo pase a UpdatedCareer
        // $this->inputType=\App\Models\Studentinscription::where('user_id', $this->adminID)->
        //     where('subject_id',$this->subjects[0]->id)->first()->type ?? 'text';
    }

    public function render()
    {
        return view('livewire.inscription.inscription-student')
            ->with('inputType', $this->inputType)
            ->with('inscriptionValues', $this->inscriptionValues)
            ->with('inscriptionUpdated', $this->inscriptionUpdated)
            ->with('inscriptionStudent', $this->inscriptionStudent)
            ->with('careers', $this->careers)
            ->with('subjects', $this->subjects);
    }

    public function updatedCareer()
    {
      $this->inscriptionValues=[];
      $this->inscriptionUpdated=[];
      $this->inscriptionStudent=[];
        // Obtengo las materias de la carrera seleccionada
        $subjects=$this->getSubjects($this->career);
        // Seteo el valor del InputType Default
        $this->inputType=\App\Models\Studentinscription::where('user_id', $this->adminID)->
            where('subject_id',$subjects[0]->id)->first()->type ?? 'text';
        // Seteo arrays de trabajo
        foreach ($subjects as $subject) {
            $this->inscriptionValues[$subject->id]=\App\Models\Studentinscription::where('user_id', $this->adminID)->
            where('subject_id', $subject->id)->first()->value ?? null;
            $this->inscriptionStudent[$subject->id]=\App\Models\Studentinscription::where('user_id', $this->studentID)->
            where('subject_id', $subject->id)->first()->value ?? null;
            $this->inscriptionUpdated[$subject->id]=$this->inscriptionStudent[$subject->id];
        }
    }

    public function updateOrCreateValue($key)
    {
        $value=$this->inscriptionStudent[$key];
        if ($value==null) { $this->emit('toast','Sin cambios 🚫','warning'); return; }
        //$this->validate();
        $studentinscription=\App\Models\Studentinscription::where('user_id', $this->studentID)
            ->where('subject_id', $key)->first();

        if ($studentinscription!=null) {
            $studentinscription->value=$value;
            $studentinscription->save();
        } else { // create Studentinscription
            Studentinscription::create([
                'user_id' => $this->studentID,
                'subject_id' => $key,
                'name' => $key, // default
                'type' => $this->inputType,
                'value' => $value,
            ]);
        }
        $this->inscriptionUpdated[$key]=$value;
        $this->emit('toast','📀'.$value,'info');
    }

    public function clearValue($key)
    {
        //delete record
        $this->inscriptionStudent[$key]='';
        $this->inscriptionUpdated[$key]='';
        \App\Models\Studentinscription::where('user_id', $this->studentID)
            ->where('subject_id', $key)->delete();
        $this->emit('toast','Cleared','warning');
    }

    public function csvnAddRemove($id,$value){
        $value=str_replace(['"',' '], "", $value.','); 
        if (strpos($this->inscriptionStudent[$id], $value) === false) {
            $this->inscriptionStudent[$id]=$this->inscriptionStudent[$id].$value;
        } else {
            $this->inscriptionStudent[$id]=str_replace($value,'',$this->inscriptionStudent[$id]);
        }
    }

    public function csv1AddRemove($id,$value){
        $value=str_replace(['"',' '], "", $value.','); 
        if (strpos($this->inscriptionStudent[$id], $value) === false) {
            $this->inscriptionStudent[$id]=$value;
        } else {
            $this->inscriptionStudent[$id]='';
        }
    }
}
