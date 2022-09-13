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

class BrandsController extends Controller
{

    public function index()
    {
        $data['brands_all'] = brand::all();

        return view('brand.index_brand', $data);
    }

}
