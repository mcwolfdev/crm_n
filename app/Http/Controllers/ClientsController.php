<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientsController extends Controller
{

    public function index()
    {
        $data['clients_all_count'] = Client::all()->count();
        $data['clients_all'] = Client::paginate(20);

        return view('client.index_client', $data);
    }

}
