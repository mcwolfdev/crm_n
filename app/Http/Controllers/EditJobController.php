<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Part;
use App\Models\parts_storage;
use App\Models\Task;
use App\Models\task_catalogue;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class EditJobController extends Controller
{

    public function index($id)
    {
        $find = Job::find($id);
        if (!$find){
            return view('error.404');
        }

        $data['job'] = $find;
        $data['id'] = $id;
        $data['parts_all'] = parts_storage::where('quantity','>', 0)->get();
        $data['parts_job'] = Part::where('job_id', $id)->get();
        $data['users_all'] = User::where('hidden', 0)->get();
        $data['task_job'] = Task::where('job_id', $id)->get();
        $data['norma_chas'] = '1000'; //TODO зробити таблицю з налаштуваннями нормагодин

        return view('job.job_edit', $data);
    }


    public function home()
    {
        /*$dataProvider = new EloquentDataProvider(Job::query());
        return view('home', [
            'dataProvider' => $dataProvider
        ]);*/
        //$job_all = Job::all();

            $job_all = Job::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            return view('home',compact('job_all'));


    }

    public function find_parts(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $employees = parts_storage::orderby('name','asc')->select('id','name','code','retail_price')->limit(10)->get();
        }else{
            $employees = parts_storage::orderby('name','asc')->select('id','name','code','retail_price')->where('name', 'like', '%' .$search . '%')->where('quantity', '>', '0')->get();
        }

        $response = array();
        foreach($employees as $employee){
            $response[] = array(
                "id"=>$employee->id,
                "code"=>$employee->code,
                "text"=>$employee->name,
                "price"=>$employee->retail_price
            );
        }
        return response()->json($response);
    }

    public function find_jobs(Request $request)
    {
        $search = $request->search;

        $employees = task_catalogue::orderby('name', 'asc')->select('id', 'name', 'code', 'price', 'performer_percent','hourly_rate')->where('name', 'like', '%' . $search . '%')->get();


        $response = array();
        foreach($employees as $employee){
            $response[] = array(
                "id"=>$employee->id,
                "code"=>$employee->code,
                "text"=>$employee->name,
                "price"=>$employee->price,
                "performer_percent"=>$employee->performer_percent,
                "hourly_rate"=>$employee->hourly_rate,
            );
        }
        return response()->json($response);
    }

    //Зв"язуємо модель з брендом в створені роботи job_create
    public function findModel($id)
    {
        $model = Model::where('brand_id', $id)->get();
        return response()->json($model);
    }

    public function findinfoclient($id)
    {
        $model = Model::where('brand_id', $id)->get();
        $data['client'] = Client::where('id', $id)->first();
        $data['vehicle'] = client_vehicle::where('client_id', $id)->get();

        //return response()->json($model);
        return response()->json($data);
    }

    public function edit_job(Request $request)
    {
        //dd($request->all());
        //dd($request->Job['performer_id']);
        /*$request->validate([
            'addMoreInputFields.*.subject' => 'required',
            'Client' => 'required',
            'vehicle-frame_number'=>'required',
            'brand'=>'required',
            'model'=>'required',
            //'Job[\'performer_id\']'=>'required'
        ]);

        $Client       = $request->input('Client');
        $Phone        = $request->input('client-phone_number');
        $VIN          = $request->input('vehicle-frame_number');
        $brand        = $request->input('brand');
        $model        = $request->input('model');
        $mileage      = $request->input("Vehicle['mileage']");
        $mileage_type = $request->input('Vehicle[mileage_type]');
        $performer    = $request->input('job-performer_id');
        $addition     = $request->input('Job[addition]');*/



       /* $find_last_job = Job::all()->last()->id;

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
        }*/

        $job_id       = $request->input('job_id');

        //оновлюємо роботи
        Task::where('job_id', $job_id)->delete();
        foreach ($request->taskFields as $key => $value) {
            //dd($request->taskFields);
            Task::create([
                'job_id'            => $job_id,
                'task_catalogue_id' => $value['name'],
                'price'             => $value['total_price_task'],
                'performer_percent' => $value['present'],
                'code'              => $value['code'],
                'hourly_rate'       => $value['hourly_rate']
            ]);
        }

        //оновлюємо запчастини
        Part::where('job_id', $job_id)->delete();
        foreach ($request->PartsFields as $key => $value) {
            //dd($request->all());
            Part::create([
                'job_id'            => $job_id,
                'parts_storages_id' => $value['name'],
                'price'             => $value['price'],
                'quantity'          => $value['qty'],
                'code'              => $value['code'],
                'total_price'       => $value['total_price']
            ]);
        }

        //оновлюємо коментар та виконавця
        $jobs = Job::where('id', $job_id)->first();
        $jobs->addition = $request->Job['addition'];
        $jobs->performer_id = $request->job_performer_id;

        $jobs->save();

        //оновлюємо пробіг та тип пробігу
        $vehicle = vehicle::where('frame_number', $request->Vehicle['frame_number'])->first();
        $vehicle->mileage = $request->Vehicle['mileage'];
        $vehicle->mileage_type = $request->Vehicle['mileage_type'];
        $vehicle->save();

        return back()->with('success', 'New subject has been added.');
    }

}
