<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function state()
    {
        $this->belongsTo('App\State');
    }

    public function vendor()
    {
        $this->hasMany('App\Vendor');
    }

    public function user()
    {
        $this->hasMany('App\User');
    }
    //
}
