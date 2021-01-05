<?php

namespace App\Http\Controllers;

use App\Notification;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
