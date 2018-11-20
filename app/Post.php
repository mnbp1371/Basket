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

    public function getRouteKeyName()
    {

        return 'urltitle';
    }
//

}
