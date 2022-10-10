<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        if (Settings::all()->count()==0){
            Settings::create(['name'=>'hourly_rate', 'value'=>'1000']);
            Settings::create(['name'=>'currency_usd', 'value'=>'0']);
            Settings::create(['name'=>'moderator_eur', 'value'=>'0']);
            Settings::create(['name'=>'user_session', 'value'=>null]);
            Settings::create(['name'=>'disconnecting_user_session', 'value'=>null]);
        }
    }
}
