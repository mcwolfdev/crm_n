<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Moodel;
use App\Models\Part;
use App\Models\parts_storage;
use App\Models\PartsStorage;
use App\Models\Task;
use App\Models\task_catalogue;
use App\Models\TaskCatalogue;
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
        $data['parts_all'] = Part::where('quantity','>', 0)->get();
        $data['parts_job'] = $find->Parts()->get();//Part::where('job_id', $id)->get();Tasks()
        $data['users_all'] = User::where('hidden', 0)->get();
        $data['task_job']  = $find->Tasks()->get();//Task::where('job_id', $id)->get();
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
            $employees = Part::orderby('name','asc')->select('id','name','code','retail_price')->limit(10)->get();
        }else{
            $employees = Part::orderby('name','asc')->select('id','name','code','retail_price')->where('name', 'like', '%' .$search . '%')->where('quantity', '>', '0')->get();
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

        $employees = Task::orderby('name', 'asc')->select('id', 'name', 'code', 'price', 'performer_percent','hourly_rate')->where('name', 'like', '%' . $search . '%')->get();


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

    public function edit_job(Request $request)
    {
        $job_id       = $request->input('job_id');
        $find = Job::find($job_id);
        //оновлюємо роботи
        //Task::where('job_id', $job_id)->delete();
        //$find->Tasks()->sync([]);
        //dd($request->all());
        foreach ($request->taskFields as $key => $value) {
            $task = Task::firstOrCreate([
                'name'              =>$value['name'],
                'price'             =>$value['total_price_task'],
                'performer_percent' =>$value['present'],
                'hourly_rate'       =>$value['hourly_rate'],
                'code'              =>$value['code']
            ]);

            $find->Tasks()->sync([
                $task->id => ['price'=>$value['total_price_task'], 'performer_percent'=>$value['present'], 'hourly_rate'=>$value['hourly_rate']],
            ]);
        }
/*        foreach ($request->taskFields as $key => $value) {
            //dd($request->taskFields);
            Task::create([
                'job_id'            => $job_id,
                'task_catalogue_id' => $value['name'],
                'price'             => $value['total_price_task'],
                'performer_percent' => $value['present'],
                'code'              => $value['code'],
                'hourly_rate'       => $value['hourly_rate']
            ]);
        }*/
dd('ok');
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

        return back()->with('success', 'Дані збережено.');
    }

}
