<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['name', 'type', 'post_id'];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    //
}
