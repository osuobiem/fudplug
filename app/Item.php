<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function menu()
    {
        $this->belongsTo('App\Menu');
    }
    //
}
