<?php

namespace App\Http\Livewire;

use App\Models\Career;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsComponent extends Component
{
    use WithPagination;

    // display
    public $careers = [];
    public $careerSelected;
    public $roles = [];
    public $roleSelected;
    public $users = [];
    protected $students;

    // record
    public $uid;
    public $pid;
    public $name;
    public $lastname;
    public $firstname;
    public $phone;
    public $email;
    public $enabled;
    public $career_id = 0;
    public $student_careers = [];

    // Livewire utilities
    public $search = '';
    public $sort = 'id';
    public $cant = '10';
    public $direction = 'asc';
    public $openModal = false;
    public $readyToLoad = false;
    public $globalSearch = true;

    // TODO: leave just one
    public $formAction = 'store';
    public $updating = false;

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners = ['delete', 'deleteCareer'];

    // Para este caso no es necesario PERO lo dejo como ejemplo
    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'asc'],
        'search' => ['except' => ''],
    ];

    protected $rules = [
        //'uid'=>'required|numeric',
        'name' => 'required|unique:users,name',
        'pid' => 'unique:users,pid|required|numeric',
        //'name'=>'required',
        'lastname' => 'required',
        'firstname' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        // 'enabled'
        // 'career_id'
    ];

    public function mount() {
        $this->careers = Career::all();
        if (count($this->careers) > 0) {
            $this->careerSelected = $this->careers[0]->id;
            $this->career_id = $this->careers[0]->id;
        }
        // get all roles
        $this->roles = \Spatie\Permission\Models\Role::all();
        // Set default roleSelected = 3 -> student
        $this->roleSelected = 3;
    }

    public function getSearch() {
        // regex clean $search to only letters, numbers and spaces
        $this->search = preg_replace('/[^A-Za-z0-9 ]/', '', $this->search);

        $users = [];

        // if role=3 get only students filtered by career else get filtered by role
        if ($this->roleSelected == 3 && $this->globalSearch == false) {
            // get students filtered by career
            if ($this->careerSelected != '') {
                $users = User::whereHas('careers', function ($query) {
                    $query->where('career_id', $this->careerSelected);
                });
            } else { // users without career
                $users = User::whereDoesntHave('careers');
            }
            // filter by name
            $users->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('lastname', 'like', '%'.$this->search.'%')
                    ->orWhere('firstname', 'like', '%'.$this->search.'%');
            });
        } else { // get all users by role
            if ($this->roleSelected != 0) {
                $users = User::whereHas('roles', function ($q) {
                    $q->where('roles.id', $this->roleSelected);
                })
                ->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('lastname', 'like', '%'.$this->search.'%')
                        ->orWhere('firstname', 'like', '%'.$this->search.'%');
                });
            } else {
                $users = User::whereDoesntHave('roles');
            }
        }
        //DB::enableQueryLog();
        $users = $users->paginate($this->cant);
        //dd(DB::getQueryLog());
        return $users;
    }

    public function render() {
        if ($this->readyToLoad) {
            $this->students = $this->getSearch();
        } else {
            $this->students = [];
        }

        return view('livewire.students-component',
            ['students' => $this->students]);
    }

    public function loadData() {
        $this->readyToLoad = true;
    }

    public function updatedCareerSelected() {
        $this->render();
    }

    public function updatedRoleSelected() {
        $this->render();
    }

    public function updatedSearch() {
        // when "$this->search" is "updated" reset pagination
        // to proper function of search in all records (not only visible ones).
        $this->resetPage();
        $this->render();
    }

    public function order($sort) {
        if ($sort == $this->sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
        }
    }

    public function store() {
        $this->name = $this->pid;
        $this->validate();
        \App\Models\User::create([
            'user_id' => $this->uid,
            'pid' => $this->pid, // user id (number of DNI)
            'name' => $this->pid,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'phone' => $this->phone,
            'email' => $this->email,
            'enabled' => $this->enabled,
            'career_id' => $this->career_id,
            // use pid as default password - User can change it later on Profile settings
            'password' => Hash::make($this->pid), 
        ]);

        $this->openModal = false;
        $this->emit('toast', 'Registro Guardado', 'success');
    }

    public function passReset(){
        // reset user password to pid
        $user = User::find($this->uid);
        $user->password = Hash::make($this->pid);
        // set two_factor_secret to null
        $user->two_factor_secret = null;
        // set two_factor_recovery_codes to null
        $user->two_factor_recovery_codes = null;
        // check if saved
        if ($user->save()) {
            $this->emit('toast', 'Password Reset', 'success');
        }
        else{
            $this->emit('toast', 'Reset Error', 'error');
        }

    }

    public function edit(User $user)
    {
        $this->uid = $user->id;
        $this->pid = $user->pid;
        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->enabled = $user->enabled;
        $this->career_id = $user->career_id ?? $this->careers[0]->id;

        $this->formAction = 'update';
        $this->updating = true;
        $this->openModal = true;
        // Search SignedOnCareers
        $this->student_careers = User::find($user->id)->careers()->get();
    }

    public function create() {
        $this->reset([
            'name', 'uid', 'pid', 'lastname',
            'firstname', 'phone', 'email',
        ]);

        $this->enabled = true;
        $this->formAction = 'store';
        $this->updating = false;
        $this->openModal = true;
    }

    public function saveChange() {
        $this->formAction = 'update';

        $student = User::find($this->uid);
        //$student=$user;
        // $student=Student::find($this->uid);
        $student->lastname = $this->lastname;
        $student->firstname = $this->firstname;
        $student->phone = $this->phone;
        $student->email = $this->email;
        $student->enabled = $this->enabled;
        //$student->career_id=$this->career_id;
        $student->save();
        // cerrar Update Modal
        $this->openModal = false;
    }

    public function showModalForm(User $student) {
        $this->uid = $student->id;
        $this->lastname = $student->lastname;
        $this->firstname = $student->firstname;
        $this->phone = $student->phone;
        $this->email = $student->email;
        $this->enabled = $student->enabled;
        $this->career_id = $student->career_id;
        // Modificar (Edit)-> true
        $this->openModal = true;
    }

    public function delete(User $student) {
        try {
            $student->delete();
            $this->emit('toast', 'Registro eliminado', 'error');
        } catch(Exception $exeption) {
            $this->emit('toast', 'Error: Existe información relacionada a este Usuario', 'error');
        }
    }

    public function addCareer() {
        // todo: asignar carrera corregir bug
        // dd($this->uid." / ".$this->career_id);

        $user = User::find($this->uid);
        $hasCareer = $user->careers()->where('id', $this->career_id)->exists();

        if ($hasCareer) {
            $this->emit('toast', 'Ya está cursando esa Carrera', 'warning');
        } else {
            // Add PIVOT relationship
            $user->careers()->attach($this->career_id);
            // update LiveWire list of Careers
            $this->student_careers = User::find($user->id)->careers()->get();
            $this->emit('toast', 'Carrera agregada!!', 'success');
        }
    }

    public function deleteCareer($id) {
        $user = User::find($this->uid);
        $user->careers()->detach($id);

        $this->student_careers = User::find($user->id)->careers()->get();
        $this->emit('toast', ' Registro eliminado', 'error');
    }
}
