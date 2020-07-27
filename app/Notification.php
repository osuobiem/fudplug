<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function vendor()
    {
        $this->belongsTo('App\Vendor');
    }

    public function post()
    {
        $this->belongsTo('App\Post');
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function comment()
    {
        $this->belongsTo('App\Comment');
    }

    public function like()
    {
        $this->belongsTo('App\Like');
    }
    //
}
