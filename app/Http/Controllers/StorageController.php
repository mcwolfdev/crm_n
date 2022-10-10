<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'code'          => 'required|unique:parts',
            'name'          => 'required|unique:parts',
        ],
            $messages = [
                'name.required' => 'Поле <Ім\'я> не може бути порожнім!',
                'name.unique' => 'Товар з таким ім\'ям вже існує!',
                'code.required' => 'Поле <Код> не може бути порожнім!',
                'code.unique' => 'Товар з таким кодом вже існує!',
            ]);

        if ($validator->fails())
        {
            return back()->withErrors( $validator->errors()->all())->withInput();
        }

        $code       = $request->input('code');
        $name       = $request->input('name');
        $article    = $request->input('article');

        if ($article == null)
        {
            $article = '#';
        }

        $result = Part::create([
            'name'   => $name,
            'code'   => $code,
            'article'   => $article,
        ]);

        return back()->with('success', 'Товар ' . $result->name . ' створено.');
    }

    public function edit_part(Request $request)
    {
        $this_part = Part::where('id', $request->input('id'))->first();
        if ($this_part) {
            $validator = Validator::make($request->all(), [
                'code'      => 'required|unique:parts,code,'. $this_part->id . ',id',
                'name'      => 'required|unique:parts,name,'. $this_part->id . ',id',
                'article'   => 'required|unique:parts,article,'. $this_part->id . ',id',
                'unit'      => 'required',
            ],
                $messages = [
                    'name.required' => 'Поле <Ім\'я> не може бути порожнім!',
                    'name.unique' => 'Товар з таким ім\'ям вже існує!',
                    'code.required' => 'Поле <Код> не може бути порожнім!',
                    'code.unique' => 'Товар з таким кодом вже існує!',
                    'article.required' => 'Поле <Артикул> не може бути порожнім!',
                    'article.unique' => 'Товар з таким артикулом вже існує!',
                    'unit.required' => 'Поле <Кількість> не може бути порожнім!',
                ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->all())->withInput();
            }

            $id = $request->input('id');
            $code = $request->input('code');
            $name = $request->input('name');
            $article = $request->input('article');
            $unit = $request->input('unit');

            $find_part = Part::findOrFail($id);

            if ($article == null) {
                $article = '#';
            }

            if ($find_part) {
                $find_part->code = $code;
                $find_part->name = $name;
                $find_part->article = $article;
                $find_part->unit = $unit;

                $find_part->save();
                return back()->with('success', 'Товар ' . $name . ' відредаговано.');
            }
        }
        return back()->withErrors('Щось пішло не так :(');
    }
}
