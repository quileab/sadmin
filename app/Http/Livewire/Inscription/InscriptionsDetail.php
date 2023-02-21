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
    public $inscriptions = [];
    public $inscription_id;
    public $detail = [];

// form & ui data
    public $student_id;
    public $description='';
    public $grade=0;
    public $approved=false;
    public $remove=false;
    public $openModal=false;


    public function mount() {
        $this->inscriptions = \App\Models\Config::where('group', 'inscriptions')->get();
        $this->careers = \App\Models\Career::all();
    }

    public function render() {
        return view('livewire.inscription.inscriptions-detail');
    }

    public function updatedCareerId() {
        $this->subjects = \App\Models\Subject::where('career_id', $this->career_id)
          ->where('name', '!=', '')
          ->get() ?? [];
        $this->subject_id = null;
        $this->detail = [];
    }

    public function updatedSubjectId() {
        $this->detail = [];
    }

    public function updatedInscriptionId() {
        $this->detail = [];
    }

    public function buscarFiltros() {
        $career_id = $this->career_id;
        $subject_id = $this->subject_id;

        $this->detail = DB::table('studentinscriptions')
        ->select('studentinscriptions.user_id',
            'users.lastname', 'users.firstname', 'users.enabled',
            'studentinscriptions.name as inscription',
            'studentinscriptions.value',
            'studentinscriptions.subject_id',
            'subjects.name as subject_name')
        ->join('users', 'users.id', '=', 'studentinscriptions.user_id')
        ->join('subjects', 'subjects.id', '=', 'studentinscriptions.subject_id')
        ->where('user_id', '>', 1)
        ->when(! empty($this->inscription_id), function ($query) {
            return $query->where('studentinscriptions.name', $this->inscription_id);
        })
        ->when(! empty($career_id), function ($query) {
            return $query->where('career_id', $this->career_id);
        })
        ->when(! empty($subject_id), function ($query) {
            return $query->where('subject_id', $this->subject_id);
        })
        ->orderBy('users.lastname')
        ->orderBy('users.firstname')
        ->get();
        
        dd($this->detail);
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
            return $query->where('studentinscriptions.name', $this->inscription_id);
        })
        ->when(! empty($career_id), function ($query) {
            return $query->where('career_id', $this->career_id);
        })
        ->when(! empty($subject_id), function ($query) {
            return $query->where('subject_id', $this->subject_id);
        })
        ->delete();

        $this->detail = [];
    }

    public function edit($key){
        $this->student_id=$this->detail[$key]['user_id'];
        dd($this->detail[$key]);
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
