<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StudentSubjects extends Component
{
    public $student = null; // model class
    public $careers;
    public $career_id;
    public $subjects=[];

    public function mount(){
        if (auth()->user()->hasRole('student')){
            $this->student = Auth()->user();
        }
        if (auth()->user()->hasRole(['admin', 'administrative','principal','superintendent'])){
            if (! session()->has('bookmark')) {
                return redirect()->route('students');
            }
            $this->student = \App\Models\User::find(session('bookmark'));
        }
        
        $this->careers=$this->student->careers()->get();
        $this->updatedCareerId();
    }

    public function render(){
        return view('livewire.student-subjects');
    }

    public function updatedCareerId(){
        $this->subjects=$this->student->subjects_status($this->career_id);
        foreach($this->subjects as $key=>$subject){
            $this->subjects[$key]['owed']='';
        }
    }

    public function toggleSubject($key){
        $owed=$this->student->can_take($key,'course');
        if(!$owed==[]){
           $this->subjects[$key]['owed']="<strong>Debe regularizar</strong><hr />";
           foreach($owed as $subject){
               $this->subjects[$key]['owed'].=$subject.'<br />';
           }
           $this->subjects[$key]['selected']=false;
           return; 
        }
        //set user_subjects table value to 1 if subject is selected
        if ($this->subjects[$key]['selected']) {
            $this->student->enroll($key,false);
            $this->subjects[$key]['selected']=false;
        } else {
            $this->student->enroll($key);
            $this->subjects[$key]['selected']=true;
        }
    }
}
