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

class UserController extends Controller
{

    public function index()
    {
        $data['user_all_count'] = User::all()->count();
        $data['user_all'] = User::paginate(20);

        return view('user.index_user', $data);
    }

}
