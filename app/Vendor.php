<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    public function area()
    {
        $this->belongsTo('App\Area');
    }

    public function notification()
    {
        $this->hasMany('App\Notification');
    }

    public function post()
    {
        $this->hasMany('App\Post');
    }

    public function comment()
    {
        $this->hasMany('App\Comment');
    }

    public function like()
    {
        $this->hasMany('App\Like');
    }

    public function menu()
    {
        $this->hasOne('App\Menu');
    }

    public function order()
    {
        $this->hasMany('App\Order');
    }
    //
}
