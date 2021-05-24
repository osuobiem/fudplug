<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaVendor extends Model
{
    // Table name
    protected $table = 'area_vendor';

    protected $fillable = ['area_id', 'vendor_id'];
}
