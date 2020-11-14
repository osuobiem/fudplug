<?php

namespace App\Http\Controllers;

use App\Area;
use App\Rules\MatchOldPassword;
use App\State;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     * Load Right Side (User Profile)
     * @return string HTML
     */
    public function profile($type)
    {
        try {
            // Get States Data
            $states = State::get();

            // Fetch User Location Data
            $area_id = Auth::guard('user')->user()->area_id;
            $user_location = State::join('areas', 'areas.state_id', '=', 'states.id')
                ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', $area_id)->first();

            // Retrieve View Based On Request Type (Mobile or Desktop)
            if ($type == "mobile") {
                $view = view('user.components.right-side-mobile', compact('user_location'));
            } else {
                $view = view('user.components.right-side-desktop', compact('user_location'));
            }

            return $view;
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

    /**
     * Load Profile Edit Modal
     * @return string HTML
     */
    public function profile_edit()
    {
        try {
            // Get States Data
            $states = State::get();

            // Fetch User Location Data
            $area_id = Auth::guard('user')->user()->area_id;
            $user_location = State::join('areas', 'areas.state_id', '=', 'states.id')
                ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', $area_id)->first();

            // Get Areas In User State
            $areas = Area::where('state_id', $user_location->state_id)->get();

            return view('user.components.profile-edit', compact('user_location', 'states', 'areas'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Update User Profile
     */
    public function update_profile(Request $request)
    {
        // Get validation rules
        $validate = $this->profile_update_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors(),
            ]);
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
                ]);
            }
        }

        // Update User Info
        return response()->json($this->update_store($request));
    }

    /**
     * User Profile Update Validation Rules
     * @return object The validator object
     */
    private function profile_update_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'name' => 'required',
            'username' => ['required', 'max:15', Rule::unique('users')->ignore(Auth::guard('user')->user()->id), 'unique:vendors'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::guard('user')->user()->id), 'unique:vendors'], // email:rfc,dns should be used in production
            'phone_number' => ['required', 'numeric', 'digits_between:5,11', Rule::unique('users')->ignore(Auth::guard('user')->user()->id), 'unique:vendors,phone_number'],
            'address' => 'required',
        ]);
    }

    /**
     * Process User Update
     * @return array
     */
    private function update_store(Request $request)
    {
        // New User object
        $user = User::find(Auth::guard('user')->user()->id);

        // Assign user object properties
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->area_id = $request->area;
        $user->address = $request->address;

        // Try user save or catch error if any
        try {
            $user->save();
            return ['success' => true, 'status' => 200, 'message' => 'Update Successful'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
        }
    }

    /**
     * Update User Password
     * @return string JSON
     */
    public function update_password(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
            ]);

            // Run validation
            if ($validate->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validate->errors(),
                ]);
            }

            User::find(Auth::guard('user')->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return response()->json(['success' => true, 'status' => 200, 'message' => 'Update Successful']);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!']);
        }
    }

    /**
     * Get Vendors In User Area
     * @return string HTML
     */
    public function get_vendor(Request $request)
    {
        try {
            $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
                ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', Auth::guard('user')->user()->area_id)->get();
            return view('user.components.left-side', compact('vendors'));
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Get All Vendors In User Area
     * @return string HTML
     */
    public function all_vendors(Request $request)
    {
        try {
            $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
                ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', Auth::guard('user')->user()->area_id)->paginate(1);

            // Variable to hold Html
            $html = '';

            foreach ($vendors as $vendor) {
                $html .= "
                <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <div class=\"col-md-4 col-6 text-center mb-2\">
                <div class=\"border rounded bg-white job-item shadow\">
                    <div class=\"d-flex job-item-header border-bottom\"
                        style=\"height: 200px; background-position: center; background-size: cover; background-repeat: no-repeat; background-image: url('" . Storage::url("vendor/cover/") . $vendor->cover_image . "');\">

                        <div class=\"overflow-hidden\" style=\"width:100%; background-color: rgba(0,0,0,0.5)\">
                            <img class=\"img-fluid vend-img rounded-circle mt-5\"
                                src=\"" . Storage::url('vendor/profile/') . $vendor->profile_image . "\" alt=\"\">
                            <h6 class=\"font-weight-bold text-white mb-0 text-truncate\">
" . $vendor->business_name . "
                            </h6>
                            <div class=\"text-truncate text-white\">@<span>" . $vendor->username . "</span></div>
                            <div class=\"small text-gray-500\"><i
                                    class=\"la la-map-marker-alt text-warning text-bold\"></i>
" . $vendor->area . ", " . $vendor->state . "</div>
                        </div>
                    </div>
                    <div class=\"p-3 job-item-footer\">
                        <a class=\"font-weight-bold d-block\" data-toggle=\"modal\" href=\"#profile-edit-modal\">
                            View
                        </a>
                    </div>
                </div>
            </div>
";
            }

            if ($request->ajax()) {
                return $html;
            } else {
                return view('user.components.view-all', compact('vendors'));
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => $th->getMessage()]);
        }
    }
}
