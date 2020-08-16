<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }

    public function like()
    {
        return $this->belongsTo('App\Like');
    }
    //
}
