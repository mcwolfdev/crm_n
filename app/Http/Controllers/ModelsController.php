<?php

namespace App\Http\Controllers;


use App\Models\Moodel;


class ModelsController extends Controller
{

    public function index()
    {
        $data['models_all'] = Moodel::all();

        return view('model.index_model', $data);
    }

}
