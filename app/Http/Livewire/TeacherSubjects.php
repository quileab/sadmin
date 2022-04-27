<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherSubjects extends Component
{
    public $subjects;
    public $career;
    public $careers;
    public $user;

    public function mount()
    {
        //if session 'bookmark' not exists redirect to students
        if (!session()->has('bookmark')) {
            return redirect()->route('students');
        }

        // career get first record from careers table
        $this->career = \App\Models\Career::first();
        // get user from session 'bookmark'
        $this->user = \App\Models\User::find(session('bookmark'));
        // get all careers from careers table
        $this->careers = $this->user->careers()->get();
        //$this->subjects = $this->user->subjects()->where('career_id', $this->career)->get();
        //get all subjects from subjects table where career_id is equal to career id
        $this->subjects = \App\Models\Subject::where('career_id', $this->career->id)->get();
    }

    public function render()
    {
        return view('livewire.teacher-subjects');
    }
}
