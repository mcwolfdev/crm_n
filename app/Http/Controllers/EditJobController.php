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
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

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


        //кожен (окрім адміна) користувач може переглядати тільки свої роботи
        if (Auth::user()->id == $find->performer_id || Auth::user()->isAdmin())
        {
            return view('job.job_edit', $data);
        }
        return view('error.error_block');
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
        $job_id     = $request->input('job_id');
        $find       = Job::find($job_id);

        //оновлюємо роботи
        $params = [];
        //dd($request->taskFields);
        foreach ($request->taskFields as $key => $value) {
            $find_name = Task::where('id', $value['name'])->first();
            $task = Task::firstOrCreate([
                'name'              =>$find_name->name,
                ],[
                'price'             =>$value['total_price_task'],
                'performer_percent' =>$value['present'],
                'hourly_rate'       =>$value['hourly_rate'],
                'code'              =>$value['code']
            ]);

            //$find->Tasks()->sync([
            //    $task->id => ['price'=>$value['total_price_task'], 'performer_percent'=>$value['present'], 'hourly_rate'=>$value['hourly_rate']],
            //]);
            $params[$value['name']] = ['job_id'=> $job_id, 'task_id' => $value['name'], 'price'=>$value['total_price_task'], 'performer_percent'=>$value['present'], 'hourly_rate'=>$value['hourly_rate']];
        }

        $find->Tasks()->sync($params);

        /*job_id
        task_id
        price
        performer_percent
        hourly_rate*/

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

        //оновлюємо запчастини
        //Part::where('job_id', $job_id)->delete();
        //foreach ($request->PartsFields as $key => $value) {
            //dd($request->all());
            /*Part::create([
                'job_id'            => $job_id,
                'parts_storages_id' => $value['name'],
                'price'             => $value['price'],
                'quantity'          => $value['qty'],
                'code'              => $value['code'],
                'total_price'       => $value['total_price']
            ]);*/

        $params = [];
        foreach ($request->PartsFields as $value) {
            $find_name = Part::where('id', $value['name'])->first();
            if ($find_name){
                $parts = Part::firstOrCreate([
                    //'job_id'      => $job_id,
                    'name'          => $find_name->name,
                ],[
                    'retail_price'  => $value['price'],
                    'quantity'      => $value['qty'],
                    'code'          => $value['code'],
                    //'total_price'   => $value['total_price']*$value['qty']
                ]);


                //$find_task = Part::where('id', $value['name'])->first();
                $params[$value['name']] = ['job_id'=> $job_id, 'part_id' => $value['name'], 'quantity'=>$value['qty'], 'sale_price'=>$value['price']];
            }

            $find->Parts()->sync($params);
            }


        //}

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
