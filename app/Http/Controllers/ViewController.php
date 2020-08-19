<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * Home Page
     */
    public function home()
    {
        $states = State::orderBy('name')->get();

        return view('page-container', ['states' => $states]);
    }

    /**
     * Feed Sub Page
     */
    public function feed()
    {
        return view('feed');
    }
}
