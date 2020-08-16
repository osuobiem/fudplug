<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function vendor()
    {
        return $this->hasMany('App\Vendor');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }
    //
}
