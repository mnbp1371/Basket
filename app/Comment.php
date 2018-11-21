<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
class Comment extends Model
{
    protected $guarded =[];

    public function posts()
    {

        return $this->belongsTo(Post::class);
    }

    public function getDates()
    {
        return ['created_at'];
    }


    public function getCreatedAtAttribute()
    {

        $time = Carbon::parse($this->attributes['created_at'])->toDateTimeString();
        return new Verta($time);

    }

}
