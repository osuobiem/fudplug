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

    /**
     * Verify Page
     */
    public function verify_page()
    {
        if (session()->has('verify_email')) {
            $user_email = session('verify_email');
            return view('auth.verify', compact('user_email'));
        } else {
            return redirect()->route('.');
        }
    }

    /**
     * Expired Link Page
     */
    public function expired_link_page()
    {
        if (session()->has('verify_email')) {
            $user_email = session('verify_email');
            return view('auth.expired-link', compact('user_email'));
        } else if (session()->has('forgot_password')) {
            // Delete the forgot_password session variable after successful verification
            session()->forget('forgot_password');

            return view('auth.passwords.expired-link');
        } else {
            return redirect()->route('.');
        }
    }
}
