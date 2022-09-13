<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Job;

class TestController extends Controller
{
    public function index(){
        echo "DB TEST <br>".PHP_EOL;

        $client = Client::firstOrCreate(['name'=>'Спортов Лох Спортыч', 'phone'=>'+380992282828', 'comment'=>'Больной ублюдок. Говорит что лишай это лучшая техника.']);

        $brp = Brand::firstOrCreate(['name'=>'BRP']);
        $xtp1000 = $brp->Models()->firstOrCreate(['name'=>'Outlander XTP 1000']);

        $vehicle = $xtp1000->Vehicles()->firstOrCreate(['client_id'=>$client->id, 'frame_number'=>'2282828', 'mileage'=>'2280', 'mileage_type'=>'Пробег крутости']);
        // Или создадим вехикл через клиента
        $vehicle = $client->Vehicles()->firstOrCreate(['moodel_id'=>$xtp1000->id, 'frame_number'=>'2282828', 'mileage'=>'2280', 'mileage_type'=>'Пробег крутости']);






        $job = Job::firstOrCreate(
            [   'client_id'=>$client->id,
                'vehicle_id' => $vehicle->id,
                'creator_id'=>1,
                'performer_id'=>2,
                'status'=>'В работе',
                'addition'=>'Хз зачем это поле',
                'pay'=>'Тоже хз почему оно инт',
                'done_at'=>'Всот это лучше сделать датой'
            ]
        );
        echo "Создали job <br>".PHP_EOL;
        echo '(belongsTo) Job->Client->name - '.$job->Client->name .'<br>'.PHP_EOL;
        echo '(hasOne) Job->Performer->name - '.$job->Performer->name .'<br>'.PHP_EOL;
        echo '(belongsTo) Job->Creator->name - '.$job->Creator->name .'<br>'.PHP_EOL;
        echo 'Посмотри в чем разница в моделе в перформере и креаторе. Когда все по стандарту у нас нужен белонгсТу. Но с перформером тут немного нестандартно<br>'.PHP_EOL;
        echo '(belongsTo) Job->Vehicle->frame_number - '.$job->Vehicle->frame_number .'<br>'.PHP_EOL;
        echo '(belongsTo) Job->Vehicle->frame_number - '.$job->Vehicle->frame_number .'<br>'.PHP_EOL;



    }
}
