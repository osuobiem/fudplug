<?php

namespace App\Http\Controllers;

use App\State;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
                "message" => $validate->errors(),
            ]);
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
            'email' => 'required|email|unique:users|unique:vendors', // email:rfc,dns should be used in production
            'phone' => 'required|numeric|digits_between:5,11|unique:users,phone_number|unique:vendors,phone_number',
            'password' => 'required|alpha_dash|min:6|max:30',
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
        $count_v = Vendor::where('username', $username)->count();
        $count_u = User::where('username', $username)->count();

        if ($count_v > 0 || $count_u > 0) {
            // Recurse to generate new username
            $this->generate_username($name);
        } else {

            // return unique username
            return $username;
        }
    }

    // ------------------

    /**
     * Load Right Side
     * @return string HTML
     */
    public function profile()
    {
        try {
            // Get States Data
            $states = State::get();

            // Fetch User Location Data
            $area_id = Auth::guard('user')->user()->area_id;
            $user_location = State::join('areas', 'areas.state_id', '=', 'states.id')
                ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', $area_id)->first();

            return view('user.components.right-side', compact('user_location'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Process vendor profile image update
     * @return string
     */
    public function profile_image_update(Request $request)
    {
        // Custom message
        $message = [
            'max' => 'The :attribute may not be greater than 25mb.',
        ];
        // Validate uploaded image
        $validate = Validator::make($request->all(), [
            'image' => 'required|max:25000',
        ], $message);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => $validate->errors('image')->messages()], 200);
        } else {
            try {
                $user = User::find(Auth::guard('user')->user()->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "user_" . Auth::guard('user')->user()->id . '_' . time() . '.' . $extension;
                // Previous Image
                $prev_image = Auth::guard('user')->user()->profile_image;
                // Delete prev image
                if ($prev_image != "placeholder.png") {
                    Storage::delete('/public/user/profile/' . $prev_image);
                }
                // Upload Image
                $request->file('image')->storeAs('public/user/profile', $image);
                $user->profile_image = $image;
                $user->save();
                return response()->json(['success' => true, 'data' => $image], 200);
                // }
            } catch (\Throwable $th) {
                Log::error($th);
                return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Try Again!'], 500);
            }
        }
    }
}
