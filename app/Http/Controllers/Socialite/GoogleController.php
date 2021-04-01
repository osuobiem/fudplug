<?php

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use App\User;
use App\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Take User to Google Page for Authentication
     */
    public function redirect_to_google()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Get Response with User Data From Google
     */
    public function handle_google_callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            // dd($user->email);

            // Check if User/Vendor Exists
            $user = User::where('email', $google_user->email)->first();
            $vendor = Vendor::where('email', $google_user->email)->first();

            if ($user == null && $vendor == null) {
                session()->flash('soclogin_status', false);

                return redirect()->route('.');
            }

            $user_data = $user == null ? $vendor : $user;

            // Check if User/Vendor Email is Verified
            if ($user_data->email_verified != 1) {
                // Add user email to session to be used for resending verification emails
                session()->put('verify_email', [$user_data->email, "unverified_login"]);

                return redirect()->route('verify-email');
            }

            // Log user in
            if ($user_data->getTable() == "users") {
                $this->user_login($user_data->id);

                session()->flash('soclogin_status', true);

                return redirect()->route('.');
            } else {
                $this->vendor_login($user_data->id);

                session()->flash('soclogin_status', true);

                return redirect()->route('.');
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Attempt to Login Vendor
     * @return bool
     */
    public function vendor_login($vendor_id)
    {
        // Attempt login with id
        $attempt = Auth::guard('vendor')->loginUsingId($vendor_id);

        if ($attempt) {
            return true;
        }

        return false;
    }

    /**
     * Attempt to Login User
     * @return bool
     */
    public function user_login($user_id)
    {
        // Attempt login with id
        $attempt = Auth::guard('user')->loginUsingId($user_id);

        if ($attempt) {
            return true;
        }

        return false;
    }
}
