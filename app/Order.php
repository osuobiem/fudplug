<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function vendor()
    {
        $this->belongsTo('App\Vendor');
    }

    public function user()
    {
        $this->belongsTo('App\User');
    }
    //
}
