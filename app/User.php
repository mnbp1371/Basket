<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rols()
    {

        return $this->belongsTo(Rol::class);
    }

     public function posts()
        {

            return $this->hasMany(Post::class);
        }


    //convere date to persian date with Defining An Accessor
    public function getDates()
    {
        return ['created_at'];
    }


    public function getCreatedAtAttribute()
    {

        $time = Carbon::parse($this->attributes['created_at'])->toDateTimeString();
        return new Verta($time);

    }

     public function orders()
            {

                return $this->hasMany(Order::class);
            }

}