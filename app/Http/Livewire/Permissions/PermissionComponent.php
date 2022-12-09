<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionComponent extends Component
{
    public $selectedpermissions = [];

    public $selectedrole, $newrole, $newpermission, $roles, $selectedUser;

    public $checkall;

    protected $rules = [
        'selectedrole' => ['required', 'integer', 'exists:roles,id'],
        'selectedpermissions' => ['required', 'exists:permissions,id'],
    ];

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners = ['bookmarkCleared' => 'render'];

    public function mount()
    {
        $this->checkBookMark();
        $this->selectedrole = Role::first()->id;
        $this->selectedpermissions = Permission::first()->id;
        $this->roles = Role::all();
        $this->updatedSelectedRole($this->selectedrole);
    }

    public function render()
    {
        $this->checkBookMark();
        $permissions = Permission::all()->sortBy('name');
        //->pluck('name', 'id');
        return view('livewire.permissions.index', compact('permissions'));
    }

    protected function checkBookMark()
    {
        if (! session('bookmark')) {
            return redirect()->route('students');
        }
        $this->selectedUser = \App\Models\User::find(session('bookmark'));
    }

    public function updatedSelectedRole($value)
    {
        $this->selectedpermissions = [];
        $role = Role::find($value);
        if ($role) {
            $this->selectedpermissions = $role->permissions->pluck('id', 'id')->toArray();
        }
    }

    public function Updatedcheckall($value)
    {
        if ($value) {
            $role = Role::find($this->selectedrole);
            if ($role) {
                $this->selectedpermissions = Permission::pluck('id', 'id')->toArray();
            }
        } else {
            $this->selectedpermissions = [];
        }
    }

    public function saveRolePermissions()
    {
        if ($this->selectedpermissions) {
            // remove unchecked values that comes with false assign it
            $this->selectedpermissions = array_filter($this->selectedpermissions);
            foreach ($this->selectedpermissions as $key => $permission) {
                $this->selectedpermissions[$key] = $key;
            }
        }
        $this->validate();
        $role = Role::find($this->selectedrole);
        //dd($this->selectedpermissions, $this->selectedrole);
        if ($role) {
            $role->syncPermissions(Permission::find(array_keys($this->selectedpermissions))->pluck('name'));
            $this->selectedpermissions = $role->permissions->pluck('id', 'id')->toArray();
            $this->emit('saved');
        }
    }

    public function createRole()
    {
        // check if $this->newrole exists in Roles table
        $this->validate(['newrole' => ['required', 'unique:roles,name']]);
        // create new role with guard_name=web
        $role = Role::create(['name' => $this->newrole, 'guard_name' => 'web']);
        $this->newrole = '';
        $this->emit('toast', 'Registro Guardado', 'success');
    }

    public function createPermission()
    {
        // check if $this->newpermission exists in Permissions table
        $permission = Permission::where('name', $this->newpermission)->first();
        if (! $permission) {
            // permission with guard_name=web
            $permission = Permission::create(['name' => $this->newpermission, 'guard_name' => 'web']);
            //assign permission to role
            $role = Role::find($this->selectedrole);
            if ($role) {
                $role->givePermissionTo($permission);
                $this->emit('toast', 'Registro Guardado', 'success');
            }
            $this->newpermission = '';
            $this->emit('toast', 'Registro Guardado', 'success');
        } else {
            $this->emit('toast', 'Permiso existente', 'warning');
        }
    }

    //asignar rol a usuario
    public function assignRole()
    {
        $user = \App\Models\User::find(session('bookmark'));
        $role = Role::find($this->selectedrole);
        if ($user && $role) {
            $user->assignRole($role);
            $this->emit('toast', 'Rol asignado', 'success');
        } else {
            $this->emit('toast', 'Error al asignar rol', 'error');
        }
    }

    public function removeRole($role)
    {
        $user = \App\Models\User::find(session('bookmark'));
        //$role=Role::find($this->selectedrole);
        if ($user && $role) {
            $user->removeRole($role);
            $this->emit('toast', 'Rol removido', 'success');
        } else {
            $this->emit('toast', 'Error al remover rol', 'error');
        }
    }
}
