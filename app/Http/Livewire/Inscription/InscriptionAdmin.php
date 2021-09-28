<?php

namespace App\Http\Livewire\Inscription;

use App\Models\Studentinscription;
use Livewire\Component;

class InscriptionAdmin extends Component
{
    public $adminID=null;
    public $inscription;
    public $inscriptionValues;
    public $inscriptionUpdated;
    public $career;
    public $inputType;
    public $careers;
    public $subjects=[];

    protected $rules = [
        'subjects.*.value' => 'string',
    ];

    public function getSubjects($id)
    {
        return $this->subjects = \App\Models\Subject::where('career_id', $id)->get();
    }

    public function mount($inscription)
    {
        $this->inscription = $inscription;
        $this->adminID=\App\Models\User::where('name', 'admin') -> first()->id;
        
        $this->careers = \App\Models\Career::all();
        if ($this->career==null) {
            $this->career = $this->careers[0]->id;
        }
        $this->updatedCareer();
        //obtengo inputtype de updatedCareer
        //$this->inputType=\App\Models\Config::find($this->inscription->id.'-data');
    }

    public function render()
    {
        return view('livewire.inscription.inscription-admin')
            ->with('inputType', $this->inputType)
            ->with('inscriptionValues', $this->inscriptionValues)
            ->with('inscriptionUpdated', $this->inscriptionUpdated)
            ->with('careers', $this->careers)
            ->with('subjects', $this->subjects);
    }

    public function updatedCareer()
    {
      $this->inscriptionValues=[];
      $this->inscriptionUpdated=[];
        // Obtenemos las materias de la carrera seleccionada
        $subjects=$this->getSubjects($this->career);
        // Seteo el valor del InputType Default
        $this->inputType=\App\Models\Studentinscription::where('user_id', $this->adminID)->
          where('subject_id',$subjects[0]->id)->first()->type ?? 'text';

        // Seteamos arrays de trabajo
        foreach ($this->subjects as $subject) {
            //dd($subject,$this->inscription->id);
            $this->inscriptionValues[$subject->id]=\App\Models\Studentinscription::where('user_id', $this->adminID)->
                where('subject_id', $subject->id)->first()->value ?? 'N/A'; //$this->inscription;
            $this->inscriptionUpdated[$subject->id]=$this->inscriptionValues[$subject->id];
        }
    }

    public function updateOrCreateValue($key)
    {
        $value=$this->inscriptionValues[$key];
        //$this->validate();
        $studentinscription=\App\Models\Studentinscription::where('user_id', $this->adminID)
            ->where('subject_id', $key)->first();

        if ($studentinscription!=null) {
            $studentinscription->value=$value;
            $studentinscription->type=$this->inputType;
            $studentinscription->save();
        } else { // create Studentinscription
            Studentinscription::create([
                'user_id' => $this->adminID,
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
        $this->inscriptionValues[$key]='';
        $this->inscriptionUpdated[$key]='';
        \App\Models\Studentinscription::where('user_id', $this->adminID)
            ->where('subject_id', $key)->delete();
        $this->emit('toast','Cleared','warning');
    }
}