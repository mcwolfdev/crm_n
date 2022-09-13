<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Brand(){
        return $this->belongsTo(Brand::class);
    }

    public function Moodel(){
        return $this->belongsTo(Moodel::class);
    }
}
