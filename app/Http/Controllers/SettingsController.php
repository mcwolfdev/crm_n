<?php

namespace App\Http\Controllers;


class SettingsController extends Controller
{

    public function index()
    {
        //$data['clients_all_count'] = Client::all()->count();
        //$data['clients_all'] = Client::paginate(20);

        return view('settings.index_settings');
    }

}
