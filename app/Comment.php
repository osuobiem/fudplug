<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'commentor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'commentor_id', 'id');
    }

    public function notification()
    {
        return $this->belongsTo('App\Notification');
    }
    //
}
