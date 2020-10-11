<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'quantity', 'image', 'status', 'type',
    ];

    public function menu()
    {
        return $this->belongsTo('App\Vendor');
    }
    //
}
