<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\User;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyController extends Controller
{
    /**
     * Method to verify email after user has clicked on generated link
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify_email($token = null)
    {
        try {
            if ($token == null) {

                session()->flash('verify_status', false);

                return redirect()->route('.');

            }

            // Get user
            $user_data = User::where('email_verification_token', $token)->first();
            $user = $user_data == null ? Vendor::where('email_verification_token', $token)->first() : $user_data;
            // $user = User::where('email_verification_token', $token)->first();

            if ($user == null) {

                session()->flash('verify_status', false);

                return redirect()->route('.');

            }

            if ($this->link_expired($user)) {
                // Add user email to session to be used for resending verification emails/links
                session()->put('verify_email', [$user->email, "expired_link"]);

                return redirect()->route('expired-link');
            }

            // Update user verification data
            $user->email_verified = 1;
            $user->email_verified_at = Carbon::now();
            $user->email_verification_token = "";
            $user->save();

            session()->flash('verify_status', true);

            // Delete the verify_email session variable after successful verification
            session()->forget('verify_email');

            return redirect()->route('.');
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Method to resend verification email
     *
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    //
    public function verification_resend(Request $request)
    {
        try {
            // Get user
            $user_data = User::where('email', $request->email)->first();
            $user = $user_data == null ? Vendor::where('email', $request->email)->first() : $user_data;

            if ($user == null) {
                return response()->json(['success' => false, 'message' => 'This account does not exist.'], 200);
            } else if ($user->email_verified == 1) {
                return response()->json(['success' => false, 'message' => 'This account has already been verified.'], 200);
            }

            if (session()->get('verify_email')[1] == "expired_link") {
                // Create and store new token
                $user->email_verification_token = Str::random(32);
                $user->save();

                // Send verification email by dispatching email job five seconds after it has been dispatched
                $job_data = ['email_type' => 'email_verification', 'user_data' => ['user' => $user, 'link' => route('verify', $user->email_verification_token)]];
                EmailJob::dispatch($job_data)->delay(now()->addSeconds(1));

                // Mail::to($user->email)->send(new VerificationEmail($user));

                // Add user email to session to be used for resending verification emails
                session()->put('verify_email', [$user->email, "registration"]);
            } else {
                // Send verification email by dispatching email job five seconds after it has been dispatched
                $job_data = ['email_type' => 'email_verification', 'user_data' => ['user' => $user, 'link' => route('verify', $user->email_verification_token)]];
                EmailJob::dispatch($job_data)->delay(now()->addSeconds(1));

                // Send verification email
                // Mail::to($user->email)->send(new VerificationEmail($user));
            }

            return response()->json(['success' => true, 'message' => 'A new mail has been sent to your email.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Try Again!'], 500);
        }
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
}
