<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class EventController extends Controller
{

    public function index(Request $request)
    {

        /*if($request->ajax()) {

            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'url', 'backgroundColor', 'borderColor']);

            return response()->json($data);
        }

        return view('fullcalender');*/


            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'backgroundColor', 'borderColor']);

            return response()->json($data);


        //return view('fullcalender');
        //return view('dashboard');
    }


    public function ajax(Request $request)
    {

        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'backgroundColor' => $request->event_tag,
                    'borderColor' => $request->event_tag,
                ]);

                //return response()->json($event);
                //return back();
                return back()->with('success', 'Подію '.$request->title.' створено.');
                break;

            case 'update':
                if ($request->end == 'Invalid date')
                {
                    $end = $request->start;
                }
                else
                {
                    $end = $request->end;
                }

                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $end,
                    'url' => $request->url,
                    'backgroundColor' => $request->backgroundColor,
                    'borderColor' => $request->borderColor,
                ]);

                return response()->json($event);
                break;
                /*$event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;*/

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }
}
