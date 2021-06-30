<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;

class GradesComponent extends Component
{
    // display
    public $uid, $lastname, $firstname;
    // record
    public $date, $name, $grade, $approved;
    public $selectedCareer = 0;

    public $subjID, $subjName;
    public $grades = [];

    // Livewire utilities
    public $search = '';
    public $openModal = false;
    public $readyToLoad = false;
    // TODO: leave just one
    public $formAction = "store";
    public $updating = false;
    public $edittingGrade=false;

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners = ['delete','deleteGrade'];

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    public function mount($id)
    {
        $this->uid = $id;
    }

    public function render()
    {
        $careers = [];
        $subjects = [];
        if ($this->readyToLoad) {
            $user = User::find($this->uid);
            $this->lastname = $user->lastname;
            $this->firstname = $user->firstname;
            $this->pid = $user->pid;
            // carreras pertenecientes al USER
            $careers = $user->careers()->get();
            if (!$careers->isEmpty()) {
                // default selected Career  
                if ($this->selectedCareer == 0) {
                    $this->selectedCareer = $careers[0]->id;
                }
                // load User -> Career -> Subjects
                $subjects = $user->careers()->find($this->selectedCareer)->subjects()->get();
            } else {
                $careers = [];
                $subjects = [];
                $this->emit('toast', 'No se encuentran Carreras', 'error');
            }
            // Si el Modal se abre cargo las notas
            if ($this->openModal == true) {
                $this->grades = Grade::where('user_id', $this->uid)
                    ->where('subject_id', $this->subjID)
                    ->get();
            }
        }
        return view('livewire.grades-component', compact('careers', 'subjects'));
    }

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function addGrade()
    {
        //dd($this->approved);
        Grade::create([
            'user_id' => $this->uid,
            'subject_id' => $this->subjID,
            'date_id' => $this->date,
            'name' => $this->name,
            'grade' => $this->grade,
            'approved' => $this->approved ? 1 : 0,
        ]);

        $this->reset(['date','name','grade','approved']);
        $this->emit('toast', 'Registro Guardado', 'success');
    }

    public function setGrades($subjID, $subjName)
    {
        $this->subjID = $subjID;
        $this->subjName = $subjName;

        $this->openModal = true;
    }

    public function cancelEditGrades()
    {
        $this->reset(['date','name','grade','approved']);
        //$this->openModal = false;
        $this->edittingGrade=false;
    }

    public function editGrade($date_id){
        $date_id=\Carbon\Carbon::createFromFormat('d-m-Y', $date_id)->format('Y-m-d');
        $grade=Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->where('date_id',$date_id)
            ->first(); // first() return model
            // ->get() return collection
        // ...
        $this->date=\Carbon\Carbon::createFromFormat('d-m-Y', $grade->date_id)->format('Y-m-d');
        $this->name=$grade->name;
        $this->grade=$grade->grade;
        $this->approved=$grade->approved;
        $this->edittingGrade=true;
    }

    public function updateGrade(){
        $grade=Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->where('date_id',$this->date)
            ->first(); // first() return model
        $grade->user_id=$this->uid;
        $grade->subject_id=$this->subjID;
        $grade->date_id=$this->date;
        $grade->name=$this->name;
        $grade->grade=$this->grade;
        $grade->approved=$this->approved;

        $grade->save();
        $this->reset(['date','name','grade','approved']);
        $this->edittingGrade=false;
        $this->emit('toast','Actualizado correctamente','success');
    }

    public function deleteGrade($date_id){
        $date_id=\Carbon\Carbon::createFromFormat('d-m-Y', $date_id)->format('Y-m-d');
        $grade=Grade::where('user_id', $this->uid)
            ->where('subject_id', $this->subjID)
            ->where('date_id',$date_id)
            ->first(); // first() return model
        $grade->delete();
        $this->emit('toast','Registro eliminado','error');
    }
}
