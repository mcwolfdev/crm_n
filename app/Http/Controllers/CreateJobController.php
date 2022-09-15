<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Moodel;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class CreateJobController extends Controller
{

    public function index()
    {

        $data['client_all'] = Client::all();
        $data['brands_all'] = brand::all();
        $data['users_all'] = User::where('hidden', 0)->get();
        //$models = models::all();
        //foreach ($models as $model){
        //$data['models_brand'] = $model->Models()->name;
        //}

        //$data['models_brand'] = models::all();

        return view('job_create', $data);
    }


    public function find_client(Request $request)
    {

        $search = $request->search;

        /*if($search == ''){
            $employees = Client::orderby('name','asc')->select('id','name','phone')->limit(5)->get();
            //$employees = Client::where('name', $search)->get();
        }else{*/
            $employees = Client::orderby('name','asc')->select('id','name','phone')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        //}

        $response = array();
        foreach($employees as $employee){
            $response[] = array(
                "id"    =>  $employee->id,
                "text"  =>  $employee->name,
                "phone" =>  $employee->phone
            );
        }

        return response()->json($response);
    }

    public function find_vehicle_client($id)
    {
        $vehicle_client = Vehicle::where('client_id', $id)->get();

        $response = array();
        foreach($vehicle_client as $vehicle){
            $response[] = array(
                "id"    => $vehicle->id,
                "name"  => $vehicle->frame_number,
                //"brand" => $vehicle->Moodel->Brand->name,
                //"brand_id" => $vehicle->Moodel->Brand->id,
                //"model" => $vehicle->Moodel->name,
                //"model_id" => $vehicle->Moodel->id,
            );
        }

        return response()->json($response);
    }

    public function find_vehicle_client_brand_model($id)
    {
        $vehicle_client = Vehicle::where('id', $id)->get();

        $response = array();
        foreach($vehicle_client as $vehicle){
            $response[] = array(
                "id"    => $vehicle->id,
                "name"  => $vehicle->Moodel->Brand->name,
                "brand_id" => $vehicle->Moodel->Brand->id,
                "model" => $vehicle->Moodel->name,
                "model_id" => $vehicle->Moodel->id,
            );
        }

        return response()->json($response);
    }

    //Зв"язуємо модель з брендом в створені роботи job_create
    public function findModel($id)
    {
        $model = Moodel::where('brand_id', $id)->get();
        return response()->json($model);
    }

    public function findinfoclient($id)
    {
        $model = Moodel::where('brand_id', $id)->get();
        $data['client'] = Client::where('id', $id)->first();
        $data['vehicle'] = vehicle::where('client_id', $id)->get();

        //return response()->json($model);
        return response()->json($data);
    }

    public function add_new_work(Request $request)
    {

        $client_name  = $request->input('Client');
        $client_phone = $request->input('client-phone_number');
        $VIN          = $request->input('vehicle-frame_number');
        $brand_name   = $request->input('brand');
        $model_name   = $request->input('model');
        $mileage      = $request->input("Vehicle['mileage']");
        $mileage_type = $request->input('Vehicle[mileage_type]');
        $performer    = $request->input('job-performer_id');
        $addition     = $request->input('Job_addition');
        //dd($request->all());
        // Створюємо нового клієнта якщо такого немає в БД
        $client = Client::firstOrCreate([
            'name'      =>$client_name,
            'phone'     =>$client_phone,
            'comment'   =>''
        ]);

        // Створюємо новий бренд якщо такого немає в БД
        $brand = Brand::firstOrCreate([
            'name'=>$brand_name
        ]);

        // Створюємо нову модель такої немає в БД
        $moodel = $brand->Models()->firstOrCreate([
            'name'=>$model_name
        ]);

        // Створюємо новий vin якщо такого немає в БД
        $vehicle = $moodel->Vehicles()->firstOrCreate([
            'frame_number'  =>$VIN
            ],[
            'client_id'     =>$client->id,
            'mileage'       =>$mileage,
            'mileage_type'  =>$mileage_type
        ]);

        // Створюємо нову таблицю роботи
        $job = Job::firstOrCreate(
            [   'client_id'     =>$client->id,
                'vehicle_id'    => $vehicle->id,
                'creator_id'    =>intval(Auth::id()),
                'performer_id'  =>$performer,
                'status'        =>'new',
                'addition'      =>$addition,
                'pay'           =>'0',
                'done_at'       =>''
            ]
        );
        return back()->with('success', 'Нова робота '.$job->id.' була додана.');
    }

}
