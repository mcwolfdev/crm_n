<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moodel extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'moodels';



    public function Brand(){
        return $this->belongsTo(Brand::class);
    }

    public function Vehicles(){
        return $this->hasMany(Vehicle::class);
    }


}
