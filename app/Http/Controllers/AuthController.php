<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Vendor/User Login
     * @return json
     */
    public function login(Request $request)
    {
        // Get validation rules
        $validate = $this->login_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors()
            ], 400);
        }

        // Attempt Vendor Login
        $this->login_vendor($request);

        // Attempt User Login
        $this->login_user($request);

        // Return failed login response
        return response()->json([
            'success' => false,
            'message' => 'Invalid Credentials!'
        ], 400);
    }

    /**
     * Login Validation Rules
     * @return object The validator object
     */
    public function login_rules(Request $request)
    {
        // Custom login field message
        $message = [
            'login.required' => 'This field is required.',
        ];

        // Make and return validation rules
        return Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required|alpha_dash'
        ], $message);
    }

    /**
     * Attempt to Login Vendor
     */
    public function vendor_login(Request $request)
    {
        // Extract credentials
        $login = $request['login'];
        $password = $request['password'];

        // Attempt login with email
        $attempt = Auth::attempt(['email' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }

        // Attempt login with username
        $attempt = Auth::attempt(['username' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }

        // Attempt login with phone
        $attempt = Auth::attempt(['phone_number' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }
    }

    /**
     * Attempt to Login User
     */
    public function user_login(Request $request)
    {
        // Extract credentials
        $login = $request['login'];
        $password = $request['password'];

        // Attempt login with email
        $attempt = Auth::guard('user')->attempt(['email' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }

        // Attempt login with username
        $attempt = Auth::guard('user')->attempt(['username' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }

        // Attempt login with phone
        $attempt = Auth::guard('user')->attempt(['phone_number' => $login, 'password' => $password], $request['remember_me']);

        if ($attempt) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful'
            ]);
        }
    }
}
