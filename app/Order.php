<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    //
}
