<?php

namespace App\Http\Controllers;

use App\State;

class StateController extends Controller
{
    /**
     * Get states
     * @param null
     */
    public function get()
    {
        return response()->json([
            'states' => State::get(),
        ]);
    }
}
