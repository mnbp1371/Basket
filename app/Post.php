<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\UrlRoutable;

class Post extends Model
{
    public $timestamps = true;
    protected $fillable =['title' , 'content'];

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

    ////////////////////////////

    public function getRouteKeyName()
    {

        return 'urltitle';
    }

    public function comments()
    {

        return $this->hasMany(Comment::class);
    }

     public  function tag()
     {
        return $this->belongsToMany(Tag::class);

     }
     public  function hasSelected($id)
     {
        return in_array($id,$this->tag()->pluck('id')->toArray());

     }


    public  function users()
    {
        return $this->belongsTo(User::class);

    }

//

}
