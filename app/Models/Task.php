<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];

    public function Jobs(){
        return $this->belongsToMany(Job::class)->withTimestamps();
    }

}
