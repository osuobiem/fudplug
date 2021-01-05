<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function vendor()
    {
        return $this->belongsTo('App\Vendor', 'owner_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }
    //
}
