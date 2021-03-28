<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show Pasword Reset View
     */
    public function show($token = null)
    {
        try {
            if ($token == null) {

                session()->flash('verify_status', false);

                return redirect()->route('.');

            }

            // Get user
            $user_data = User::where('password_reset_token', $token)->first();
            $user = $user_data == null ? Vendor::where('password_reset_token', $token)->first() : $user_data;

            if ($user == null) {
                session()->flash('verify_status', false);

                return redirect()->route('.');
            }

            if ($this->link_expired($user)) {
                // Add user email to session to be used for resending verification emails/links
                session()->put('forgot_password', [$user->email, "expired_link"]);

                return redirect()->route('expired-link');
            }

            return view('auth.passwords.reset', compact('user'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Send Password Reset Email to User on verification
     */
    public function send_mail(Request $request)
    {
        try {

            // Get validation rules
            $validate = $this->validate_rules($request);

            // Run validation
            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validate->errors(),
                ]);
            }

            // Check if User/Vendor Exists
            $user = User::where('email', $request['email'])->first();
            $user_data = $user == null ? Vendor::where('email', $request['email'])->first() : $user;

            if ($user_data == null) {
                // Return failed login response
                return response()->json([
                    'success' => false,
                    'message' => 'We can\'t find a user with that email address.',
                ]);
            }

            // Save User Password Token
            $user_data->password_reset_token = Str::random(32);
            $user_data->password_token_time = Carbon::now();
            $user_data->save();

            // Send password reset email by dispatching email job five seconds after it has been dispatched
            $job_data = ['email_type' => 'forgot_password', 'user_data' => ['user' => $user_data, 'link' => route('reset-password', $user_data->password_reset_token)]];
            EmailJob::dispatch($job_data)->delay(now()->addSeconds(1));

            return ['success' => true, 'status' => 200, 'message' => 'A password reset link has been sent to your email.'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
        }
    }

    /**
     * Password Email Link Validation Rules
     * @return object The validator object
     */
    public function validate_rules(Request $request)
    {
        // Custom login field message
        $message = [
            'email.required' => 'This field is required.',
        ];

        // Make and return validation rules
        return Validator::make($request->all(), [
            'email' => 'bail|required|email',
        ], $message);
    }

    /**
     * Check if Verification Link is Expired
     *
     * @param User $user
     * @return boolean true|false
     */
    public function link_expired($user)
    {
        // Stipulated time before expiry is 15 minutes => 900 secs
        $sti_time = 900;

        $last_updated = $user->updated_at;
        $last_updated = strtotime($last_updated);
        $current_time = time();
        $time_difference = $current_time - $last_updated;

        if ($time_difference > $sti_time) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Change User Pasword
     *
     * @param Request $request
     * @return
     */
    public function update_password(Request $request)
    {
        try {
            // Get validation rules
            $validate = $this->set_validate_rules($request);

            // Run validation
            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validate->errors(),
                ]);
            }

            // Check if User/Vendor Exists
            $user = User::where('email', $request->email)->first();
            $user_data = $user == null ? Vendor::where('email', $request->email)->first() : $user;

            if ($user_data == null) {
                // Return failed login response
                return response()->json([
                    'success' => false,
                    'message' => 'We can\'t find a user with that email address.',
                ]);
            }

            // Update password
            $user_data->password_reset_token = "";
            $user_data->password = Hash::make(strtolower($request->password));
            $user_data->save();

            return ['success' => true, 'status' => 200, 'message' => 'Password has been changed successfully.'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
        }
    }

    /**
     * Password Reset Validation Rules
     * @return object The validator object
     */
    public function set_validate_rules(Request $request)
    {
        // Custom login field message
        $message = [
            'password.required' => 'This field is required.',
        ];

        // Make and return validation rules
        return Validator::make($request->all(), [
            'password' => 'bail|required|min:6|confirmed',
        ], $message);
    }
}
