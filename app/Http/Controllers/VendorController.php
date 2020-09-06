<?php

namespace App\Http\Controllers;

use App\Area;
use App\State;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                "message" => $validate->errors(),
            ], 400);
        }

        if ($request['username']) {
            // Check for dashes and other chars
            if (!preg_match('/^[a-z_0-9A-Z]+$/', $request['username'])) {
                return response()->json([
                    "success" => false,
                    "message" => [
                        'username' => [
                            'Username must contain only letters, numbers and underscores',
                        ],
                    ],
                ], 400);
            }
        }

        // Store vendor data
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
        $user->username = $request['username'] ? $request['username'] : $this->generate_username($request['business_name']);
        $user->email = strtolower($request['email']);
        $user->phone_number = $request['phone'];
        $user->password = Hash::make(strtolower($request['password']));

        // Try vendor save or catch error if any
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
            'username' => 'max:15|unique:vendors|unique:users',
            'email' => 'required|email|unique:vendors|unique:users', // email:rfc,dns should be used in production
            'phone' => 'required|numeric|digits_between:5,11|unique:vendors,phone_number|unique:users,phone_number',
            'password' => 'required|alpha_dash|min:6|max:30',
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

    // GENERIC

    /**
     * Generate Username
     * @param int $name Business Name of Vendor
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
            $pre = random_int(10, 999);
            $username = $pre . '_fud_vendor_' . $ext;
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
     * Profile Page
     */
    public function profile()
    {
        // Get States Data
        $states = State::get();

        // Fetch Vendor Location Data
        $area_id = Auth::user()->area_id;
        $vendor_location = State::join('areas', 'areas.state_id', '=', 'states.id')
            ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
            ->where('areas.id', $area_id)->first();

        // Get Areas In User State
        $areas = Area::where('state_id', $vendor_location->state_id)->get();

        // Social Media Links
        $social_handles = json_decode(Auth::user()->social_handles);

        return view('vendor.profile', compact('vendor_location', 'states', 'areas', 'social_handles'));
    }

    /**
     * Update Vendor Profile
     */
    public function update(Request $request)
    {
        // Get validation rules
        $validate = $this->profile_update_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors(),
            ], 400);
        }

        if ($request['username']) {
            // Check for dashes and other chars
            if (!preg_match('/^[a-z_0-9A-Z]+$/', $request['username'])) {
                return response()->json([
                    "success" => false,
                    "message" => [
                        'username' => [
                            'Username must contain only letters, numbers and underscores',
                        ],
                    ],
                ], 400);
            }
        }

        // Update Vendor Info
        return response()->json($this->update_store($request));
    }

    /**
     * Vendor Profile Update Validation Rules
     * @return object The validator object
     */
    private function profile_update_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'business_name' => 'required|max:50',
            'username' => ['required', 'max:15', Rule::unique('vendors')->ignore(Auth::user()->id), 'unique:users'],
            'email' => ['required', 'email', Rule::unique('vendors')->ignore(Auth::user()->id), 'unique:users'], // email:rfc,dns should be used in production
            'phone_number' => ['required', 'numeric', 'digits_between:5,11', Rule::unique('vendors')->ignore(Auth::user()->id), 'unique:users,phone_number'],
            'address' => 'required',
            'about' => 'required|max:1000',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
        ]);
    }

    /**
     * Structure Social Media Links Object
     * @return String Json String of social media links
     */
    private function fix_media(Request $request)
    {
        $instagram = $request->instagram;
        $facebook = $request->facebook;
        $twitter = $request->twitter;

        return json_encode(compact('instagram', 'facebook', 'twitter'));
    }

    /**
     * Process vendor update
     * @return array
     */
    private function update_store(Request $request)
    {
        // New vendor object
        $vendor = Vendor::find(Auth::user()->id);

        // Assign vendor object properties
        $vendor->business_name = $request->business_name;
        $vendor->username = $request->username;
        $vendor->email = $request->email;
        $vendor->phone_number = $request->phone_number;
        $vendor->area_id = $request->area;
        $vendor->address = $request->address;
        $vendor->about_business = $request->about;
        $vendor->social_handles = $this->fix_media($request);

        // Try vendor save or catch error if any
        try {
            $vendor->save();
            return ['success' => true, 'status' => 200, 'message' => 'Update Successful'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
        }
    }

    /**
     * Process vendor profile image update
     * @return array
     */
    public function profile_image_update(Request $request)
    {
        // Custom message
        $message = [
            'max' => 'The :attribute may not be greater than 10mb.',
        ];
        // Validate uploaded image
        $validate = Validator::make($request->all(), [
            'image' => 'required|max:10000',
        ], $message);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => $validate->errors('image')->messages()], 200);
        } else {
            try {
                $vendor = Vendor::find(Auth::user()->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "ven_" . Auth::user()->id . '.' . $extension;
                // Upload Image
                $request->file('image')->storeAs('public/vendor', $image);
                $vendor->profile_image = $image;
                $vendor->save();
                return response()->json(['success' => true, 'data' => $image], 200);
                // }
            } catch (\Throwable $th) {
                Log::error($th);
                return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Try Again!'], 500);
            }
        }
    }

}
