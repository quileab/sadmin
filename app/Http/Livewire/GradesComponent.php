<?php

namespace App\Http\Livewire;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GradesComponent extends Component
{
    // display
    public $uid;
    public $lastname;
    public $firstname;
    // record
    public $date;
    public $name;
    public $grade;
    public $approved;
    public $selectedCareer = 0;
    public $subjID;
    public $subjName;
    public $canEdit;
    public $grades = [];
    // Livewire utilities
    public $search = '';
    public $openModal = false;
    public $readyToLoad = false;

    // TODO: leave just one
    public $formAction = 'store';
    public $updating = false;
    public $edittingGrade = false;
    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners = ['delete', 'deleteGrade'];
    // Rules of validation
    protected $rules = [
        'uid' => ['required', 'exists:users,id'],
        'subjID' => ['required', 'exists:subjects,id'],
        'date' => ['required'],
        'name' => ['required'],
        'grade' => ['required'], //,'integer'
        'approved' => ['required', 'boolean'],
    ];

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    public function mount($id){
        $this->uid = $id;
    }

    public function render(){
        $careers = [];
        $subjects = [];
        if ($this->readyToLoad) {
            $user = User::find($this->uid);
            $this->canEdit = ! $user->hasRole(['student', 'user', 'administrative', 'financial']);
            $this->lastname = $user->lastname;
            $this->firstname = $user->firstname;
            $this->pid = $user->pid;
            // carreras pertenecientes al USER
            $careers = $user->careers()->get();
            if (! $careers->isEmpty()) {
                // default selected Career
                if ($this->selectedCareer == 0) {
                    $this->selectedCareer = $careers[0]->id;
                }
                // subjects pertenecientes al USER
                $loggedUser = \App\Models\User::find(Auth::user()->id); 
                // if loggedUser = Selected user get all subjects
                if ($loggedUser->id == $this->uid) {
                    $subjects = $user->careers()->find($this->selectedCareer)->subjects()->get();
                } else {
                    // load User -> Career -> Subjects
                    $subjects = $user->careers()->find($this->selectedCareer)->subjects()->
                    //filter subjects existing in logged user subjects
                    whereIn('id', $loggedUser->subjects()->pluck('id'))->get();
                }
            }
            // else {
            //     $this->emit('toast', 'No se encuentran Carreras', 'error');
            // }
        }

        return view('livewire.grades-component', compact('careers', 'subjects'));
    }

    public function loadData(){
        $this->readyToLoad = true;
    }

    public function addGrade(){
        $this->validate();
        Grade::create([
            'user_id' => $this->uid,
            'subject_id' => $this->subjID,
            'date_id' => $this->date,
            'name' => $this->name,
            'grade' => $this->grade,
            'approved' => trim($this->approved ? 1 : 0),
        ]);
        $this->reset(['date', 'name', 'grade', 'approved']);
        $this->emit('toast', 'Registro Guardado', 'success');

        // cargo las notas
        $this->grades = $this->loadGrades($this->uid, $this->subjID);
    }

    public function loadGrades($userId, $subjectId){
        return Grade::where('user_id', $userId)->where('subject_id', $subjectId)->get();
    }

    public function setGrades($subjID, $subjName){
        $this->date = date('Y-m-d');
        $this->subjID = $subjID;
        $this->subjName = $subjName;
        $this->approved = false;

        // cargo las notas
        $this->grades = $this->loadGrades($this->uid, $subjID);

        $this->openModal = true;
    }

    public function cancelEditGrades(){
        $this->reset(['name', 'grade', 'approved']);
        $this->date = date('Y-m-d');
        //$this->openModal = false;
        $this->edittingGrade = false;
        // cargo las notas
        $this->grades = $this->loadGrades($this->uid, $this->subjID);
    }

    public function editGrade($date_id){
        $date_id = \Carbon\Carbon::createFromFormat('d-m-Y', $date_id)->format('Y-m-d');
        $grade = Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->where('date_id', $date_id)
            ->first(); // first() return model
        // ->get() return collection
        // ...
        $this->date = \Carbon\Carbon::createFromFormat('d-m-Y', $grade->date_id)->format('Y-m-d');
        $this->name = $grade->name;
        $this->grade = $grade->grade;
        $this->approved = $grade->approved;
        $this->edittingGrade = true;
    }

    public function updateGrade(){
        $grade = Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->where('date_id', $this->date)
            ->first(); // first() return model
        $grade->user_id = $this->uid;
        $grade->subject_id = $this->subjID;
        $grade->date_id = $this->date;
        $grade->name = $this->name;
        $grade->grade = $this->grade;
        $grade->approved = $this->approved;

        $grade->save();
        $this->reset(['date', 'name', 'grade', 'approved']);
        $this->edittingGrade = false;
        $this->emit('toast', 'Actualizado correctamente', 'success');
        // cargo las notas
        $this->grades = $this->loadGrades($this->uid, $this->subjID);
    }

    public function deleteGrade($date_id){
        $date_id = \Carbon\Carbon::createFromFormat('d-m-Y', $date_id);//->format('Y-m-d');
        //** Composite Key handled by model -> Grade */
        $grade = Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->whereDate('date_id', $date_id)
            ->delete();
        if($grade){
            $this->emit('toast', 'Registro eliminado', 'error');
        } else {
            $this->emit('toast', 'Error al eliminar', 'error');
        }
        // recargo las notas
        $this->grades = $this->loadGrades($this->uid, $this->subjID);
    }
}
