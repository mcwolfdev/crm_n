<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function actionFindJob($id)
    {
        $data['job_all'] = Job::orderBy('status', 'ASC')->orderBy('id', 'DESC')->where('id',$id)->get();
        //return view('home',compact('job_all'));
        return view('home', $data);
    }

    public function actionTakeJob($id)
    {
        $job = Job::findOrFail($id);

        if ($job->performer_id == 0) {
            $job->performer_id = Auth::user()->id;
            $job->status       = 'on-the-job';

            $job->save();
        }

        return back()->with('success', 'on-the-job');
        //return redirect()->route('home');
    }

    public function actionSuspend($id)
    {
        $job = Job::findOrFail($id);

            $job->status = 'pending';
            $job->save();

        return back()->with('success', 'pending');
        //return redirect()->route('home');
    }

    public function actionToWork($id)
    {
        $job = Job::findOrFail($id);

        if ($job->performer_id == Auth::user()->id || $job->creator_id == Auth::user()->id) {
            $job->status = 'on-the-job';
            $job->save();
        }

        return back()->with('success', 'on-the-job');
        //return redirect()->route('home');
    }

    public function actionDone($id)
    {
        $job = Job::findOrFail($id);

            $job->status  = 'done';
            $job->done_at = date("Y-m-d H:i:s");
            $job->save();

        return back()->with('success', 'done');
        //return redirect()->route('home');
    }

    public function actionClose($id)
    {
        $job = Job::findOrFail($id);

            $job->status = 'closed';
            $job->save();

        return back()->with('success', 'closed');
        //return redirect()->route('home');
    }
}
