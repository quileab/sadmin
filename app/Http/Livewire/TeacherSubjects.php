<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherSubjects extends Component
{
    public $subjects;
    public $career;
    public $careers;
    public $user;
    public $selected_subjects=[];

    //rules for validation
    public $rules = [
        'career' => 'required',
        'subjects' => 'required',
    ];

    public function mount()
    {
        //if session 'bookmark' not exists redirect to students
        if (!session()->has('bookmark')) {
            return redirect()->route('students');
        }
        // get user from session 'bookmark'
        $this->user = \App\Models\User::find(session('bookmark'));
        // get all careers from careers table
        $this->careers = \App\Models\Career::all();
        // $this->career = first career from careers table
        $this->career = $this->careers->first();
        //get all subjects from subjects table where career_id is equal to career id
        $this->subjects = \App\Models\Subject::where('career_id', $this->career->id)->pluck('name','id')->toArray();
    }

    public function render()
    {
        $user_subjects = $this->user->subjects->pluck('name','id')->toArray();        //remove from subjects items already in user_subjects
        $this->selected_subjects=[];
        foreach ($this->subjects as $key=>$subject) {
            //add attibute "disabled" to each selected_subject if it is already in user_subjects
            if (in_array($subject, $user_subjects)) {
                $this->selected_subjects[$key] = true;
            }else{
                $this->selected_subjects[$key] = false;
            }
        }
        return view('livewire.teacher-subjects');
    }

    // on career change get subjects from subjects table where career_id is equal to career id
    public function updatedCareer($career)
    {
        $this->subjects = \App\Models\Subject::where('career_id', $career)->pluck('name','id')->toArray();
        //$this->render();
    }

    public function toggleSubject($key)
    {
        //switch $selected_subjects[$key] value to opposite
        $this->selected_subjects[$key] = !$this->selected_subjects[$key];

        //set user_subjects table value to 1 if subject is selected
        if ($this->selected_subjects[$key]) {
            $this->user->subjects()->attach($key);
        } else {
            $this->user->subjects()->detach($key);
        }

        $this->emit('toast','Subjects updated','success');
        $this->render();
    }

}
