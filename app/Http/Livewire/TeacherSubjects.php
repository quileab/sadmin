<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherSubjects extends Component
{
    public $subjects;
    public $career;
    public $careers;
    public $user;

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

        //dd($this->career, $this->user, $this->careers, $this->subjects);
    }

    public function render()
    {
        $user_subjects = $this->user->subjects->pluck('name','id')->toArray();
        //remove from subjects items already in user_subjects
        $selected_subjects=[];
        foreach ($this->subjects as $key=>$subject) {
            //add attibute "disabled" to each selected_subject if it is already in user_subjects
            if (in_array($subject, $user_subjects)) {
                $selected_subjects[$key] = true;
            }else{
                $selected_subjects[$key] = false;
            }
        }

        // dd($career, $user, $careers, $subjects, $user_subjects);
        // if ($this->career == '300') {
        //     dd($this->subjects, $user_subjects, $selected_subjects);
        // }
        //dd($career, $user, $careers, $subjects);
        return view('livewire.teacher-subjects', compact('selected_subjects'));
    }

    // on career change get subjects from subjects table where career_id is equal to career id
    public function updatedCareer($career)
    {
        $this->subjects = \App\Models\Subject::where('career_id', $career)->pluck('name','id')->toArray();
        //$this->render();
    }
}
