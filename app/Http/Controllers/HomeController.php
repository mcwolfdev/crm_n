<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['job_all'] = Job::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        //return view('home',compact('job_all'));
        return view('home', $data);
    }

    public function modalView($id)
    {
        $data['task_job'] = Task::where('job_id', $id)->get();

        //return view('home',compact('job_all'));
        //return $data;
        return response()->json($data);
    }
}
