<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getToPay($user_id)
    {
        $toPay = 0;

        $job_all = Job::where('pay', 0)->where('performer_id', $user_id)->get();
        //dd($job_all);
        foreach ($job_all as $job) {
            $toPay += $job->getPerformerPrice();
        }

        return $toPay;
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function Roles(){
        return $this->belongsToMany(Role::class)->withPivot('role_id');
    }

    public function attachRole($role_name){
        $role = Role::getUserRole();
        if ($role_name=='admin') $role = Role::getAdminrole();
        $this->Roles()->attach($role->id);
    }

    public function isAdmin(){
        $admin = $this->Roles()->where('name','admin')->first();
        //var_dump($admin); die();
        if ($admin) return true;
        return false;

    }

    public function isUser(){
        $user = $this->Roles()->where('name','user')->first();
        if ($user) return true;
        return false;

    }

}
