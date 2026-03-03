<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::create([
            'id'=>1,
            'name'=>'SuperAdmin'
        ]);
        Roles::create([
            'id'=>2,
            'name'=>'Admin'
        ]);
        Roles::create([
            'id'=>3,
            'name'=>'Manager'
        ]);
        Roles::create([
            'id'=>4,
            'name'=>'Teacher'
        ]);
        Roles::create([
            'id'=>5  ,
            'name'=>'Worker'
        ]);
        Roles::create([
            'id'=>0,
            'name'=>'User'
        ]);
    }
}
