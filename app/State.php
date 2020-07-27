<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function area()
    {
        $this->hasMany('App\Area');
    }
    //
}
