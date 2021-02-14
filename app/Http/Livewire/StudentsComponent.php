<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\User;
use App\Models\Career;

class StudentsComponent extends Component
{

    public $uid, $name, $lastname, $phone, $enabled, $career_id;
    public $formAction = "store";
    public $search='';
    public $updateForm = false;

    public function render()
    {
        $students=User::all();
        $careers=Career::all();
        return view('livewire.students-component',compact('students','careers'));
    }

    public function store(){
        User::create([
            'user_id'=>$this->uid,
            'pid'=>$this->pid,
            'lastname'=>$this->lastname,
            'firstname'=>$this->name,
            'phone'=>$this->phone,
            'enabled'=>$this->enabled,
            'career_id'=>$this->career_id,
        ]);
        // $this->reset(['uid','name','resol']);
        $this->updateForm=false;
    }

    public function edit(User $user){
        
        $this->uid=$user->user_id;
        $this->lastname=$user->lastname;
        $this->firstname=$user->firstname;
        $this->phone=$user->phone;
        $this->enabled=$user->enabled;
        $this->career_id=$user->career_id;

        $this->formAction = "update";
        $this->updateForm=true;
    }

    public function create(){
        $this->reset(['uid','pid','lastname','firstname','phone']);

        $this->formAction = "store";
        $this->updateForm=true;
    }

    public function saveChange(){
        $this->formAction = "update";
        
        $user=User::find($this->uid);
        $student=$user->student;
        // $student=Student::find($this->uid);
        $student->lastname=$this->lastname;
        $student->firstname=$this->firstname;
        $student->phone=$this->phone;
        $student->enabled=$this->enabled;
        $student->career_id=$this->career_id;
        
        $student->save();
        // cerrar Update Modal
        $this->updateForm=false;
    }

    public function showModalForm(User $student){
        $this->uid=$student->id;
        $this->lastname=$student->lastname;
        $this->firstname=$student->firstname;
        $this->phone=$student->phone;
        $this->enabled=$student->enabled;
        $this->career_id=$student->career_id;
        // Modificar (Edit)-> true
        $this->updateForm=true;
    }

    public function destroy(User $student){
        $student->delete();
    }

}
