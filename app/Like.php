<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['liker_type'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function notification()
    {
        return $this->belongsTo('App\Notification');
    }
    //
}
