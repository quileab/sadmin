<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyStudents extends Component
{
    public $Me;
    public $mySubjects; 
    public $myStudents=[];
    public $subjectId;

    protected $rules = [
        'subject'=>'required'
        //'uid'=>'required|numeric',
        //'name' => 'required|unique:users,name',
        //'pid' => 'unique:users,pid|required|numeric',
    ];

    public function mount(){
        $this->Me=\App\Models\User::find(Auth::user()->id);
        $this->mySubjects=$this->Me->Subjects()->orderBy('id')->get();
        $this->subjectId=$this->mySubjects->first()->id;
        $this->myStudents=$this->loadStudents($this->subjectId);
        //dd($this->Me, $this->mySubjects, $this->subject);
    }

    public function render(){
        return view('livewire.my-students');
    }

    public function updatedSubjectId($value){
        $this->subjectId=$value;
        $this->myStudents=$this->loadStudents($this->subjectId);
    }

    public function loadStudents($subject_id){
        $subject=new \App\Models\Subject();
        $students=$subject->students($subject_id);
        return $students;
    }


}
