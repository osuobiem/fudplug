<?php

namespace App\Http\Controllers;

use App\State;

class ViewController extends Controller
{
    /**
     * Feed/Home Page
     */
    public function feed()
    {
        $states = State::orderBy('name')->get();
        return view('feed', ['states' => $states]);
    }
}
