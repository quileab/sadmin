<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Career;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class StudentsComponent extends Component
{
    use WithPagination;
    // record
    public $uid, $pid, $name, $lastname, $firstname;
    public $phone, $email, $enabled, $career_id;
    public $student_careers=[];
    // Livewire utilities
    public $search='';    
    public $sort='id';
    public $cant='10';
    public $direction='asc';
    public $openModal=false;
    public $readyToLoad=false;
    // TODO: leave just one
    public $formAction = "store";
    public $updating=false;

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners=['delete','deleteCareer']; 
        
    // Para este caso no es necesario PERO lo dejo como ejemplo
    protected $queryString=[
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'asc'],
        'search'=>['except'=>'']
    ];
    
    protected $rules=[
        'uid'=>'required|numeric',
        'pid'=>'required|numeric',
        'name'=>'required', 
        'lastname'=>'required', 
        'firstname'=>'required',
        'phone'=>'required',
        'email'=>'required|email',
        // 'enabled'
        // 'career_id'
    ];


    public function render()
    {
        $careers=[];
        if ($this->readyToLoad)
        {
        $students=User::where('pid','=',$this->search)->
            orwhere('lastname','like','%'.$this->search."%")->
            orwhere('firstname','like','%'.$this->search."%")->
            orderBy('lastname', $this->direction)->
            paginate($this->cant);

            $careers=Career::all();
            if($this->career_id==null){
                $this->career_id=$careers[0]->id;
            }
        }
        else {
            $students=[];
        }
        return view('livewire.students-component',compact('students','careers'));
    }

    public function loadData(){
        $this->readyToLoad=true;
    }

    public function updatingSearch(){ // livewire hook - cuando cambie la variable $search
        // updating+Variable ---> $variable
        // permite reiniciar el paginado para que
        // funcione correctamente la búsqueda.
        $this->resetPage(); 
    }

    public function order($sort){
        if ($sort==$this->sort){
            if ($this->direction=="desc"){
                $this->direction="asc";
            }else{
                $this->direction="desc";
            }
        }
        else{
            $this->sort=$sort;
        }
    }

    public function store(){
        User::create([
            'user_id'=>$this->uid,
            'pid'=>$this->pid,
            'name'=>$this->pid,
            'lastname'=>$this->lastname,
            'firstname'=>$this->firstname,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'enabled'=>$this->enabled,
            'career_id'=>$this->career_id,
            'password' => Hash::make($this->pid),
        ]);

        $this->openModal=false;
        $this->emit('toast','Registro Guardado','success');
    }

    public function edit(User $user){
        $this->uid=$user->id;
        $this->pid=$user->pid;
        $this->lastname=$user->lastname;
        $this->firstname=$user->firstname;
        $this->name=$user->name;
        $this->phone=$user->phone;
        $this->email=$user->email;
        $this->enabled=$user->enabled;
        $this->career_id=$user->career_id;

        $this->formAction = "update";
        $this->updating=true;
        $this->openModal=true;
        // Search SignedOnCareers
        $this->student_careers = User::find($user->id)->careers()->get();
    }

    public function create(){
        $this->reset([
            'name','uid','pid','lastname',
            'firstname','phone','email'
            ]);

        $this->enabled=true;
        $this->formAction = "store";
        $this->updating=false;
        $this->openModal=true;
    }

    public function saveChange(){
        $this->formAction = "update";
        
        $student=User::find($this->uid);
        //$student=$user;
        // $student=Student::find($this->uid);
        $student->lastname=$this->lastname;
        $student->firstname=$this->firstname;
        $student->phone=$this->phone;
        $student->email=$this->email;
        $student->enabled=$this->enabled;
        //$student->career_id=$this->career_id;
        $student->save();
        // cerrar Update Modal
        $this->openModal=false;
    }

    public function showModalForm(User $student){
        $this->uid=$student->id;
        $this->lastname=$student->lastname;
        $this->firstname=$student->firstname;
        $this->phone=$student->phone;
        $this->email=$student->email;
        $this->enabled=$student->enabled;
        $this->career_id=$student->career_id;
        // Modificar (Edit)-> true
        $this->openModal=true;
    }

    public function delete(User $student){
        try{
            $student->delete();
            $this->emit('toast','Registro eliminado','error');
        } catch(Exception $exeption){
            $this->emit('toast','Error: Existe información relacionada a este Usuario','error');
        }

    }

    public function addCareer(){
        $text=$this->uid." / ".$this->career_id;

        $user=User::find($this->uid);
        $hasCareer = $user->careers()->where('id', $this->career_id)->exists();

        if($hasCareer){
            $this->emit('toast','Ya está cursando esa Carrera','warning');
        }else{
            // Add PIVOT relationship
            $user->careers()->attach($this->career_id);
            // update LiveWire list of Careers
            $this->student_careers = User::find($user->id)->careers()->get();
            $this->emit('toast','Carrera agregada!!','success');
        }
    }

    public function deleteCareer($id){
        $user=User::find($this->uid);
        $user->careers()->detach($id);

        $this->student_careers = User::find($user->id)->careers()->get();
        $this->emit('toast',' Registro eliminado','error');
    }
}
