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
        Student::create([
            'user_id'=>$this->uid,
            'lastname'=>$this->lastname,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'enabled'=>$this->enabled,
            'career_id'=>$this->career_id,
        ]);
        // $this->reset(['uid','name','resol']);
        $this->updateForm=false;
    }

    public function edit(User $user){
        $student=$user->student;
        
        $this->uid=$student->user_id;
        $this->lastname=$student->lastname;
        $this->name=$student->name;
        $this->phone=$student->phone;
        $this->enabled=$student->enabled;
        $this->career_id=$student->career_id;

        $this->formAction = "update";
        $this->updateForm=true;
    }

    public function create(){
        $this->reset(['uid','lastname','name','phone']);

        $this->formAction = "store";
        $this->updateForm=true;
    }

    public function saveChange(){
        $this->formAction = "update";
        
        $user=User::find($this->uid);
        $student=$user->student;
        // $student=Student::find($this->uid);
        $student->lastname=$this->lastname;
        $student->name=$this->name;
        $student->phone=$this->phone;
        $student->enabled=$this->enabled;
        $student->career_id=$this->career_id;
        
        $student->save();
        // cerrar Update Modal
        $this->updateForm=false;
    }

    public function showModalForm(Student $student){
        $this->uid=$student->id;
        $this->lastname=$student->lastname;
        $this->name=$student->name;
        $this->phone=$student->phone;
        $this->enabled=$student->enabled;
        $this->career_id=$student->career_id;
        // Modificar (Edit)-> true
        $this->updateForm=true;
    }

    public function destroy(Student $student){
        $student->delete();
    }

}
