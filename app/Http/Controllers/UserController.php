<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\Client;
use App\Models\client_vehicle;
use App\Models\Department;
use App\Models\Job;
use App\Models\Model;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class UserController extends Controller
{
    public $html;

    public function index()
    {
        $data['user_all_count'] = User::all()->count();
        $data['user_all'] = User::paginate(20);


        return view('user.index_user', $data);
    }

    public function user_edit($id)
    {
        $data['user'] = User::find($id);
        $data['role'] = Role::all();
        $data['departments'] = Department::all();
        return view('user.user_edit', $data);
    }

    public function user_edit_proces(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_name'    => 'required',
            'user_email'    => 'required',
            //'user_password' => 'required',
            'Role'          => 'required',
            'department'    => 'required',
        ],
            $messages = [
                'user_naame.required'    => 'Поле <Ім\'я користувача> не може бути порожнім!',
                'user_email.required'    => 'Поле <Е-мейл> не може бути порожнім!',
                //'user_password.required' => 'Поле <Пароль> не може бути порожнім!',
                'Role.required'          => 'Поле <Роль> не може бути порожнім!',
                'department.required'    => 'Поле <Відділ> не може бути порожнім!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $user_id        = $request->input('user_id');
        $user_name      = $request->input('user_name');
        $user_email     = $request->input('user_email');
        $user_password  = $request->input('user_password');
        $user_role      = $request->input('Role');
        $department     = $request->input('department');
        $user_work      = $request->input('work') ? true : false;


        $user = User::findOrFail($user_id);

        //dd($user->attachRole($user_role));
        if ($user) {
            $user->name = $user_name;
            $user->email = $user_email;
            if (!empty($user_password))
            {
                $user->password = Hash::make($user_password);
            }
            $user->department_id = $department;
            $user->Roles()->sync(['role_id'=>$user_role]);
            $user->hidden = $user_work;
            if ($user_work == true)
            {
                $user->dismissed = Carbon::now();
            }
            elseif ($user_work == false)
            {
                $user->dismissed = null;
            }

            $user->save();

            return back()->with('success', 'Дані користувача '.$user_name.' відредаговано');
        }

        return back()->withErrors('Помилка :(');
    }

    public function user_pay($id)
    {
        $data['id'] = $id;
        $data['user'] = User::where('id', $id)->first();
        $data['jobs'] = Job::where('performer_id', $id)->where('pay', 0)->get();
        return view('user.pay_user', $data);
    }


}
