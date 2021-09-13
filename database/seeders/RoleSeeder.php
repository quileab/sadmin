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

        Permission::create(['name' => 'menu.dashboard'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'menu.careers'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'menu.students'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'menu.exams'])->syncRoles([$roleAdmin,$roleUser,$roleStudent]);
        Permission::create(['name' => 'menu.calendars'])->syncRoles([$roleAdmin,$roleUser]);
        Permission::create(['name' => 'menu.books'])->syncRoles([$roleAdmin,$roleUser,$roleStudent]);
        Permission::create(['name' => 'menu.infocards'])->syncRoles([$roleAdmin,$roleUser]);
        Permission::create(['name' => 'menu.payplans'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'menu.security'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'menu.config'])->syncRoles([$roleAdmin]);

        Permission::create(['name' => 'user.index'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'user.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'user.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$roleAdmin]);

        Permission::create(['name' => 'career.index'])->syncRoles([$roleAdmin,$roleUser]);
        Permission::create(['name' => 'career.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'career.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'career.destroy'])->syncRoles([$roleAdmin]);

        Permission::create(['name' => 'subject.index'])->syncRoles([$roleAdmin,$roleUser]);
        Permission::create(['name' => 'subject.create'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'subject.edit'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'subject.destroy'])->syncRoles([$roleAdmin]);

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
