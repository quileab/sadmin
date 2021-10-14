<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin=Role::create(['name' => 'admin']);
        $roleUser=Role::create(['name' => 'user']);
        $roleStudent=Role::create(['name' => 'student']);
        $roleTeacher=Role::create(['name' => 'teacher']);
        $rolePrincipal=Role::create(['name' => 'principal']);
        $roleSuperintendent=Role::create(['name' => 'superintendent']);
        $roleAdministrative=Role::create(['name' => 'administrative']);
        $roleFinancial=Role::create(['name' => 'financial']);

        Permission::create(['name' => 'menu.dashboard'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.careers'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.students'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);    
        Permission::create(['name' => 'menu.inscriptions'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.schedule'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.books'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.infocards'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.payplans'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.security'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'menu.config'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);

        Permission::create(['name' => 'user.index'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'user.create'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'user.edit'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);

        Permission::create(['name' => 'career.index'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'career.create'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'career.edit'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'career.destroy'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);

        Permission::create(['name' => 'subject.index'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'subject.create'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'subject.edit'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);
        Permission::create(['name' => 'subject.destroy'])->syncRoles([$roleAdmin,$roleUser,$roleStudent,$roleTeacher,$rolePrincipal,$roleSuperintendent,$roleAdministrative,$roleFinancial]);

        // assign role to user name admin
        $userAdmin = \App\Models\User::where('name', 'admin')->first();
        $userAdmin->assignRole($roleAdmin);
        // assign role to user name user
        $userUser = \App\Models\User::where('name', 'user')->first();
        $userUser->assignRole($roleUser);
        // assign role to user name student
        $userStudent = \App\Models\User::where('name', 'student')->first();
        $userStudent->assignRole($roleStudent);
    }
}
