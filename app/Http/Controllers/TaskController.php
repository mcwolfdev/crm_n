<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Part;
use App\Models\Settings;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index()
    {
        if (Task::all()->count() == 0)
        {
            $data['count_id'] = 0;
        }
        $data['count_id'] = Task::all()->count()+1;
        $data['hourly_rate'] = Settings::where('name', 'hourly_rate')->first();
        $data['tasks'] = Task::all();
        return view('service.index_service', $data);
    }

    public function add_new_task(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'      => 'required|unique:tasks',
            'name'       => 'required|unique:tasks',
        ],
            $messages = [
                'name.required' => 'Поле <Назва> не може бути порожнім!',
                'name.unique' => 'Товар з таким ім\'ям вже існує!',
                'code.required' => 'Поле <Код> не може бути порожнім!',
                'code.unique' => 'Товар з таким кодом вже існує!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $code   = $request->input('code');
        $name   = $request->input('name');
        $price   = $request->input('price');
        $hourly_rate   = $request->input('hourly_rate');
        $performer_percent   = $request->input('performer_percent');

        $result = Task::create([
            'name'                => $name,
            'code'                => $code,
            'price'               => $price,
            'hourly_rate'         => $hourly_rate,
            'performer_percent'   => $performer_percent,
        ]);
        return back()->with('success', 'Послугу '.$result->name.' створено.');
    }

    public function edit_task(Request $request)
    {
        $this_task = Task::where('id', $request->input('id'))->first();
        if ($this_task)
        {

            $validator = Validator::make($request->all(), [
                'code' => 'required|unique:tasks,code,' . $this_task->id . ',id',
                'name' => 'required|unique:tasks,name,' . $this_task->id . ',id',
            ],
                $messages = [
                    'name.required' => 'Поле <Назва> не може бути порожнім!',
                    'name.unique' => 'Товар з таким ім\'ям вже існує!',
                    'code.required' => 'Поле <Код> не може бути порожнім!',
                    'code.unique' => 'Товар з таким кодом вже існує!',
                ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->all())->withInput();
            }

            $id = $request->input('id');
            $code = $request->input('code');
            $name = $request->input('name');
            $price = $request->input('price');
            $hourly_rate = $request->input('hourly_rate');
            $performer_percent = $request->input('performer_percent');

            $find_task = Task::findOrFail($id);

            if ($find_task) {
                $find_task->code = $code;
                $find_task->name = $name;
                $find_task->price = $price;
                $find_task->hourly_rate = $hourly_rate;
                $find_task->performer_percent = $performer_percent;
                $find_task->save();
                return back()->with('success', 'Послугу ' . $name . ' відредаговано.');
            }
        }
        return back()->withErrors('Щось пішло не так :(');
    }

}
