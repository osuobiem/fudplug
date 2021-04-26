<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function notification()
    {
        return $this->hasMany('App\Notification');
    }

    public function media()
    {
        return $this->hasMany('App\Media');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }

    public function tags() {
        return $this->hasMany('App\PostTag');
    }
    //
}
