<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Job;
use App\Models\Model;
use App\Models\Part;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class StorageController extends Controller
{

    public function index()
    {
        $data['parts'] = Part::all();
        return view('storage.index_storage', $data);
    }

    public function add_new_part(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:parts',
        ],
            $messages = [
                'name.required' => 'Поле <Ім\'я відділу> не може бути порожнім!',
                'name.unique' => 'Товар з таким ім\'ям вже існує!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $code   = $request->input('code');
        $name   = $request->input('name');

        Part::create([
            'name'   => $name,
            'code'   => $code,
        ]);
        return back();
    }

}
