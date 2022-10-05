<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Job;
use App\Models\Part;
use App\Models\Task;

class TestController extends Controller
{
    public function index2(){
        echo "DB TEST <br>".PHP_EOL;

        // Создадим юзеров
        if (User::all()->count()<3){
            $fs = User::factory()
                ->count(10)
                ->create();
        }

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
                'status'=>'new',
                'addition'=>'Хз зачем это поле',
                'pay'=>'0',
                'done_at'=>''
            ]
        );
        echo "Создали job <br>".PHP_EOL;
        echo '(belongsTo) Job->Client->name - '.$job->Client->name .'<br>'.PHP_EOL;
        echo '(hasOne) Job->Performer->name - '.$job->Performer->name .'<br>'.PHP_EOL;
        echo '(belongsTo) Job->Creator->name - '.$job->Creator->name .'<br>'.PHP_EOL;
        echo 'Посмотри в чем разница в моделе в перформере и креаторе. Когда все по стандарту у нас нужен белонгсТу. Но с перформером тут немного нестандартно<br>'.PHP_EOL;
        echo '(belongsTo) Job->Vehicle->frame_number - '.$job->Vehicle->frame_number .'<br>'.PHP_EOL;
        echo '(belongsTo) Job->Vehicle->frame_number - '.$job->Vehicle->frame_number .'<br>'.PHP_EOL;

        // Создадим партсы
        $part = Part::firstOrCreate([
            'name'=>'Электроусилитель Поляриса',
            'purchase_price'=> 666.88,
            'retail_price' => 777.01,
            'quantity'=>1,
            'unit'=>'шт.',
            'code'=>228,
        ]);
        $part2 = Part::firstOrCreate([
            'name'=>'Матерые колодки',
            'purchase_price'=> 228.88,
            'retail_price' => 333.01,
            'quantity'=>1,
            'unit'=>'шт.',
            'code'=>88,
        ]);
        $part3 = Part::firstOrCreate([
            'name'=>'Баллон с закисью гороха',
            'purchase_price'=> 888.88,
            'retail_price' => 1000,
            'quantity'=>1,
            'unit'=>'шт.',
            'code'=>99,
        ]);
        // Создадим джобсы
        $task = Task::firstOrCreate([
            'name'=>'Тачку на прокачку',
            'price'=>666,
            'performer_percent'=>80,
            'hourly_rate'=> 1000,
            'code'=>1,
        ]);
        $task1 = Task::firstOrCreate([
            'name'=>'Установка электроусилителя',
            'price'=>999,
            'performer_percent'=>70,
            'hourly_rate'=> 2000,
            'code'=>120,
        ]);
        $task2 = Task::firstOrCreate([
            'name'=>'Замена колодок',
            'price'=>500,
            'performer_percent'=>80,
            'hourly_rate'=> 500,
            'code'=>10,
        ]);
        $task3 = Task::firstOrCreate([
            'name'=>'Установка закиси гороха',
            'price'=>50000,
            'performer_percent'=>50,
            'hourly_rate'=> 10000,
            'code'=>666,
        ]);

        // Приаттачим к джобсу партсы и таски и нашампурим значений
        $job->Parts()->sync( [$part->id => ['sale_price'=>100000, 'quantity'=>1]] );
        $job->Tasks()->sync([
                $task->id => ['price'=>10000, 'code'=>1, 'performer_percent'=>30, 'hourly_rate'=>2000],
                $task1->id => ['price'=>2000, 'code'=>120, 'hourly_rate'=>2000]
        ]);

        // Sync - это привязка всего сразу а в массивах - нашампуривание данных
        // attach - добавление одного - если сделать два одинаковых аттача - то будет дублирование данных
        // вообщем почитаешь

        $job->Parts()->sync([]);


        echo $vehicle->Moodel->Brand->name;

    }

    public function index(){
        $task = Task::find(1);
        $task->delete();
    }
}
