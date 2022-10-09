<?php

namespace App\Http\Controllers;

use App\Models\vehicle;

class VehicleController extends Controller
{

    public function index()
    {
        $data['vehicle_all'] = vehicle::all();

        return view('vehicle.index_vehicle', $data);
    }

}
