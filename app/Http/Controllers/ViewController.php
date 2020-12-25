<?php

namespace App\Http\Controllers;

use App\Notification;
use App\State;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * Feed/Home Page
     */
    public function feed()
    {
        $states = State::orderBy('name')->get();
        $ncount = '';

        if (!Auth::guard('vendor')->guest()) {
            $owner = Auth::user('vendor');
            $ncount = Notification::where('owner_id', $owner->id)->where('status', 0)->count();
        } elseif (!Auth::guard('user')->guest()) {
            $owner = Auth::user('user');
            $ncount = Notification::where('owner_id', $owner->id)->where('status', 0)->count();
        }

        return view('feed', ['states' => $states, 'ncount' => $ncount]);
    }
}
