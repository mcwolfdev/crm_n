<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Part;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class StorageController extends Controller
{

    public function index()
    {
        $data['parts'] = Part::all();
        return view('storage.index_storage', $data);
    }

}
