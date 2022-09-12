<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client_vehicle extends Model
{
    use HasFactory;

    public function getClient(){
        return $this->hasOne(Client::class, 'id' );
    }

    public function getVinFrame(){
        return $this->hasOne(Vehicle::class, 'id');
    }

    public function getBrand(){
        return $this->hasOne(brand::class, 'id');
    }

    public function getModels(){
        return $this->hasOne(models::class, 'brand_id');
    }
}
