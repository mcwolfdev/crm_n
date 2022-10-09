<?php

namespace App\Http\Controllers;


use App\Models\Provisioner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProvisionerController extends Controller
{

    public function index()
    {
        $data['provisioner_all'] = Provisioner::all();

        return view('provisioner.index_provisioner', $data);
    }

    public function provisioner_edit(Request $request)
    {
        //dd($request->all());
        $provisioner = Provisioner::findOrFail($request->input('id'));

        $validator = Validator::make($request->all(), [
            'code'    => 'required|unique:provisioners,code,'.$provisioner->id.',id',
            'name'    => 'required',
            'contract' => 'required',
            'property'          => 'required',
            'contacts'    => 'required',
            //'description'    => 'required',
        ],
            $messages = [
                'code.required'     => 'Поле <Код> не може бути порожнім!',
                'code.unique' => 'Поле <Код> повинно бути унікальним!',
                'name.required'     => 'Поле <Назва> не може бути порожнім!',
                'contract.required' => 'Поле <Контракт> не може бути порожнім!',
                'property.required' => 'Поле <Реквізити> не може бути порожнім!',
                'contacts.required' => 'Поле <Контаки> не може бути порожнім!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        if ($provisioner) {
            $provisioner->code                  = $request->input('code');
            $provisioner->name                  = $request->input('name');
            $provisioner->contract              = $request->input('contract');
            $provisioner->provisioner_property  = $request->input('property');
            $provisioner->contacts              = $request->input('contacts');
            if (!empty($request->input('description')))
            {
                $provisioner->description = $request->input('description');
            }

            $provisioner->save();

            return back()->with('success', 'Дані постачальника ['.$request->input('name').'] відредаговано!');
        }

        return back()->withErrors('Помилка :(');

    }

    public function provisioner_new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'    => 'required|unique:provisioners,code',
            'name'    => 'required',
            'contract' => 'required',
            'property'          => 'required',
            'contacts'    => 'required',
        ],
            $messages = [
                'code.required'     => 'Поле <Код> не може бути порожнім!',
                'code.unique' => 'Поле <Код> повинно бути унікальним!',
                'name.required'     => 'Поле <Назва> не може бути порожнім!',
                'contract.required' => 'Поле <Контракт> не може бути порожнім!',
                'property.required' => 'Поле <Реквізити> не може бути порожнім!',
                'contacts.required' => 'Поле <Контаки> не може бути порожнім!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $provisioner = Provisioner::create([
            'code'                 => intval($request->input('code')),
            'name'                 => $request->input('name'),
            'contract'             => $request->input('contract'),
            'provisioner_property' => $request->input('property'),
            'contacts'             => $request->input('contacts'),
            'description'          => $request->input('description'),
        ]);
        if ($provisioner) {

            return back()->with('success', 'Нового постачальника ['.$request->input('name').'] створено!');
        }

        return back()->withErrors('Помилка :(');

    }

}
