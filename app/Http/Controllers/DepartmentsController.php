<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{

    public function index()
    {
        $data['departments_all_count'] = Department::all()->count();
        $data['departments_all'] = Department::paginate(20);

        return view('departments.index_departments', $data);
    }

    public function department_new(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'department_name'       => 'required',
            'department_details'    => 'required',
            'department_address'    => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $department_name      = $request->input('department_name');
        $department_details   = $request->input('department_details');
        $department_address   = $request->input('department_address');


        Department::create([
            'name'      => $department_name,
            'details'   => $department_details,
            'address'   => $department_address,
        ]);

        return response()->json(['success'=>'Новий відділ створено']);
    }

    public function department_edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'department_name_edit'       => 'required',
            'department_details_edit'    => 'required',
            'department_address_edit'    => 'required',
        ],
        $messages = [
            'department_name_edit.required' => 'Поле <Ім\'я відділу> не може бути порожнім!',
            'department_details_edit.required' => 'Поле <Реквізити> не може бути порожнім!',
            'department_address_edit.required' => 'Поле <Адреса відділу> не може бути порожнім!',
        ]);

        if ($validator->fails())
        {
            //return response()->json(['errors'=>$validator->errors()->all()]);
            //return back()->with('errors', '$validator->errors()->all()');
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $department_id        = $request->input('department_id');
        $department_name      = $request->input('department_name_edit');
        $department_details   = $request->input('department_details_edit');
        $department_address   = $request->input('department_address_edit');


        $dept = Department::findOrFail($department_id);
        if ($dept) {
            $dept->name = $department_name;
            $dept->details = $department_details;
            $dept->address = $department_address;
            $dept->save();
            //return response()->json(['success'=>'Відділ '.$department_name.' відредаговано']);
            return back()->with('success', 'Відділ '.$department_name.' відредаговано');
        }

        //return response()->json(['errors'=>'Помилка :(']);
        //return back()->with('errors', 'Помилка :(');
        return back()->withErrors('Помилка :(');

    }

    public function department_delete($id)
    {
        $find = Department::where('id', $id)->first();
        $find->delete();
        //return back()->with('success', 'closed');
        return back();
    }
}
