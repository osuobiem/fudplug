<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function vendor()
    {
        $this->belongsTo('App\Vendor');
    }

    public function notification()
    {
        $this->hasMany('App\Notifications');
    }

    public function media()
    {
        $this->hasMany('App\Media');
    }

    public function comment()
    {
        $this->hasMany('App\Comment');
    }

    public function like()
    {
        $this->hasMany('App\Like');
    }
    //
}
