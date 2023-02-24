<?php

namespace App\Http\Livewire\Inscription;

use Throwable;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class InscriptionsDetail extends Component
{
    public $careers = [];
    public $career_id;
    public $subjects = [];
    public $subject_id;
    public $gradeDate;
    public $inscriptions=[];
    public $inscriptionTypes;
    public $inscriptionType_id;
    public $inscription_id;

// form & ui data
    public $student_id;
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

    public function mount() {
        if (auth()->user()->hasRole(['student','financial','user'])) {
            return abort(404);
        }

        $this->gradeDate=today()->toDateString();
        $this->inscriptionTypes = \App\Models\Config::where('group', 'inscriptions')->get();
        //$this->inscriptionType_id=$this->inscriptionTypes->first();
        $this->careers = \App\Models\Career::all();
        //$this->buscarFiltros();
    }

    public function render() {
        //$this->buscarFiltros();
        return view('livewire.inscription.inscriptions-detail');
    }

    public function updatedCareerId() {
        $this->subjects = \App\Models\Subject::where('career_id', $this->career_id)
          ->where('name', '!=', '')
          ->get() ?? [];
        $this->subject_id = null;
        $this->inscriptions = [];
    }

    public function updatedSubjectId() {
        $this->inscriptions = [];
    }

    public function updatedInscriptionId() {
        $this->inscriptions = [];
    }

    public function buscarFiltros() {
        $career_id = $this->career_id;
        $subject_id = $this->subject_id;

        $inscriptions = DB::table('studentinscriptions')
        ->select('studentinscriptions.user_id',
            'users.lastname', 'users.firstname', 'users.enabled',
            DB::raw("CONCAT(users.lastname,' ',users.firstname) as full_name"),
            'studentinscriptions.name as inscription',
            'studentinscriptions.value',
            'studentinscriptions.subject_id',
            'subjects.name as subject_name')
        ->where('user_id', '>', 1)
        ->join('users', 'users.id', '=', 'studentinscriptions.user_id')
        ->join('subjects', 'subjects.id', '=', 'studentinscriptions.subject_id')
        ->when(! empty($this->inscriptionType_id), function ($query) {
            return $query->where('studentinscriptions.name', $this->inscriptionType_id);
        })
        ->when(! empty($career_id), function ($query) {
            return $query->where('career_id', $this->career_id);
        })
        ->when(! empty($subject_id), function ($query) {
            return $query->where('subject_id', $this->subject_id);
        })
        ->orderBy('full_name')
        ->get()->toArray();

        $this->inscriptions=[];
        foreach($inscriptions as $key=>$inscription){
            // (array) force stdclass to array
            $this->inscriptions[$key]=(array)$inscription;
            // check if has grades
            $grade=\App\Models\Grade::where([
                'user_id'=>$inscription->user_id,
                'subject_id'=>$inscription->subject_id,
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
    }

    public function borrarRegistros() {
        $admin_ID = \App\Models\User::where('name', 'admin')->first()->id;
        $career_id = $this->career_id;
        $subject_id = $this->subject_id;

        DB::table('studentinscriptions')
        ->select('studentinscriptions.user_id',
            'studentinscriptions.name as inscription',
            'studentinscriptions.value',
            'studentinscriptions.subject_id',
            'subjects.name as subject_name')
        ->join('subjects', 'subjects.id', '=', 'studentinscriptions.subject_id')
        ->where('user_id', '!=', $admin_ID)
        ->when(! empty($this->inscription_id), function ($query) {
            return $query->where('studentinscriptions.name', $this->inscriptionType_id);
        })
        ->when(! empty($career_id), function ($query) {
            return $query->where('career_id', $this->career_id);
        })
        ->when(! empty($subject_id), function ($query) {
            return $query->where('subject_id', $this->subject_id);
        })
        ->delete();

        $this->inscriptions = [];
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
        // update listing status
        $this->buscarFiltros();
    }

}
