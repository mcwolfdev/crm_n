<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Carbon\Carbon;
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
        if (Auth::user()->isAdmin() == true)
        {
            $data['job_all'] = Job::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }
        elseif ((Auth::user()->isAdmin() == false))
        {
            $data['job_all'] = Job::where('department_id', Auth::user()->department()->id)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }
        //return view('home',compact('job_all'));
        //substr($jobs->updated_at, 11)

        foreach ($data['job_all'] as $jobs)
        {
            if ($jobs->updated_at < Carbon::now()->subMinutes(5)) //TODO зробити таблицю з налаштуваннями для завепшення сесії
            {
                //dd($jobs->id,'менше');
                $jobs->user_name = null;
                $jobs->save();
            }
        }

        //dd(Carbon::now()->subMinutes(30));
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
