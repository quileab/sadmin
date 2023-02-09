<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Quickgrade extends Component
{
    /**
     * TOO MUCH VARIABLES - REMOVE UNUSED ONES
     */

    public $inscriptions;
    public $careers;
    public $subjects;
    public $students;

    public $inscription_id;
    public $career_id;
    public $subject_id;
    public $student;

    public $date;
    public $description;
    public $grade;
    public $approved;

    public function mount(){
        $this->inscriptions=\App\Models\Config::where('group','inscriptions')
            ->get();
        $this->careers=\App\Models\Career::all();
        $this->career_id=$this->careers->first();
        $this->subjects=\App\Models\Subject::where('career_id',$this->career_id)->get();
    }


    public function render()
    {
        return view('livewire.quickgrade');
    }
}
