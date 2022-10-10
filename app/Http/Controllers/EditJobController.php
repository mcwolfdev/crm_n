<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Job;
use App\Models\Moodel;
use App\Models\Part;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $data['freeze'] = $find->user_name;

/*        if ($find->user_name != Auth::user()->name)
        {
            return back()->withErrors('Щось пішло не так. Ви не можете зараз редагувати :(');
        }*/

        //Записати ім"я користувача який відкрив роботу
        if ($find->user_name == null)
        {
            //Log::info('$find->user_name == null'.Auth::user()->name.'.');
            $find->user_name = Auth::user()->name;
            $find->save();
        }

        $find_user_freeze = User::where('name' , $find->user_name)->first();
        //Якщо такого користувача немає
        if ($find_user_freeze == null)
        {
            //return back()->withErrors('Такого користувача немає в БД.');
            //return back()->with('error', 'Такого користувача немає в БД.');
            $find->user_name = Auth::user()->name;
            $find->save();
            $find_user_freeze = Auth::user()->name;
        }

        if (!empty($find->user_name) && $find_user_freeze->isOnline() == 0)
        {
            $find->user_name = Auth::user()->name;
            $find->save();
        }


        $data['job'] = $find;
        $data['id'] = $id;
        //$data['Carbon'] = Carbon::now()->subMinutes(5); //TODO зробити таблицю з налаштуваннями для завепшення сесії
        //$data['user_freeze'] = $find_user_freeze;
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

    public function unfreeze(Request $request)
    {
        $find = Job::findOrFail($request->id);
        if (!$find){
            return view('error.404');
        }

        switch ($request->type) {
            case 'updated_name':
                $find->user_name = null;
                $find->save();
                break;

            case 'updated_at':
                $find->updated_at = Carbon::now();
                $find->save();
            default:
                # code...
                break;
        }

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

        if ($find->user_name != Auth::user()->name)
        {
            return back()->withErrors('Щось пішло не так. Ви не можете зараз редагувати :(');
        }
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

            $params[$value['name']] = ['job_id'=> $job_id, 'task_id' => $value['name'], 'price'=>$value['total_price_task'], 'performer_percent'=>$value['present'], 'hourly_rate'=>$value['hourly_rate']];
        }

        $find->Tasks()->sync($params);

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

        //Видаляємо користувача щоб міг редагувати інший
        $find->user_name = null;
        $find->save();

        return back()->with('success', 'Дані збережено.');
    }

}
