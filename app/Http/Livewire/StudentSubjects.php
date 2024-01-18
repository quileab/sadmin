<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StudentSubjects extends Component
{

    public $student = null; // model class
    public $careers;
    public $career_id;
    public $subjects=[];
    public $subjects_selected=[];

    public function mount(){
        if (auth()->user()->hasRole('student')){
            $this->student = \App\Models\User::find(Auth()->user()->id);
        }
        if (auth()->user()->hasRole(['admin', 'administrative','principal','superintendent'])){
            if (! session()->has('bookmark')) {
                return redirect()->route('students');
            }
            $this->student = \App\Models\User::find(session('bookmark'));
        }

        $this->careers=$this->student->careers()->get();
        $this->career_id=$this->careers->first()->id;
        $this->updatedCareerId();
    }

    public function render(){
        return view('livewire.student-subjects');
    }

    public function updatedCareerId(){
        $this->subjects=\App\Models\Career::find($this->career_id)->subjects()->get();
        $this->subjects_selected=$this->student
            ->subjects()->pluck('correl','id')->all();
    }

    public function toggleSubject($key){
        //set user_subjects table value to 1 if subject is selected
        if (isset($this->subjects_selected[$key])) {
            $this->student->enroll($key,false);
        } else {
            $this->student->enroll($key);
        }
        $this->updatedCareerId();
    }
}
