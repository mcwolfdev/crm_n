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

        /*$search = $request->search;

        if($search == ''){
            $employees = Client::orderby('name','asc')->select('id','name','phone')->limit(5)->get();
            //$employees = Client::where('name', $search)->get();
        }else{
            $employees = Client::orderby('name','asc')->select('id','name','phone')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }



        $response = array();
        foreach($employees as $employee){
            $response[] = array(
                "id"    =>  $employee->id,
                "text"  =>  $employee->name,
                "phone" =>  $employee->phone
            );
        }

        return response()->json($response);*/

    }

    //Зв"язуємо модель з брендом в створені роботи job_create
    public function findModel($id)
    {
        $model = models::where('brand_id', $id)->get();
        return response()->json($model);
    }

    public function findinfoclient($id)
    {
        $model = models::where('brand_id', $id)->get();
        $data['client'] = Client::where('id', $id)->first();
        $data['vehicle'] = client_vehicle::where('client_id', $id)->get();

        //return response()->json($model);
        return response()->json($data);
    }

    public function add_new_work(Request $request)
    {
        //dd($request->all());
        //dd($request->Job['performer_id']);
        $request->validate([
            'addMoreInputFields.*.subject' => 'required',
            'Client' => 'required',
            'vehicle-frame_number'=>'required',
            'brand'=>'required',
            'model'=>'required',
            //'Job[\'performer_id\']'=>'required'
        ]);
        //dd($request->all());
        $Client       = $request->input('Client');
        $Phone        = $request->input('client-phone_number');
        $VIN          = $request->input('vehicle-frame_number');
        $brand        = $request->input('brand');
        $model        = $request->input('model');
        $mileage      = $request->input("Vehicle['mileage']");
        $mileage_type = $request->input('Vehicle[mileage_type]');
        $performer    = $request->input('job-performer_id');
        $addition     = $request->input('Job[addition]');


        // Створюємо нового клієнта якщо такого немає в БД
        $find_client = Client::where('id', $Client)->first();
        if (!$find_client || $find_client == null || empty($find_client)) {
            Client::create([
                'name'=> $Client,
                'phone' => $Phone,
            ]);
        }

        // Створюємо новий бренд якщо такого немає в БД
        $find_brand = brand::where('name', $brand)->first();
        if (!$find_brand || $find_brand == null || empty($find_brand)) {
            brand::create([
                'name'=> $brand,
            ]);
        }

        // Створюємо нову модель такої немає в БД
        $find_brand_model = brand::where('name', $brand)->first();
        $find_model = models::where('name', $model)->first();
        if (!$find_model || $find_model == null || empty($find_model)) {
            models::create([
                'name'=> $model,
                'brand_id'=> intval($find_brand_model->id),
            ]);
        }

        // Створюємо новий vin якщо такого немає в БД
        $find_model_for_vehicle = brand::where('name', $brand)->first();
        $find_frame_number = vehicle::where('frame_number', $VIN)->first();
        if (!$find_frame_number || $find_frame_number == null || empty($find_frame_number)) {
            vehicle::create([
                'model_id'=> intval($find_model_for_vehicle->id),
                'frame_number' => $VIN,
                'mileage' => $mileage,
                'mileage_type' => $mileage_type,
            ]);
        }

        // Створюємо нову таблицю роботи
        $find_client_id = Client::where('id', $Client)->first();
        $find_frame_number_id = vehicle::where('frame_number', $VIN)->first();
        Job::create([
            'client_id'=> intval($find_client_id->id),
            'vehicle_id'=> intval($find_frame_number_id->id),
            'creator_id'=> intval(Auth::id()),
            'performer_id'=> $performer,
            'status'=> 'new',
            'addition'=> $addition,
            'pay'=> 0,
            'done_at'=> '',
        ]);

        /*if (!$request->input('addMoreInputFields[0]subject')){
            return redirect()->back()->withErrors('Укажите имя!');
        }*/

        //$find_last_job =Job::orderBy('id', 'desc')->first()->id;
        $find_last_job = Job::all()->last()->id;
        //dd($find_last_job);
        foreach ($request->addMoreInputFields as $key => $value) {
            //Task::create($value);
            //dd($value);
            foreach ($value as $job) {
                Task::create([
                    'job_id'=> $find_last_job+1,
                    'name' => $job,
                    'price' => null,
                    'performer_percent'=>null,
                    'code'=>0,
                ]);
                //dd($job);
            }
        }

        return back()->with('success', 'New subject has been added.');
    }

}
