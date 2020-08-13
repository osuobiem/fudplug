<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // USER SIGN UP
    /**
     * User sign up
     * @return json
     */
    public function sign_up(Request $request)
    {
        // Get validation rules
        $validate = $this->create_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors()
            ], 400);
        }

        // Store user data
        $store = $this->cstore($request);
        $status = $store['status'];
        unset($store['status']);
        return response()->json($store, $status);
    }

    /**
     * Process user creation
     * @return array
     */
    public function cstore(Request $request)
    {
        // New user object
        $user = new User();

        // Assign user object properties
        $user->name = $request['name'];
        $user->email = strtolower($request['email']);
        $user->phone_number = $request['phone'];
        $user->password = Hash::make(strtolower($request['password']));
        $user->username = $this->generate_username($user->name);

        // Try user save or catch error if any
        try {
            $user->save();

            // Attempt login
            $this->fast_login($request);

            return ['success' => true, 'status' => 200, 'message' => 'Signup Successful'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
        }
    }

    /**
     * User Creation Validation Rules
     * @return object The validator object
     */
    private function create_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users', // email:rfc,dns should be used in production
            'phone' => 'required|numeric|digits_between:5,11|unique:users,phone_number',
            'password' => 'required|alpha_dash|min:6|max:30'
        ]);
    }
    // -------------

    // USER LOGIN/LOGOUT
    /**
     * User login without validation
     */
    public function fast_login(Request $request)
    {
        // Extract login credentials
        $credentials = $request->only(['email', 'password']);

        // Attempt Login and return status
        Auth::guard('user')->attempt($credentials, true);
    }

    /**
     * Logout User
     * @return object
     */
    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect('');
    }
    // -------------

    // GENERIC

    /**
     * Generate Username
     * @param int $name Name of User
     * @return string Generated username
     */
    public function generate_username($name)
    {
        // Get Business name first segment
        $segment = explode(' ', $name)[0];
        $segment = strtolower($segment);

        // Generate random int
        $ext = random_int(10, 9999);

        // Bind name and random int
        $username = $segment . '_' . $ext;

        // Check if username violates fudplug username policy
        if (!preg_match('/^[a-z_0-9A-Z]+$/', $username)) {
            // Randomize new username again
            $post = random_int(10, 9999);
            $username = 'fud_user_' . $ext . '_' . $post;
        }

        // Check for existence
        $count = User::where('username', $username)->count();

        if ($count > 0) {
            // Recurse to generate new username
            $this->generate_username($name);
        } else {

            // return unique username
            return $username;
        }
    }

    // ------------------
}
