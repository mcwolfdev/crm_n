<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];

    public function getPartsStorages()
    {
        return $this->hasOne(parts_storage::class, 'id','parts_storages_id');
    }
}
