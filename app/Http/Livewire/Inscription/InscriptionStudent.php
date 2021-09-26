<?php

namespace App\Http\Livewire\Inscription;

use Livewire\Component;
use App\Models\Studentinscription;
use Illuminate\Support\Facades\Auth;

class InscriptionStudent extends Component
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
        $this->adminID=Auth::user()->id;
        
        $this->careers = Auth::user()->careers()->get();
        if ($this->career==null) {
            $this->career = $this->careers[0]->id;
        }
        $this->inputType=\App\Models\Config::find($this->inscription->id.'-data');
        $this->updatedCareer();
    }

    public function render()
    {
        return view('livewire.inscription.inscription-student')
            ->with('inputType', $this->inputType)
            ->with('inscriptionValues', $this->inscriptionValues)
            ->with('inscriptionUpdated', $this->inscriptionUpdated)
            ->with('careers', $this->careers)
            ->with('subjects', $this->subjects);
    }

    public function updatedCareer()
    {
        // Obtenemos las materias de la carrera seleccionada
        $this->getSubjects($this->career);
        // Seteamos arrays de trabajo
        foreach ($this->subjects as $subject) {
            //dd($subject,$this->inscription->id);
            $this->inscriptionValues[$subject->id]=\App\Models\Studentinscription::where('user_id', $this->adminID)->
                where('subject_id', $subject->id)->first()->value ?? null; //$this->inscription;
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
            $studentinscription->save();
        } else { // create Studentinscription
            Studentinscription::create([
                'user_id' => $this->adminID,
                'subject_id' => $key,
                'name' => $key, // default
                'type' => $this->inputType->type,
                'value' => $value,
            ]);
        }
        $this->inscriptionUpdated[$key]=$value;
        $this->emit('toast',$value,'info');
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
