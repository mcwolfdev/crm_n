<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\models;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class ModelsController extends Controller
{

    public function index()
    {
        $data['models_all'] = models::all();

        return view('model.index_model', $data);
    }

}
