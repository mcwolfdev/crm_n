<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Department;
use App\Models\Job;
use App\Models\Model;
use App\Models\Provisioner;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class AddPartsStorageController extends Controller
{

    public function index()
    {
        $data['provisioner_all'] = Provisioner::all();
        $data['parts_all'] = Provisioner::all();
        $data['storage_all'] = Department::all();

        return view('storage.add_parts_storage', $data);
    }

    public function find_provisioner(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $employees = Provisioner::orderby('name','asc')->select('id','name')->limit(10)->get();
        }else{
            $employees = Provisioner::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->get();
        }

        $response = array();
        foreach($employees as $employee){
            $response[] = array(
                "id"=>$employee->id,
                "text"=>$employee->name
            );
        }
        return response()->json($response);
    }

    public function add_arrival_spare_parts(Request $request)
    {
        dd($request->all());
    }

}
