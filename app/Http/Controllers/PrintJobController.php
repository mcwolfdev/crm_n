<?php

namespace App\Http\Controllers;


use App\Models\Job;

class PrintJobController extends Controller
{

    public function index($id)
    {

        $find = Job::find($id);
        if (!$find){
            return view('error.404');
        }

        $data['job'] = $find;
        $data['id'] = $id;
        $data['number'] = 0;

        $data['task_job'] = $find->Tasks()->get();//Task::where('job_id', $id)->get();
        $data['parts_job'] = $find->Parts()->get();//Part::where('job_id', $id)->get();

        return view('job.job_print', $data);
    }

}
