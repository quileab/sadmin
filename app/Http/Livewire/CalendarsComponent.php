<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Models\Schedule;
use Livewire\Component;

class CalendarsComponent extends Component
{
    //protected $listeners=['officeChanged'];

    public $calendar='esto es una prueba';
    public $user_id, $datetime, $fullname,
        $email, $phone, $subject, $status;

    public $office=0;
    public $formAction = "store";
    public $updateForm=false;

    public function render()
    {
        $offices=Office::all();
        //$schedules=Schedule::all();
        $schedules=Schedule::where('user_id',$this->office)->get();
        return view('livewire.calendars-component',compact('offices','schedules'));
    }

    public function officeChanged(){
        $this->render();
    }

    public function edit(Schedule $schedule){
        $this->user_id=$schedule->user_id;
        $this->datetime=$schedule->datetime;
        $this->fullname=$schedule->fullname;
        $this->email=$schedule->email;
        $this->phone=$schedule->phone;
        $this->subject=$schedule->subject;
        $this->status=$schedule->status;

        $this->formAction = "update";
        $this->updateForm=true;
    }

    public function saveChange(){
        // $this->formAction = "update";
        // $career=Career::find($this->uid);
        // $career->name=$this->name;
        // $career->resol=$this->resol;
        // $career->active_suscribe=$this->active_suscribe;
        // $career->active_eval=$this->active_eval;
        
        // $career->save();
        // // cerrar Update Modal
        // $this->updateCareerForm=false;
    }
}
