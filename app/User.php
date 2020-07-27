<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function area()
    {
        $this->belongsTo('App\Area');
    }

    public function order()
    {
        $this->hasMany('App\Order');
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
}
