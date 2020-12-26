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
    public function feed(Request $request)
    {
        $states = State::orderBy('name')->get();
        $ncount = 0;

        if (!Auth::guard('vendor')->guest()) {
            $owner = $request->user();
            $ncount = Notification::where('owner_id', $owner->id)->where('status', 0)->count();
        } elseif (!Auth::guard('user')->guest()) {
            $owner = $request->user('user');
            $ncount = Notification::where('owner_id', $owner->id)->where('status', 0)->count();
        }

        return view('feed', ['states' => $states, 'ncount' => $ncount]);
    }
}
