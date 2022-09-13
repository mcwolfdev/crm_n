<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class ClientsController extends Controller
{

    public function index()
    {
        $data['clients_all_count'] = Client::all()->count();
        $data['clients_all'] = Client::paginate(20);

        return view('client.index_client', $data);
    }

}
