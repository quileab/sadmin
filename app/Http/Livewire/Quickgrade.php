<?php

namespace App\Http\Livewire;

use Throwable;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Quickgrade extends Component
{
    public $inscriptionTypes;
    public $inscriptions;
    public $careers;
    public $subjects;
    
    public $inscriptionType_id;
    public $career_id;
    public $subject_id;
    public $student_id;
    public $gradeDate;

    public $description='';
    public $grade=0;
    public $approved=false;
    public $remove=false;
    public $openModal=false;

    protected $rules = [
        'career_id' => 'required',
        'inscriptionType_id' => 'required',
        'student_id' => ['required', 'exists:users,id'],
        'subject_id' => ['required', 'exists:subjects,id'],
        'gradeDate' => ['required'],
        'description' => ['required'],
        'grade' => ['required'], //,'integer'
        'approved' => ['required', 'boolean'],
    ];

    public function mount(){
        $this->gradeDate=today()->toDateString();
        $this->inscriptionTypes=\App\Models\Config::where('group','inscriptions')
            ->get();
        $this->inscriptionType_id=$this->inscriptionTypes->first()->id;
        $this->careers=\App\Models\Career::all();
        $this->career_id=$this->careers->first()->id;
        $this->updatedCareerId($this->career_id);
    }

    public function render() {
        $this->loadInscriptions();
        return view('livewire.quickgrade');
    }

    public function loadInscriptions() {
        $this->inscriptions=\App\Models\Studentinscription::
            select([
                'studentinscriptions.user_id',
                'studentinscriptions.subject_id',
                DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name"),
                'studentinscriptions.type',
                'studentinscriptions.value',
                'users.enabled'
                ])
            ->join('users','user_id','=','users.id')
            ->orderBy('full_name')
            //where('user_id',$student->id)->
            ->where('studentinscriptions.subject_id',$this->subject_id)
            ->where('studentinscriptions.name',$this->inscriptionType_id)
            ->get()->toArray();

        foreach($this->inscriptions as $key=>$inscription){
            // add bool attribute student
            $isStudent=\App\Models\User::find($inscription['user_id'])
                ->hasRole('student');
            $this->inscriptions[$key]['isStudent'] = $isStudent;
            // check if has grades
            $grade=\App\Models\Grade::where([
                'user_id'=>$inscription['user_id'],
                'subject_id'=>$inscription['subject_id'],
                'date_id'=>$this->gradeDate,
                ])
                ->first();
            if ($grade==null){
                $this->inscriptions[$key]['grade']=null;
                $this->inscriptions[$key]['description']=null;                
                $this->inscriptions[$key]['approved']=null;                
            } else{
                $this->inscriptions[$key]['grade']=$grade->grade;
                $this->inscriptions[$key]['description']=$grade->name;
                $this->inscriptions[$key]['approved']=$grade->approved;
            }
        }
        //dd($this->inscriptions);
    }

    // public function updatedStudentSrch($value) {
    //     if ($value[0]=='@'){
    //         $search=substr($value,1,20);
    //         $this->student=\App\Models\User::where('email','LIKE','%'.$search.'%')->first();
    //     }
    //     else {
    //         $this->student=\App\Models\User::find($value);
    //     }
    // }

    public function updatedCareerId($value) {
        $this->subjects=\App\Models\Subject::
            select(['id','name'])->
            where('career_id',$value)->
            get();
        $this->subject_id=$this->subjects->first()->id;
    }

    public function edit($key){
        $this->student_id=$this->inscriptions[$key]['user_id'];
        $this->description=$this->inscriptions[$key]['description'];
        $this->grade=$this->inscriptions[$key]['grade'];
        $this->approved=$this->inscriptions[$key]['approved'];
        $this->remove=false;
        $this->openModal=true;    
    }

    public function updateOrSaveGrade(){
        $this->validate();
        $saved=false;
        // check if Grade exists
        $grade = \App\Models\Grade::where('user_id', $this->student_id)
        ->where('subject_id', $this->subject_id)
        ->where('date_id', $this->gradeDate)
        ->first();

        if($grade!=null) { // if exists Update
            $grade->user_id = $this->student_id;
            $grade->subject_id = $this->subject_id;
            $grade->date_id = $this->gradeDate;
            $grade->name = $this->description;
            $grade->grade = $this->grade;
            $grade->approved = $this->approved;
            $grade->save();
            $saved=true;  
        }
        else { // not exists then try to create
            try {
                $result=\App\Models\Grade::create([
                    'user_id' => $this->student_id,
                    'subject_id' => $this->subject_id,
                    'date_id' => $this->gradeDate,
                    'name' => $this->description,
                    'grade' => $this->grade,
                    'approved' => trim($this->approved ? 1 : 0),
                ]);
                $saved=true;
            }catch(Throwable $e){
                $error=implode(' ', array_slice(explode(' ', $e->getMessage()), 0, 7));
                $this->emit('toast', 'ERROR: '.$error.'...', 'danger');
                //report($e);
                $saved=false;  
                return false;
            }
        }
        //dd('Remove',$this->remove,'Saved',$saved,'Approved',$this->approved);

        $this->emit('toast', 'Registro Guardado', 'success');
        $this->openModal=false;

        
        if ($this->approved && $this->remove) {
            \App\Models\Studentinscription::where('user_id', $this->student_id)
            ->where('subject_id', $this->subject_id)
            ->where('name', $this->inscriptionType_id)
            ->delete();
            $this->emit('toast', 'Borrando', 'warning');
        }
    }

}
