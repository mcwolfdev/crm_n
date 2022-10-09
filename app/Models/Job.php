<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];

    public function Client(){
        return $this->belongsTo(Client::class);
    }

    public function Performer()
    {
        return $this->hasOne(User::class, 'id', 'performer_id');
    }

    public function Vehicle(){
        return $this->belongsTo(Vehicle::class);
    }


    public function Creator(){
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function Tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('price', 'performer_percent', 'hourly_rate', 'code')->withTimestamps();
    }

    public function Parts(){
        return $this->belongsToMany(Part::class)->withPivot('sale_price', 'quantity')->withTimestamps();
    }



    //////////
    ///
    ///
    ///
    ///
    ///
    ///
    ///
    ///
/*    public function getTaskCatalogue()
    {
        return $this->hasMany(taskcatalogue::class, 'id','task_catalogue_id');
    }*/

    public function getParts()
    {
        return $this->hasMany(Part::class, 'job_id');
    }

    public function getClientFullName()
    {
        if ($this->Client) {
            return $this->client->name;
        }
        return '';
    }

    public function getClientPhoneNumber()
    {
        if ($this->client) {
            return $this->client->phone;
        }
        return '';
    }

    public function getVehicleFrameNumber()
    {
        if ($this->VinFrame) {
            return $this->VinFrame->frame_number;
        }
        return '';
    }

    public function getModelName()
    {
        if ($this->VinFrame) {
            return $this->VinFrame->Models->name;
        }
        return '';
    }


    public function getBrandName()
    {
        if ($this->VinFrame && $this->VinFrame->Models && $this->VinFrame->Models->Brand) {
        //if ($this->Brand) {
            //return $this->Brand->name;
            return $this->VinFrame->Models->Brand->name;
        }
        return '';
    }

    public function getCreatorName()
    {
        if ($this->Creator) {
            return $this->Creator->name;
        }
        return '';
    }

    public function getPerformerName()
    {
        if ($this->performer) {
            return $this->performer->name;
        }
        return '';
    }

    public function getPerformerPrice()
    {
        $performerPrice = 0;

/*        if (! isset($this->tasks)) {
            $this->tasks;
        }*/

        foreach ($this->tasks as $task) {
            if ($task->pivot->price != 0 && $task->pivot->performer_percent != 0) {
                $performerPrice += $task->pivot->price * ($task->pivot->performer_percent / 100);
            }
        }

        return $performerPrice;
    }

    public function isAllJobsHasPerformerPrice()
    {
        $r = true;
        foreach ($this->tasks as $task) {
            if ($task->performer_percent == 0) {
                $r = false;
            }
        }
        return $r;
    }

    public function getTaskTotalPrice()
    {
        $TasktotalPrice = 0;

        /*        if (! isset($this->tasks)) {
                    $this->tasks;
                }*/

        foreach ($this->tasks as $task) {
            if ($task->pivot->price != 0) {
                $TasktotalPrice += $task->pivot->price;
            }
        }

        return $TasktotalPrice;
    }

    public function getPartsTotalPrice()
    {
        $PartstotalPrice = 0;


        foreach ($this->Parts as $part) {
            if ($part->pivot->sale_price != 0 && $part->quantity != 0) {
                $PartstotalPrice += ($part->pivot->sale_price * $part->quantity);
            }
        }

        return $PartstotalPrice;
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;

        /*if (! isset($this->tasks)) {
            $this->tasks;
        }*/

        foreach ($this->Tasks as $task) {
            if ($task->pivot->price != 0) {
                $totalPrice += $task->pivot->price;
            }
        }

        /*if (! isset($this->getParts)) {
            $this->getParts;
        }*/

        foreach ($this->Parts as $part) {
            if ($part->pivot->sale_price != 0 && $part->quantity != 0) {
                $totalPrice += ($part->pivot->sale_price * $part->quantity);
            }
        }

        return $totalPrice;
    }

    public function num2str($num) {
        $nul='нуль';
        $ten=array(
            array('','один','два','три','чотири','п\'ять','шість','сімь', 'вісім','дев\'ять'),
            array('','одна','дві','три','чотири','п\'ять','шість','сім', 'вісім','де\'вять'),
        );
        $a20=array('десять','одинадцять','дванадцять','тринадцять','чотирнадцять' ,'п\'ятнадцять','шістнадцять','сімнадцять','вісімнадцять','дев\'ятнадцять');
        $tens=array(2=>'двадцять','тридцять','сорок','п\'ятдесят','шістдесят','сімдесят' ,'вісімдесят','дев\'яносто');
        $hundred=array('','сто','двісті','триста','чотириста','п\'ятсот','шістсот', 'сімсот','вісімсот','дев\'ятсот');
        $unit=array( // Units
            array('копійка' ,'копійки' ,'копійок',	 1),
            array('гривня'   ,'гривні'   ,'гривень'    ,0),
            array('тисяча'  ,'тисячі'  ,'тисяч'     ,1),
            array('мільйон' ,'мільйона','мільйонів' ,0),
            array('мільярд','мільярда','мільярдів',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    private function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

}
