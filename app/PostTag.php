<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    //  Table name
    protected $table = 'post_tags';

    // Relationship with Item
    public function item() {
        return $this->belongsTo('App\Item');
    }
    // Relationship with Post
    public function post() {
        return $this->belongsTo('App\Post');
    }
}
