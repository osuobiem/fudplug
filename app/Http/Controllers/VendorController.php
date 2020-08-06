<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    // VENDOR SIGN UP
    /**
     * Vendor sign up
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

        // Check for dashes and other chars
        if (!preg_match('/^[a-z_0-9A-Z]+$/', $request['username'])) {
            return response()->json([
                "success" => false,
                "message" => [
                    'username' => [
                        'Username must contain only letters, numbers and underscores'
                    ]
                ]
            ], 400);
        }

        // Store user data
        $store = $this->cstore($request);
        $status = $store['status'];
        unset($store['status']);
        return response()->json($store, $status);
    }

    /**
     * Process vendor creation
     * @return array
     */
    public function cstore(Request $request)
    {
        // New vendor object
        $user = new Vendor();

        // Assign vendor object properties
        $user->business_name = $request['business_name'];
        $user->username = $request['username'];
        $user->email = strtolower($request['email']);
        $user->phone_number = $request['phone'];
        $user->password = Hash::make(strtolower($request['password']));

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
     * Vendor Creation Validation Rules
     * @return object The validator object
     */
    private function create_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'business_name' => 'required|max:50',
            'username' => 'required|max:15|unique:vendors',
            'email' => 'required|email|unique:vendors',
            'phone' => 'required|numeric|digits_between:5,11|unique:vendors,phone_number',
            'password' => 'required|alpha_dash|min:6|max:30'
        ]);
    }
    // -------------

    // VENDOR LOGIN/LOGOUT
    /**
     * Vendor login without validation
     */
    public function fast_login(Request $request)
    {
        // Extract login credentials
        $credentials = $request->only(['email', 'password']);

        // Attempt Login and return status
        Auth::attempt($credentials, true);
    }

    /**
     * Logout Vendor
     * @return object
     */
    public function logout()
    {
        Auth::logout();

        return redirect('');
    }
    // -------------
}
