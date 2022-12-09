<?php

namespace App\Http\Livewire;

use App\Models\Office;
use App\Models\Schedule;
use Livewire\Component;

class CalendarsComponent extends Component
{
    //protected $listeners=['officeChanged'];

    public $calendar = 'esto es una prueba';

    public $user_id;

    public $datetime;

    public $fullname;

    public $email;

    public $phone;

    public $subject;

    public $status;

    public $office = 0;

    public $target_file = '';

    public $formAction = 'store';

    public $updateForm = false;

    public function render()
    {
        $offices = Office::all();
        //$schedules=Schedule::all();
        $schedules = Schedule::where('user_id', $this->office)->orderBy('datetime', 'desc')->get();

        return view('livewire.calendars-component', compact('offices', 'schedules'));
    }

    public function officeChanged()
    {
        $this->render();
    }

    public function edit($user_id, $datetime)
    {
        $schedule = Schedule::where('user_id', '=', $user_id)
            ->where('datetime', '=', $datetime)->first();

        if ($schedule->status == 'N') {
            Schedule::where('user_id', '=', $user_id)
                ->where('datetime', '=', $datetime)
                ->update(
                    ['status' => 'O']
                );
            $this->status = 'O';
        } else {
            $this->status = $schedule->status;
        }
        $target_file = '../public/PDFs/'.$schedule->created_at->format('Ymd-His').'-'.preg_replace('/[^a-zA-Z0-9]/', '', $schedule->email).'.pdf';
        if (file_exists($target_file)) {
            // A través del web:Route
            $target_file = '../PDFs/'.$schedule->created_at->format('Ymd-His').'-'.preg_replace('/[^a-zA-Z0-9]/', '', $schedule->email).'.pdf';
            $this->target_file = $target_file;
        } else {
            $this->target_file = '';
        }
        $this->user_id = $user_id;
        $this->datetime = $datetime;
        $this->fullname = $schedule->fullname;
        $this->email = $schedule->email;
        $this->phone = $schedule->phone;
        $this->subject = $schedule->subject;

        $this->formAction = 'update';
        $this->updateForm = true;
    }

    public function saveChange()
    {
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

    public function changeStatus($status)
    {
        $schedule = Schedule::where('user_id', '=', $this->user_id)
            ->where('datetime', '=', $this->datetime)
            ->update(
                ['status' => $status]
            );
        $this->status = $status;
        $this->emit('saved');
        // if($schedule){
        //         session()->flash('message','Status Cambiado');
        // } else{
        //     session()->flash('message','Cambio de Status Error!!!');
        // }
        // session()->flash('message','Status Cambiado');
    }
}
