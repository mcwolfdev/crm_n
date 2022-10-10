<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        if (Department::all()->count()==0){
            Department::create(['name'=>'Київ', 'details'=>'р.р.', 'address'=>'вул. Бакінська 35А']);
            Department::create(['name'=>'Львів', 'details'=>'р.р.', 'address'=>'вул. Бережанська 57']);
            Department::create(['name'=>'Тернопіль', 'details'=>'р.р.', 'address'=>'вул. Микулинецька 46Г']);
        }
    }
}
