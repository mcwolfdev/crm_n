<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];

    public function getTaskCatalogue()
    {
        return $this->hasOne(task_catalogue::class, 'id','task_catalogue_id');
    }
}
