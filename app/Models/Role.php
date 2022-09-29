<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getRole($id){
        return self::where('id', $id)->first();
    }

    public static function getAdminrole(){
        return self::where('name', 'admin')->first();
    }

    public static function getUserRole(){
        return self::where('name', 'user')->first();
    }
}
