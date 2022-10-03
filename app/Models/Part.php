<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    public function Jobs(){
        return $this->belongsToMany(Job::class)->withTimestamps();
    }

}
