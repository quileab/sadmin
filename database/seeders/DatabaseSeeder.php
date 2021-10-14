<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'id'=>1,
            'name'=>'admin',
            'pid' => 1,
            'lastname'=>'admin',
            'firstname'=>'admin',
            'phone'=>'',
            'enabled'=>1,
            'email'=>'admin@admin.com',
            'password'=>Hash::make('Sadmin12345'),
        ]);
        \App\Models\User::create([
            'id'=>9,
            'name'=>'user',
            'pid' => 9,
            'lastname'=>'user',
            'firstname'=>'user',
            'phone'=>'',
            'enabled'=>1,
            'email'=>'user@user.com',
            'password'=>Hash::make('Suser12345'),
        ]);
        \App\Models\User::create([
            'id'=>10,
            'name'=>'student',
            'pid' => 10,
            'lastname'=>'student',
            'firstname'=>'student',
            'phone'=>'',
            'enabled'=>0,
            'email'=>'student@student.com',
            'password'=>Hash::make('Sstudent12345'),
        ]);
        $this->call(RoleSeeder::class);
    }
}
