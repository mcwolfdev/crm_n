<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['model_id', 'frame_number', 'mileage'];

    public function Brand(){
        return $this->hasOne(brand::class, 'id', 'brand_id');
    }

    public function Models(){
        return $this->hasOne(models::class, 'id', 'model_id');
    }
}
