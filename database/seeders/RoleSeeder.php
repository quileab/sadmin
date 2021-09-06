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

    }
}
