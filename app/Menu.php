<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'items', 'vendor_id',
    ];

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }
    //
}
