<?php

namespace App\Http\Livewire;

use App\Models\Career;
use App\Models\Subject;
use Livewire\Component;

class SubjectsComponent extends Component
{
    public $uid;
    public $name, $correl;
    public $career_id, $career_name;
    public $formSubjectAction = "store";
    public $updateSubjectForm = false;

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    public function mount($career_id){
        $this->career_id=$career_id;
        $career=\App\Models\Career::find($career_id);
        $this->career_name=$career->name;
        //dd('mount',$career_id);
    }

    public function render()
    {
        $subjects=Subject::where('career_id',$this->career_id)->get();
        // fullpage livewire por lo tanto no uso "index"
        return view('livewire.subjects-component',compact('subjects'));
    }

    public function saveSubjectChange(){
        $subject=Subject::find($this->uid);
        $subject->career_id=$this->career_id;
        $subject->name=$this->name;
        $subject->correl=$this->correl;
        
        $subject->save();
        // cerrar Update Modal
        $this->updateSubjectForm=false;
    }

    public function showModalSubjectForm(Subject $subject){
        $this->uid=$subject->id;
        $this->name=$subject->name;
        $this->resol=$subject->correl;
        
        // Modificar (Edit)-> true
        $this->updateSubjectForm=true;
    }
}
