<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function vendor()
    {
        $this->belongsTo('App\Vendor');
    }

    public function item()
    {
        $this->hasMany('App\Item');
    }
    //
}
