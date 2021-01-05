<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;

class SubjectsComponent extends Component
{
    public $career_id;

    public function render()
    {
        $subjects=Subject::where('career_id',$this->career_id)->get();
        return view('livewire.subjects-component',compact('subjects'));
    }
}
