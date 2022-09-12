<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [];
    protected $guarded = [];

    public function getVehicle()
    {
        return $this->hasMany(client_vehicle::class)->get();
    }

}
