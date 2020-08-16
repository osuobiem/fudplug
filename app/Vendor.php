<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function notification()
    {
        return $this->hasMany('App\Notification');
    }

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }

    public function menu()
    {
        return $this->hasOne('App\Menu');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }
    //
}
