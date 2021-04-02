<?php

namespace App\Http\Controllers\Socialite;

use App\Http\Controllers\Controller;
use App\User;
use App\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * Take User to facebook Page for Authentication
     */
    public function redirect_to_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Get Response with User Data From facebook
     */
    public function handle_facebook_callback()
    {
        try {
            $facebook_user = Socialite::driver('facebook')->user();

            // Check if User/Vendor Exists
            $user = User::where('email', $facebook_user->email)->first();
            $vendor = Vendor::where('email', $facebook_user->email)->first();

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

            // Flash to user session if there is an error from the provider or the code in the try block
            session()->flash('soclogin_error', "Oops! Something went wrong. Try Again!");

            return redirect()->route('.');
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
