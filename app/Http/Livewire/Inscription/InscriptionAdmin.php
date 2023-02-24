<?php

namespace App\Http\Livewire\Inscription;

use App\Models\Studentinscription;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InscriptionAdmin extends Component
{
    public $adminID = null;

    public $inscription;

    public $inscriptionValues;

    public $inscriptionUpdated;

    public $career;

    public $inputType;

    public $careers;

    public $subjects = [];

    protected $rules = [
        'subjects.*.value' => 'string',
    ];

    public function getSubjects($id)
    {
        return $this->subjects = \App\Models\Subject::where('career_id', $id)->
            where('name', '>', '')->
            get();
    }

    public function mount($inscription)
    {
        $this->inscription = $inscription;
        $this->adminID = \App\Models\User::where('name', 'admin')->first()->id;
        if ($this->adminID == null) {
            $this->emit('toast', 'Usuario no encontrado', 'error');

            return;
        }

        $this->careers = \App\Models\Career::all();
        if ($this->career == null) {
            $this->career = $this->careers[0]->id;
        }
        $this->updatedCareer();
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
        $this->inscriptionValues = [];
        $this->inscriptionUpdated = [];
        // Obtenemos las materias de la carrera seleccionada
        $subjects = $this->getSubjects($this->career);
        // Seteo el valor del InputType Default
        $this->inputType = \App\Models\Studentinscription::where('user_id', $this->adminID)->
          where('subject_id', $subjects[0]->id)->first()->type ?? 'csv-1';

        // Seteamos arrays de trabajo
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
        $this->inscriptionUpdated = $this->inscriptionValues;
    }

    public function updateOrCreateValue($key)
    {
        $value = $this->inscriptionValues[$key];
        //$this->validate();
        $studentinscription = \App\Models\Studentinscription::where('user_id', $this->adminID)
          ->where('subject_id', $key)
          ->where('name', $this->inscription->id)
          ->first();

        //dd($studentinscription,$value);
        if ($studentinscription != null) { // Si existe, actualizamos
            $studentinscription->value = $value;
            $studentinscription->type = $this->inputType;
            $studentinscription->name = $this->inscription->id;
            $studentinscription->save();
        } else { // create Studentinscription
            Studentinscription::create([
                'user_id' => $this->adminID,
                'subject_id' => $key,
                'name' => $this->inscription->id, // name es el id de la inscripcion
                'type' => $this->inputType,
                'value' => $value,
            ]);
            $this->inscriptionValues[$key] = $value;
        }
        $this->inscriptionUpdated[$key] = $value;
        $this->emit('toast', '📀'.$value, 'info');
    }

    public function clearValue($key)
    {
        //delete record
        $this->inscriptionValues[$key] = '';
        $this->inscriptionUpdated[$key] = '';
        \App\Models\Studentinscription::where('user_id', $this->adminID)
            ->where('subject_id', $key)
            ->where('name', $this->inscription->id)
            ->delete();
        $this->emit('toast', '💫', 'warning');
    }
}
