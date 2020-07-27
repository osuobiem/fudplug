<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function post()
    {
        $this->belongsTo('App\Post');
    }

    public function vendor()
    {
        $this->belongsTo('App\Vendor');
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function notification()
    {
        $this->belongsTo('App\Notification');
    }
    //
}
