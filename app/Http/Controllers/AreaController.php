<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Get areas according to state
     * @param int $state_id State that area belongs to
     */
    public function get($state_id)
    {
        return response()->json([
            'areas' => Area::where('state_id', $state_id)->orderBy('name')->get()
        ]);
    }
}
