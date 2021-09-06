<?php

namespace App\Http\Livewire\Permissions;

use Livewire\Component;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionComponent extends Component
{
    public $selectedpermissions=[];
    public $selectedrole;
    public $checkall;
    protected $rules=
        ['selectedrole'=>['required','integer','exists:roles,id'],
        'selectedpermissions'=>['required','exists:permissions,id']
        ];

    public function updatedSelectedRole($value)
    {
        $this->selectedpermissions=[];
        $role=Role::find($value);
        if($role) {
            $this->selectedpermissions =$role->getAllPermissions()
                 ->sortBy('name')
                 ->pluck('name', 'id')
                 ->toArray();
        }
    }

    public function Updatedcheckall($value)
    {
        if($value) {
            $this->selectedpermissions = Permission::all()
                ->pluck('name', 'id')
                ->toArray();
        }
        else {
            $this->selectedpermissions=[];
        }
    }

    public function saveRolePermissions()
    {
        if($this->selectedpermissions){
            // remove unchecked values that comes with false assign it
            $this->selectedpermissions = Arr::where($this->selectedpermissions, function ($value) {
                return $value;
            });
        }
        $this->validate();
        $role=Role::find($this->selectedrole);
        if ($role) {
            $role->syncPermissions(Permission::find(array_keys($this->selectedpermissions))->pluck('name'));
            $this->selectedpermissions = $role->getAllPermissions()->sortBy('name')
                ->pluck('name', 'id')
                ->toArray();
            $this->emit('saved');
        }
    }    

    public function render()
    {
        $roles = Role::all();
        $permissions = Permission::all()->sortBy('name');
            //->pluck('id', 'id');
        return view('livewire.permissions.index', compact('roles', 'permissions'));
    }
}
