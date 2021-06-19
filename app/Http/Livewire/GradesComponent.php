<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;

class GradesComponent extends Component
{
    public $readyToLoad=false;
    public $openModal=false;
    public $updating=false;

    public $uid, $lastname, $firstname, $pid;
    public $selectedCareer=0;

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    public function mount($id){
        $this->uid=$id;
    }

    public function render()
    {
        $careers=[];
        $subjects=[];
        if ($this->readyToLoad)
        {
          $user=User::find($this->uid);
          $this->lastname=$user->lastname;
          $this->firstname=$user->firstname;
          $this->pid=$user->pid;
          // carreras pertenecientes al USER
          $careers=$user->careers()->get();
          if (!$careers->isEmpty()){
            // default selected Career  
            if($this->selectedCareer==0){
                $this->selectedCareer=$careers[0]->id;
            }
            // load User -> Career -> Subjects
            $subjects=$user->careers()->find($this->selectedCareer)->subjects()->get();
          } else {
            $careers=[];
            $subjects=[];
            $this->emit('toast','No se encuentran Carreras','error');
          }
            
            //dd($user, $careers, $subjects);
        }
        return view('livewire.grades-component',compact('careers','subjects'));
    }

    public function loadData(){
        $this->readyToLoad=true;
    }
}
