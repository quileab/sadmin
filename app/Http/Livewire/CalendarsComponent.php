<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Models\Schedule;
use Livewire\Component;

class CalendarsComponent extends Component
{
    protected $listeners=['officeChanged'];

    public $calendar='esto es una prueba';
    public $office=0;
    public $text;

    public function render()
    {
        $offices=Office::all();
        //$schedules=Schedule::all();
        $schedules=Schedule::where('user_id',$this->office)->get();
        return view('livewire.calendars-component',compact('offices','schedules'));
    }

    public function officeChanged(){
        $this->text=$this->office;
        
        $this->render();
    }
}
