<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        if (Role::all()->count()==0){
            Role::create(['name'=>'user', 'display_name'=>'user', 'description'=>'Just user']);
            Role::create(['name'=>'admin', 'display_name'=>'admin', 'description'=>'True Admin']);
            Role::create(['name'=>'moderator', 'display_name'=>'moderator', 'description'=>'Moderator']);
            Role::create(['name'=>'mechanic', 'display_name'=>'mechanic', 'description'=>'Механік']);
            Role::create(['name'=>'manager', 'display_name'=>'manager', 'description'=>'Менеджер']);
        }
    }
}
