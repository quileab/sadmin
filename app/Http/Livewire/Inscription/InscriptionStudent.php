<?php

namespace App\Http\Livewire\Inscription;

use App\Models\Studentinscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InscriptionStudent extends Component
{
    public $adminID = null;
    public $studentID = null;
    public $inscription;
    public $inscriptionValues;
    public $inscriptionUpdated;
    public $inscriptionStudent;
    public $career;
    public $inputType;
    public $careers;
    public $subjects = [];

    protected $rules = [
        'subjects.*.value' => 'string',
    ];

    public function getSubjects($id) {
        return $this->subjects = \App\Models\Subject::where('career_id', $id)->
          where('name', '>', '')->
          get();
    }

    public function mount($inscription) {
        $this->inscription = $inscription;
        $this->studentID = Auth::user()->id;
        $this->adminID = \App\Models\User::where('name', 'admin')->first()->id;
        $this->careers = Auth::user()->careers()->get();
        if ($this->career == null) {
            $this->career = $this->careers[0]->id;
        }
        $this->updatedCareer();
        //obtengo el primer valor de la inscripcion como DEFAULT -> lo pase a UpdatedCareer
        // $this->inputType=\App\Models\Studentinscription::where('user_id', $this->adminID)->
        //     where('subject_id',$this->subjects[0]->id)->first()->type ?? 'text';
    }

    public function render() {
        // dd($this->subjects,$this->inscriptionValues);
        return view('livewire.inscription.inscription-student')
            ->with('inputType', $this->inputType)
            ->with('inscriptionValues', $this->inscriptionValues)
            ->with('inscriptionUpdated', $this->inscriptionUpdated)
            ->with('inscriptionStudent', $this->inscriptionStudent)
            ->with('careers', $this->careers)
            ->with('subjects', $this->subjects);
    }

    public function updatedCareer() {
        $this->inscriptionValues = [];
        $this->inscriptionUpdated = [];
        $this->inscriptionStudent = [];
        // Obtengo las materias de la carrera seleccionada
        $subjects = $this->getSubjects($this->career);
        // Seteo el valor del InputType Default
        $this->inputType = \App\Models\Studentinscription::where('user_id', $this->adminID)->
            where('subject_id', $subjects[0]->id)->first()->type ?? 'csv-1';
        // Seteo arrays de trabajo
        $this->inscriptionValues = DB::table('subjects')
          ->join('studentinscriptions', 'subjects.id', '=', 'studentinscriptions.subject_id')
          ->where('studentinscriptions.user_id', $this->adminID)
          ->where('studentinscriptions.name', $this->inscription->id)
          ->where('subjects.career_id', $this->career)
          ->select('subjects.id', 'studentinscriptions.value')
          ->pluck('value', 'id');
        // Seteamos los valores por defecto si no existen
        foreach ($subjects as $subject) {
            if (! isset($this->inscriptionValues[$subject->id])) {
                $this->inscriptionValues[$subject->id] = null;
            }
        }
        $this->inscriptionStudent = DB::table('subjects')
          ->join('studentinscriptions', 'subjects.id', '=', 'studentinscriptions.subject_id')
          ->where('studentinscriptions.user_id', $this->studentID)
          ->where('studentinscriptions.name', $this->inscription->ID)
          ->where('subjects.career_id', $this->career)
          ->select('subjects.id', 'studentinscriptions.value')
          ->pluck('value', 'id');
        // check for empty Student values and set it to default
        //dd($this->inscriptionValues,$this->inscriptionStudent,$this->inscriptionUpdated);
        foreach ($this->inscriptionValues as $key => $value) {
            if (! isset($this->inscriptionStudent[$key])) {
                $this->inscriptionStudent[$key] = null;
            }
        }
        $this->inscriptionUpdated = $this->inscriptionStudent;
        //dd($this->inscriptionValues,$this->inscriptionStudent,$this->inscriptionUpdated);
    }

    public function updateOrCreateValue($key)
    {
        if ($this->studentID == null || $this->studentID == User::where('name', 'admin')->first()->id) {
            $this->emit('toast', '💥 ERROR', 'error');

            return;
        }

        $value = $this->inscriptionStudent[$key];
        if ($value == null) {
            $this->clearValue($key);

            return;
        }
        //$this->validate();
        $studentinscription = \App\Models\Studentinscription::where('user_id', $this->studentID)
            ->where('subject_id', $key)
            ->where('name', $this->inscription->id)
            ->first();

        if ($studentinscription != null) {
            $studentinscription->value = $value;
            $studentinscription->name = $this->inscription->id;
            $studentinscription->save();
        } else { // create Studentinscription
            Studentinscription::create([
                'user_id' => $this->studentID,
                'subject_id' => $key,
                'name' => $this->inscription->id, // name es el id de la inscripcion
                'type' => $this->inputType,
                'value' => $value,
            ]);
        }
        $this->inscriptionUpdated[$key] = $value;
        $this->emit('toast', '📀'.$value, 'info');
    }

    public function clearValue($key)
    {
        // security check for null studentID & user as admin
        if ($this->studentID == null || $this->studentID == User::where('name', 'admin')->first()->id) {
            $this->emit('toast', '💥 ERROR', 'error');

            return;
        }
        //delete record
        $this->inscriptionStudent[$key] = '';
        $this->inscriptionUpdated[$key] = '';
        \App\Models\Studentinscription::where('user_id', $this->studentID)
            ->where('subject_id', $key)
            ->where('name', $this->inscription->id)
            ->delete();
        $this->emit('toast', '💫', 'warning');
    }

    public function csvnAddRemove($id, $value)
    {
        $value = str_replace(['"', ' '], '', $value.',');
        if (strpos($this->inscriptionStudent[$id], $value) === false) {
            $this->inscriptionStudent[$id] = $this->inscriptionStudent[$id].$value;
        } else {
            $this->inscriptionStudent[$id] = str_replace($value, '', $this->inscriptionStudent[$id]);
        }
    }

    public function csv1AddRemove($id, $value)
    {
        $value = str_replace(['"', ' '], '', $value.',');
        if (strpos($this->inscriptionStudent[$id], $value) === false) {
            $this->inscriptionStudent[$id] = $value;
        } else {
            $this->inscriptionStudent[$id] = '';
        }
    }
}
