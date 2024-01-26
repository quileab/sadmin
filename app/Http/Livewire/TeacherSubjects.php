<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherSubjects extends Component
{
    public $subjects;
    public $career;
    public $careers;
    public $user;
    public $selected_subjects = [];

    //rules for validation
    public $rules = [
        'career' => 'required',
        'subjects' => 'required',
    ];

    public function mount()
    {
        //if session 'bookmark' not exists redirect to students
        if (! session()->has('bookmark')) {
            return redirect()->route('students');
        }
        // get user from session 'bookmark'
        $this->user = \App\Models\User::find(session('bookmark'));
        // get all careers from careers table
        $this->careers = \App\Models\Career::all();
        // $this->career = first career from careers table
        $this->updateSubjects($this->career->id);
    }

    public function render()
    {
        return view('livewire.teacher-subjects');
    }

    // on career change get subjects from subjects table where career_id is equal to career id
    public function updatedCareer($career)
    {
        $this->subjects = \App\Models\Subject::where('career_id', $career)->pluck('name', 'id')->toArray();
        $this->updateSubjects($career);
    }

    public function toggleSubject($key)
    {
        //switch $selected_subjects[$key] value to opposite
        $this->selected_subjects[$key] = ! $this->selected_subjects[$key];
        //set GRADES "magic record", user_id + subject_id + date(2000-01-01)
        if ($this->selected_subjects[$key]) {
            $this->user->enroll($key);
        } else {
            $this->user->enroll($key, false);
        }
        //$this->emit('toast','Subjects updated','success');
        //$this->render();
    }

    public function updateSubjects($career)
    {
        //get all subjects from subjects table where career_id is equal to career id
        $this->subjects = \App\Models\Subject::where('career_id', $career)->pluck('name', 'id')->toArray();
        $user_subjects = $this->user->enrolled_subjects()->pluck('name', 'id')->toArray();       //remove from subjects items already in user_subjects
        $this->selected_subjects = [];
        foreach ($this->subjects as $key => $subject) {
            //add attibute "disabled" to each selected_subject if it is already in user_subjects
            if (isset($user_subjects[$key])) {
                $this->selected_subjects[$key] = true;
            } else {
                $this->selected_subjects[$key] = false;
            }
        }
    }
}
