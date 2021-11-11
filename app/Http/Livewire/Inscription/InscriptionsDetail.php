<?php

namespace App\Http\Livewire\Inscription;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InscriptionsDetail extends Component
{
    public $careers=[];
    public $career_id;
    public $subjects=[];
    public $subject_id;
    public $inscriptions=[];
    public $inscription_id;
    public $detail=[];

    public function mount(){
        $this->inscriptions=\App\Models\Config::where('group','inscriptions')->get();
        $this->careers=\App\Models\Career::all();
    }

    public function render(){
        return view('livewire.inscription.inscriptions-detail');
    }

    public function updatedCareerId(){
        $this->subjects=\App\Models\Subject::where('career_id',$this->career_id)
          ->where('name','!=','')
          ->get() ?? [];
        $this->subject_id=null;
        $this->detail=[];
    }

    public function updatedSubjectId(){
        $this->detail=[];
    }

    public function updatedInscriptionId(){
        $this->detail=[];
    }

    public function buscarFiltros(){
        $career_id=$this->career_id;
        $subject_id=$this->subject_id;

        $this->detail=DB::table('studentinscriptions')
        ->select('studentinscriptions.user_id',
            'users.lastname', 'users.firstname',
            'studentinscriptions.name as inscription',
            'studentinscriptions.value',
            'studentinscriptions.subject_id',
            'subjects.name as subject_name')
        ->join('users','users.id','=','studentinscriptions.user_id')
        ->join('subjects','subjects.id','=','studentinscriptions.subject_id')
        ->where('user_id','>',1)
        ->when(!empty($this->inscription_id), function($query){
            return $query->where('studentinscriptions.name',$this->inscription_id);
            })
        ->when(!empty($career_id), function($query){
            return $query->where('career_id', $this->career_id);
            })
        ->when(!empty($subject_id), function($query){
            return $query->where('subject_id', $this->subject_id);
            })
        ->orderBy('users.lastname')
        ->orderBy('users.firstname')
        ->get();
    }

}
