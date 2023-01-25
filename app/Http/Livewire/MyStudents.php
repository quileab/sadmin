<?php

namespace App\Http\Livewire;

use Throwable;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyStudents extends Component
{
    public $Me;
    public $mySubjects; 
    public $myStudents;
    public $studentData;
    public $subjectId='';
    public $classDate;
    public $user_id;
    public $classDay=null;

    // UI attibutes
    public $openModal=false;
    public $updating=false;
    // Form attributes
    public $Dgrade=0;
    public $Dapproved=false;
    public $Dattendance=0;
    public $Dname='';

    protected $rules = [
        'subject'=>'required'
        //'uid'=>'required|numeric',
        //'name' => 'required|unique:users,name',
        //'pid' => 'unique:users,pid|required|numeric',
    ];

    public function mount(){
        $this->Me=\App\Models\User::find(Auth::user()->id)->first();
        $this->mySubjects=$this->Me->Subjects()->orderBy('id')->get();
        $this->subjectId= ($this->subjectId=='') ? $this->mySubjects->first()->id : '';
        $this->myStudents=$this->loadStudents($this->subjectId);
        $this->loadStudentData();
        $this->classDate=today()->toDateString();
    }

    public function render(){
        $this->loadData();
        return view('livewire.my-students');
    }

    // public function updatedSubjectId($value){
    //     //$this->subjectId=$value;
    //     $this->myStudents=$this->loadStudents($this->subjectId);
    //     $this->loadStudentData();
    // }

    public function loadData(){
        // check if there was a class that day
        $this->classDay=\App\Models\Classbook::where('subject_id',$this->subjectId)
            ->where('date_id',$this->classDate)
            ->where('Unit','>',0)
            ->first();
        
        if($this->classDay==null){
            $this->myStudents=[];
            session()->flash('message', 'No existe una clase en el Libro de Temas para ese día.🤔');
            return;
        }
        session()->forget('message');
        $this->myStudents=$this->loadStudents($this->subjectId);
        $this->loadStudentData();
    }

    public function loadStudents($subject_id){
        $subject=new \App\Models\Subject();
        $students=$subject->students($subject_id)
          ->sortBy(['lastname','firstname']);
        return $students;
    }

    public function loadStudentData(){
        $this->studentData=[];
        if (count($this->myStudents)==0){return;};
        foreach($this->myStudents as $student){
            $grade=\App\Models\Grade::where('user_id',$student->user_id)
                ->where('subject_id',$this->subjectId)
                ->where('date_id',$this->classDate)
                ->first();

            if ($grade==null) {
                $this->studentData[$student->user_id] = 
                    [
                      'attendance' => 0,
                      'grade' => 0,
                      'name' => '', // name of the "grade" attribute
                    ];
            }else{
                $this->studentData[$student->user_id] =
                    [
                    'attendance' => $grade->attendance,
                    'grade' => $grade->grade,
                    'name' => $grade->name, // name of the "grade" attribute
                    ];
            }
        }
    }

    public function setAttendance($user_id,$attendance){
        // try to update it
        $grade=\App\Models\Grade::where('user_id',$user_id)
        ->where('subject_id',$this->subjectId)
        ->where('date_id',$this->classDate)
        ->update(['attendance' => $attendance,]);
        // if it doesn't exist create it
        if ($grade==0) {
            $grade=new \App\Models\Grade();
            $grade::create([
              'user_id' => $user_id,
              'subject_id' => $this->subjectId,
              'date_id' => $this->classDate,
              'attendance' => $attendance,
            ]);
        }
    }

    public function update(){
        $grade=\App\Models\Grade::where('user_id',$this->user_id)
        ->where('subject_id',$this->subjectId)
        ->where('date_id',$this->classDate)
        ->update([
          'attendance' => $this->Dattendance,
          'grade' => $this->Dgrade,
          'approved' => $this->Dapproved,
          'name' => $this->Dname,
        ]);
        $kind=$grade==1 ? 'info':'error';
        $this->emit('toast', 'Actualizado ('.$grade.')', $kind);
        $this->openModal=false;        
    }

    public function save(){
      try {
        $grade=new \App\Models\Grade();
        $result=$grade::create([
          'user_id' => $this->user_id,
          'subject_id' => $this->subjectId,
          'date_id' => $this->classDate,
          'attendance' => $this->Dattendance,
          'grade' => $this->Dgrade,
          'approved' => $this->Dapproved,
          'name' => $this->Dname,
        ]);
        } catch (Throwable $e) {
            $error=implode(' ', array_slice(explode(' ', $e->getMessage()), 0, 7));
            $this->emit('toast', 'ERROR: '.$error.'...', 'danger');
            //report($e)
        }
        $this->openModal=false;
    }        

    public function edit($user_id){
        $this->user_id=$user_id;
        $grade=\App\Models\Grade::where('user_id',$user_id)
        ->where('subject_id',$this->subjectId)
        ->where('date_id',$this->classDate)
        ->first();
        if($grade==null){
          // new
          $this->Dapproved=false;
          $this->Dgrade=0;
          $this->Dattendance=0;
          $this->Dname='';
          $this->updating=false;
        }else{
          // update  
          $this->Dapproved=$grade->approved;
          $this->Dgrade=$grade->grade;
          $this->Dattendance=$grade->attendance;
          $this->Dname=$grade->name;
          $this->updating=true;
        }
        $this->openModal=true;
    }

}
