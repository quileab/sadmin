<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionComponent extends Component
{
    public $selectedpermissions=[];
    public $selectedrole;
    public $newrole, $newpermission;
    public $checkall;
    protected $rules=
        ['selectedrole'=>['required','integer','exists:roles,id'],
        'selectedpermissions'=>['required','exists:permissions,id']
        ];

        // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners=['bookmarkCleared'=>'render']; 

    public function render() {
        $roles = Role::all();
        $permissions = Permission::all()->sortBy('name');
        $selectedUser = \App\Models\User::find(session('bookmark'));
        //->pluck('name', 'id');
        return view('livewire.permissions.index', compact('roles', 'permissions', 'selectedUser'));
    }

    public function updatedSelectedRole($value) {
        $this->selectedpermissions=[];
        $role=Role::find($value);
        if($role) {
            $this->selectedpermissions=$role->permissions->pluck('id','id')->toArray();
        }
    }

    public function Updatedcheckall($value) {
        if($value) {
            $role=Role::find($this->selectedrole);
            if ($role) {
                $this->selectedpermissions=Permission::pluck('id','id')->toArray();
            }
        } else {
            $this->selectedpermissions=[];
        }
    }

    public function saveRolePermissions() {
        if($this->selectedpermissions){
            // remove unchecked values that comes with false assign it
            $this->selectedpermissions=array_filter($this->selectedpermissions);
            foreach ($this->selectedpermissions as $key=>$permission) {
                $this->selectedpermissions[$key]=$key;
            }
        }
        $this->validate();
        $role=Role::find($this->selectedrole);
        //dd($this->selectedpermissions, $this->selectedrole);
        if ($role) {
            $role->syncPermissions(Permission::find(array_keys($this->selectedpermissions))->pluck('name'));
            $this->selectedpermissions=$role->permissions->pluck('id','id')->toArray();
            $this->emit('saved');
        }
    }    

    public function createRole(){
        //dd($this->newrole);
        // check if $this->newrole exists in Roles table
        $role=Role::where('name',$this->newrole)->first();
        if (!$role) {
            $role=Role::create(['name'=>$this->newrole]);
            $this->newrole='';
            $this->emit('toast','Registro Guardado','success');
        } else{
            $this->emit('toast','Rol existente','warning');
        }
    }

    public function createPermission(){
        // check if $this->newpermission exists in Permissions table
        $permission=Permission::where('name', $this->newpermission)->first();
        if (!$permission) {
            $permission=Permission::create(['name'=>$this->newpermission]);
            $this->newpermission='';
            $this->emit('toast', 'Registro Guardado', 'success');
        } else {
            $this->emit('toast', 'Permiso existente', 'warning');
        }
    }

    //asignar rol a usuario
    public function assignRole() {
        $user=\App\Models\User::find(session('bookmark'));
        $role=Role::find($this->selectedrole);
        if ($user && $role) {
            $user->assignRole($role);
            $this->emit('toast', 'Rol asignado', 'success');
        } else {
            $this->emit('toast', 'Error al asignar rol', 'error');
        }
    }

}
