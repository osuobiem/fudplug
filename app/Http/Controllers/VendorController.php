<?php

namespace App\Http\Controllers;

use App\Area;
use App\Item;
use App\Jobs\EmailJob;
use App\Menu;
use App\Order;
use App\OrderItem;
use App\Rating;
use App\SocketData;
use App\State;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        $user->email_verification_token = Str::random(32);

        // Try vendor save or catch error if any
        try {
            $user->save();

            // Send verification email by dispatching email job five seconds after it has been dispatched
            $job_data = ['email_type' => 'email_verification', 'user_data' => ['user' => $user, 'link' => route('verify', $user->email_verification_token)]];
            EmailJob::dispatch($job_data)->delay(now()->addSeconds(1));

            // Add user email to session to be used for resending verification emails
            session()->put('verify_email', [$user->email, "registration"]);

            // Attempt login
            // $this->fast_login($request);

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
            'business_name' => 'required|max:25',
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
    public function profile($username)
    {
        try {
            $vendor = Vendor::where('username', $username)->first();

            if (empty($vendor) || Auth::user()->username != $username) {
                return ['status' => false, 'message' => "404 Not found"];
            }

            // Get States Data
            $states = State::get();

            // Fetch Vendor Location Data
            $area_id = Auth::user('vendor')->area_id;
            $vendor_location = State::join('areas', 'areas.state_id', '=', 'states.id')
                ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', $area_id)->first();

            // Get Areas In User State
            $areas = Area::where('state_id', $vendor_location->state_id)->get();

            // Social Media Links
            $social_handles = json_decode(Auth::user('vendor')->social_handles);

            // Rating Data
            $rating_data = $this->get_rating(Auth::guard('vendor')->user()->id, 0);

            return ['status' => true, 'data' => compact('vendor_location', 'states', 'areas', 'social_handles', 'rating_data')];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['status' => false, 'message' => "500 Server error"];
        }
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
            'business_name' => 'required|max:25',
            'username' => ['required', 'max:15', Rule::unique('vendors')->ignore(Auth::user('vendor')->id), 'unique:users'],
            'email' => ['required', 'email', Rule::unique('vendors')->ignore(Auth::user('vendor')->id), 'unique:users'], // email:rfc,dns should be used in production
            'phone_number' => ['required', 'numeric', 'digits_between:5,11', Rule::unique('vendors')->ignore(Auth::user('vendor')->id), 'unique:users,phone_number'],
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
        $vendor = Vendor::find(Auth::user('vendor')->id);

        $username = $vendor->username;

        // Assign vendor object properties
        $vendor->business_name = $request->business_name;
        $vendor->username = $request->username;
        $vendor->email = $request->email;
        $vendor->phone_number = $request->phone_number;
        $vendor->area_id = $request->area;
        $vendor->address = $request->address;
        $vendor->about_business = $request->about;
        $vendor->social_handles = $this->fix_media($request);

        $socket = SocketData::where('username', $username)->first();
        $socket->username = $vendor->username;

        // Try vendor save or catch error if any
        try {
            $vendor->save();
            $socket->save();
            return ['success' => true, 'status' => 200, 'message' => 'Update Successful'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try Again!'];
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
                $vendor = Vendor::find(Auth::user('vendor')->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "ven_" . Auth::user('vendor')->id . '_' . time() . '.' . $extension;
                // Previous Image
                $prev_image = Auth::user('vendor')->profile_image;
                // Delete prev image
                if ($prev_image != "placeholder.png") {
                    Storage::delete('/public/vendor/profile/' . $prev_image);
                }
                // Upload Image
                $request->file('image')->storeAs('public/vendor/profile', $image);
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

    /**
     * Process vendor cover image update
     * @return string
     */
    public function cover_image_update(Request $request)
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
                $vendor = Vendor::find(Auth::user('vendor')->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "cover_" . Auth::user('vendor')->id . '_' . time() . '.' . $extension;
                // Delete prev image
                Storage::delete('/public/vendor/cover/' . Auth::user('vendor')->cover_image);
                // Upload new Image
                $request->file('image')->storeAs('public/vendor/cover', $image);
                $vendor->cover_image = $image;
                $vendor->save();
                return response()->json(['success' => true, 'data' => $image], 200);
            } catch (\Throwable $th) {
                Log::error($th);
                return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
            }
        }
    }

    /**
     * Process vendor dish upload
     * @return string
     */
    public function add_dish(Request $request)
    {
        try {
            //Validate Input
            $validator = $this->dish_add_rules($request);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'file_val' => false, 'message' => $validator->errors('image')->messages()], 200);
            } else if (in_array('', $_FILES['image']['name'])) {
                return response()->json(['success' => false, 'file_val' => true, 'message' => 'Dish images are required.'], 200);
            } else {
                if ($request->form_type == "simple") {
                    $this->simple_put($request);
                } else {
                    $this->advanced_put($request);
                }
                return response()->json(['success' => true, 'file_val' => false, 'message' => "Your dish was successfully uploaded."], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return response()->json(['success' => false, 'file_val' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Process Vendor Simple Dish Upload
     * @return void
     */
    public function simple_put($request)
    {
        foreach ($request->title as $key => $value) {
            // Extract quantity and quantity title from quantity input field
            $qty_arr = explode(" ", $request->quantity[$key]);

            $data = [
                'title' => $value,
                'quantity' => json_encode(['price' => $request->price[$key], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]]),
                'image' => $this->dish_img_upload($request, $key) ? $this->dish_img_upload($request, $key) : null,
                'type' => "simple",
            ];

            $item = new Item($data);
            $vendor = Vendor::find(Auth::user('vendor')->id);
            $vendor->item()->save($item);
        }
    }

    /**
     * Process Vendor Advanced Dish Upload
     * @return void
     */
    public function advanced_put($request)
    {
        foreach ($request->title as $key => $value) {
            $data = [
                'title' => $value,
                'quantity' => json_encode(['bulk' => $this->bulk_qty_json($request, $key), 'regular' => $this->regular_qty_json($request, $key)]),
                'image' => $this->dish_img_upload($request, $key) ? $this->dish_img_upload($request, $key) : null,
                'type' => "advanced",
            ];

            $item = new Item($data);
            $vendor = Vendor::find(Auth::user('vendor')->id);
            $vendor->item()->save($item);
        }
    }

    /**
     * Vendor Dish Image Uploader
     * @return boolean Boolean value on success or failure
     */
    public function dish_img_upload(Request $request, $key)
    {
        try {
            $file = $request->file('image')[$key];
            $filenameWithExt = $file->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $image = $request->title[$key] . Auth::user('vendor')->id . '_' . time() . '.' . $extension;
            // Upload new Image
            if ($file->storeAs('public/vendor/dish', $image)) {
                return $image;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Vendor Regular Dish Quantity Json Generator
     * @return string JSON string
     */
    private function regular_qty_json(Request $request, $key = null)
    {
        $regular_arr = [];

        if ($key === null) {
            // Executed when editing dish
            if ($request->has('regular_title')) {
                foreach ($request->regular_title as $key => $value) {
                    // Extract quantity and quantity title from quantity input field
                    $qty_arr = explode(" ", $request->regular_quantity[$key]);

                    $regular_arr[$key] = ['title' => $value, 'price' => $request->regular_price[$key], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                }
            } else {
                $regular_arr = null;
            }
        } else {
            // Executed when uploading dish
            switch ($key) {
                case 0:
                    # Array for first group of quantities
                    if (in_array(null, $request->regular_title_one) || in_array(null, $request->regular_price_one) || in_array(null, $request->regular_quantity_one)) {
                        $regular_arr = null;
                    } else {
                        foreach ($request->regular_title_one as $key_one => $value_one) {
                            // Extract quantity and quantity title from quantity input field
                            $qty_arr = explode(" ", $request->regular_quantity_one[$key_one]);

                            $regular_arr[$key_one] = ['title' => $value_one, 'price' => $request->regular_price_one[$key_one], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                        }
                    }
                    break;

                case 1:
                    # Array for second group of quantities
                    if (in_array(null, $request->regular_title_two) || in_array(null, $request->regular_price_two) || in_array(null, $request->regular_quantity_two)) {
                        $regular_arr = null;
                    } else {
                        foreach ($request->regular_title_two as $key_two => $value_two) {
                            // Extract quantity and quantity title from quantity input field
                            $qty_arr = explode(" ", $request->regular_quantity_two[$key_two]);

                            $regular_arr[$key_two] = ['title' => $value_two, 'price' => $request->regular_price_two[$key_two], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                        }
                    }
                    break;

                case 2:
                    # Array for third group of quantities
                    if (in_array(null, $request->regular_title_three) || in_array(null, $request->regular_price_three) || in_array(null, $request->regular_quantity_three)) {
                        $regular_arr = null;
                    } else {
                        foreach ($request->regular_title_three as $key_three => $value_three) {
                            // Extract quantity and quantity title from quantity input field
                            $qty_arr = explode(" ", $request->regular_quantity_three[$key_three]);

                            $regular_arr[$key_three] = ['title' => $value_three, 'price' => $request->regular_price_three[$key_three], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                        }
                    }
                    break;

                case 3:
                    # Array for fourth group of quantities
                    if (in_array(null, $request->regular_title_four) || in_array(null, $request->regular_price_four) || in_array(null, $request->regular_quantity_four)) {
                        $regular_arr = null;
                    } else {
                        foreach ($request->regular_title_four as $key_four => $value_four) {
                            // Extract quantity and quantity title from quantity input field
                            $qty_arr = explode(" ", $request->regular_quantity_four[$key_four]);

                            $regular_arr[$key_four] = ['title' => $value_four, 'price' => $request->regular_price_four[$key_four], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                        }
                    }
                    break;

                case 4:
                    # Array for fifth group of quantities
                    if (in_array(null, $request->regular_title_five) || in_array(null, $request->regular_price_five) || in_array(null, $request->regular_quantity_five)) {
                        $regular_arr = null;
                    } else {
                        foreach ($request->regular_title_five as $key_five => $value_five) {
                            // Extract quantity and quantity title from quantity input field
                            $qty_arr = explode(" ", $request->regular_quantity_five[$key_five]);

                            $regular_arr[$key_five] = ['title' => $value_five, 'price' => $request->regular_price_five[$key_five], 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]];
                        }
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
        return json_encode($regular_arr);
    }

    /**
     * Vendor Bulk Dish Quantity Json Generator
     * @return string JSON string
     */
    private function bulk_qty_json(Request $request, $key = null)
    {
        $bulk_arr = [];

        if ($key === null) {
            // Executed when editing dish
            if ($request->has('bulk_title')) {
                foreach ($request->bulk_title as $key => $value) {
                    $bulk_arr[$key] = ['title' => $value, 'price' => $request->bulk_price[$key], 'quantity' => $request->bulk_quantity[$key]];
                }
            } else {
                $bulk_arr = null;
            }
        } else {
            switch ($key) {
                case 0:
                    # Array for first group of quantities
                    if (in_array(null, $request->bulk_title_one) || in_array(null, $request->bulk_price_one) || in_array(null, $request->bulk_quantity_one)) {
                        $bulk_arr = null;
                    } else {
                        foreach ($request->bulk_title_one as $key_one => $value_one) {
                            $bulk_arr[$key_one] = ['title' => $value_one, 'price' => $request->bulk_price_one[$key_one], 'quantity' => $request->bulk_quantity_one[$key_one]];
                        }
                    }
                    break;

                case 1:
                    # Array for second group of quantities
                    if (in_array(null, $request->bulk_title_two) || in_array(null, $request->bulk_price_two) || in_array(null, $request->bulk_quantity_two)) {
                        $bulk_arr = null;
                    } else {
                        foreach ($request->bulk_title_two as $key_two => $value_two) {
                            $bulk_arr[$key_two] = ['title' => $value_two, 'price' => $request->bulk_price_two[$key_two], 'quantity' => $request->bulk_quantity_two[$key_two]];
                        }
                    }
                    break;

                case 2:
                    # Array for third group of quantities
                    if (in_array(null, $request->bulk_title_three) || in_array(null, $request->bulk_price_three) || in_array(null, $request->bulk_quantity_three)) {
                        $bulk_arr = null;
                    } else {
                        foreach ($request->bulk_title_three as $key_three => $value_three) {
                            $bulk_arr[$key_three] = ['title' => $value_three, 'price' => $request->bulk_price_three[$key_three], 'quantity' => $request->bulk_quantity_three[$key_three]];
                        }
                    }
                    break;

                case 3:
                    # Array for fourth group of quantities
                    if (in_array(null, $request->bulk_title_four) || in_array(null, $request->bulk_price_four) || in_array(null, $request->bulk_quantity_four)) {
                        $bulk_arr = null;
                    } else {
                        foreach ($request->bulk_title_four as $key_four => $value_four) {
                            $bulk_arr[$key_four] = ['title' => $value_four, 'price' => $request->bulk_price_four[$key_four], 'quantity' => $request->bulk_quantity_four[$key_four]];
                        }
                    }
                    break;

                case 4:
                    # Array for fifth group of quantities
                    if (in_array(null, $request->bulk_title_five) || in_array(null, $request->bulk_price_five) || in_array(null, $request->bulk_quantity_five)) {
                        $bulk_arr = null;
                    } else {
                        foreach ($request->bulk_title_five as $key_five => $value_five) {
                            $bulk_arr[$key_five] = ['title' => $value_five, 'price' => $request->bulk_price_five[$key_five], 'quantity' => $request->bulk_quantity_five[$key_five]];
                        }
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }

        return json_encode($bulk_arr);
    }

    /**
     * Vendor Dish Add Validation Rules
     * @return object The validator object
     */
    private function dish_add_rules(Request $request)
    {
        // Custom message
        $message = [
            'required' => 'Dish/Item name is required.',
            'alpha_dash' => 'Title fields only allow alphabets, hyphens and underscores.',
            'mimes' => 'Images must be of type jpg or jpeg or png.',
            'numeric' => 'Quantity and price fields must be numeric characters.',
            'max' => 'The :attribute may not be greater than 25mb.',
            'required_without' => 'Please add items to Regular or Bulk or Both.',
            'bulk_required' => 'Sibling fields can not be left empty.',
            'required_with' => 'Fields can not be empty when adjacent fields have been entered.',
            'quantity' => 'Quantity field for regular requires a valid quantity like (50 plates or 1 cup).',
            'plug_numeric' => 'Price field requires a number.',
        ];

        // Make and return validation rules
        return Validator::make($request->all(), [
            'title.*' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:25000',
            'quantity.*' => 'quantity',
            'price.*' => 'numeric',
            'regular_title_one.*' => 'bail|required_without:bulk_title_one.*|bulk_required|required_with:regular_price_one.*,regular_quantity_one.*',
            'regular_price_one.*' => 'bail|required_without:bulk_price_one.*|bulk_required|required_with:regular_title_one.*,regular_quantity_one.*|plug_numeric',
            'regular_quantity_one.*' => 'bail|required_without:bulk_quantity_one.*|bulk_required|required_with:regular_title_one.*,regular_price_one.*|quantity',
            'bulk_title_one.*' => 'bail|required_without:regular_title_one.*|bulk_required|required_with:bulk_price_one.*,bulk_quantity_one.*|plug_numeric',
            'bulk_price_one.*' => 'bail|required_without:regular_price_one.*|bulk_required|required_with:bulk_title_one.*,bulk_quantity_one.*|plug_numeric',
            'bulk_quantity_one.*' => 'bail|required_without:regular_quantity_one.*|bulk_required|required_with:bulk_title_one.*,bulk_price_one.*|plug_numeric',

            'regular_title_two.*' => 'bail|required_without:bulk_title_two.*|bulk_required|required_with:regular_price_two.*,regular_quantity_two.*',
            'regular_price_two.*' => 'bail|required_without:bulk_price_two.*|bulk_required|required_with:regular_title_two.*,regular_quantity_two.*|plug_numeric',
            'regular_quantity_two.*' => 'bail|required_without:bulk_quantity_two.*|bulk_required|required_with:regular_title_two.*,regular_price_two.*|quantity',
            'bulk_title_two.*' => 'bail|required_without:regular_title_two.*|bulk_required|required_with:bulk_price_two.*,bulk_quantity_two.*|plug_numeric',
            'bulk_price_two.*' => 'bail|required_without:regular_price_two.*|bulk_required|required_with:bulk_title_two.*,bulk_quantity_two.*|plug_numeric',
            'bulk_quantity_two.*' => 'bail|required_without:regular_quantity_two.*|bulk_required|required_with:bulk_title_two.*,bulk_price_two.*|plug_numeric',

            'regular_title_three.*' => 'bail|required_without:bulk_title_three.*|bulk_required|required_with:regular_price_three.*,regular_quantity_three.*',
            'regular_price_three.*' => 'bail|required_without:bulk_price_three.*|bulk_required|required_with:regular_title_three.*,regular_quantity_three.*|plug_numeric',
            'regular_quantity_three.*' => 'bail|required_without:bulk_quantity_three.*|bulk_required|required_with:regular_title_three.*,regular_price_three.*|quantity',
            'bulk_title_three.*' => 'bail|required_without:regular_title_three.*|bulk_required|required_with:bulk_price_three.*,bulk_quantity_three.*|plug_numeric',
            'bulk_price_three.*' => 'bail|required_without:regular_price_three.*|bulk_required|required_with:bulk_title_three.*,bulk_quantity_three.*|plug_numeric',
            'bulk_quantity_three.*' => 'bail|required_without:regular_quantity_three.*|bulk_required|required_with:bulk_title_three.*,bulk_price_three.*|plug_numeric',

            'regular_title_four.*' => 'bail|required_without:bulk_title_four.*|bulk_required|required_with:regular_price_four.*,regular_quantity_four.*',
            'regular_price_four.*' => 'bail|required_without:bulk_price_four.*|bulk_required|required_with:regular_title_four.*,regular_quantity_four.*|plug_numeric',
            'regular_quantity_four.*' => 'bail|required_without:bulk_quantity_four.*|bulk_required|required_with:regular_title_four.*,regular_price_four.*|quantity',
            'bulk_title_four.*' => 'bail|required_without:regular_title_four.*|bulk_required|required_with:bulk_price_four.*,bulk_quantity_four.*|plug_numeric',
            'bulk_price_four.*' => 'bail|required_without:regular_price_four.*|bulk_required|required_with:bulk_title_four.*,bulk_quantity_four.*|plug_numeric',
            'bulk_quantity_four.*' => 'bail|required_without:regular_quantity_four.*|bulk_required|required_with:bulk_title_four.*,bulk_price_four.*|plug_numeric',

            'regular_title_five.*' => 'bail|required_without:bulk_title_five.*|bulk_required|required_with:regular_price_five.*,regular_quantity_five.*',
            'regular_price_five.*' => 'bail|required_without:bulk_price_five.*|bulk_required|required_with:regular_title_five.*,regular_quantity_five.*|plug_numeric',
            'regular_quantity_five.*' => 'bail|required_without:bulk_quantity_five.*|bulk_required|required_with:regular_title_five.*,regular_price_five.*|quantity',
            'bulk_title_five.*' => 'bail|required_without:regular_title_five.*|bulk_required|required_with:bulk_price_five.*,bulk_quantity_five.*|plug_numeric',
            'bulk_price_five.*' => 'bail|required_without:regular_price_five.*|bulk_required|required_with:bulk_title_five.*,bulk_quantity_five.*|plug_numeric',
            'bulk_quantity_five.*' => 'bail|required_without:regular_quantity_five.*|bulk_required|required_with:bulk_title_five.*,bulk_price_five.*|plug_numeric',

        ], $message);
    }

    /**
     * Get Vendor Dishes
     * @return object Laravel View Instance
     */
    public function get_dish(Request $request, $dish_id = null)
    {
        try {
            if (!empty($dish_id)) {
                $dish = Item::where(['vendor_id' => Auth::user('vendor')->id, 'id' => $dish_id])->first();
                $data = [];
                if ($dish->type == "simple") {
                    $qty = json_decode($dish->quantity);
                    $data['dish'] = $dish;
                    $data['price'] = $qty->price;
                    $data['quantity'] = $qty->quantity;
                    $data['qty_title'] = $qty->qty_title;
                } else {
                    $qty = $dish->quantity = json_decode($dish->quantity);
                    $data['dish'] = $dish;
                    $data['regular_qty'] = json_decode($qty->regular);
                    $data['bulk_qty'] = json_decode($qty->bulk);
                }
                return view('vendor.components.dish-view', $data);
            } else {
                // Get All Vendor Dishes
                $dish_data = Item::where('vendor_id', Auth::user('vendor')->id);

                if ($dish_data->count() > 0) {
                    // Set Dish Parameters
                    $dish_count = $dish_data->count();
                    $dishes = $dish_data->get();

                    // Fetch the Menu Item
                    $menu_data = Menu::where('vendor_id', Auth::user('vendor')->id)->first("items");
                    if (!empty($menu_data)) {
                        $menu = json_decode($menu_data);

                        // Get the Array of Dish IDs
                        $menu = json_decode($menu->items);
                        $menu = $menu->item;

                        if (!empty($menu)) {
                            // Fetch Dishes for Menu
                            $menu_data = Item::select("*")
                                ->whereIn('id', $menu);
                            $menu_count = $menu_data->count();
                            $menu_dishes = $menu_data->get();
                        } else {
                            $menu_count = 0;
                            $menu_dishes = null;
                        }
                    } else {
                        $menu_count = 0;
                        $menu_dishes = null;
                    }
                } else {
                    $dish_count = 0;
                    $dishes = null;

                    $menu_count = 0;
                    $menu_dishes = null;
                }

                return view('vendor.components.right-side', compact('dishes', 'menu_dishes', 'menu_count', 'dish_count'));
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Update Vendor Dishes
     * @return string JSON response
     */
    public function update_dish(Request $request)
    {
        try {
            //Validate Input
            $validator = $this->dish_update_rules($request);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors('image')->messages()], 200);
            } else {
                if ($request->form_type == "simple") {
                    $item = Item::find($request->dish_id);
                    $item->title = $request->title;

                    // Extract quantity and quantity title from quantity input field
                    $qty_arr = explode(" ", $request->quantity);

                    $item->quantity = json_encode(['price' => $request->price, 'quantity' => $qty_arr[0], 'qty_title' => $qty_arr[1]]);
                    if ($request->hasFile('image')) {
                        $item->image = $this->dish_img_update($request) ? $this->dish_img_update($request) : null;
                    }
                    $item->save();
                } else {
                    $item = Item::find($request->dish_id);
                    $item->title = $request->title;
                    $item->quantity = json_encode(['bulk' => $request->has('bulk_title') ? $this->bulk_qty_json($request) : null, 'regular' => $this->regular_qty_json($request)]);
                    if ($request->hasFile('image')) {
                        $item->image = $this->dish_img_update($request) ? $this->dish_img_update($request) : null;
                    }
                    $item->save();
                }
                return response()->json(['success' => true, 'message' => "Your dish was successfully updated."], 200);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Vendor Dish Update Validation Rules
     * @return object The validator object
     */
    private function dish_update_rules(Request $request)
    {
        // Custom message
        $message = [
            'required' => 'All fields are required.',
            'alpha_dash' => 'Title fields only allow alphabets, hyphens and underscores.',
            'mimes' => 'Images must be of type jpg or jpeg or png.',
            'numeric' => 'Quantity and price fields must be numeric characters.',
            'max' => 'The :attribute may not be greater than 25mb.',
            'quantity' => 'Quantity field for regular requires a valid quantity like (50 plates or One cup).',

        ];
        // Make and return validation rules
        if ($request->form_type == "simple") {
            return Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,jpg,png|max:25000',
                'price' => 'required|numeric',
                'quantity' => 'required|quantity',
            ], $message);
        } else {
            return Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,jpg|max:25000',
                'regular_title.*' => 'required',
                'regular_price.*' => 'required|numeric',
                'regular_quantity.*' => 'required|quantity',
                'bulk_title.*' => 'nullable',
                'bulk_price.*' => 'nullable|numeric',
            ], $message);
        }
    }

    /**
     * Vendor Dish Image Uploader (Update)
     * @return boolean Boolean value on success or failure
     */
    public function dish_img_update(Request $request)
    {
        try {
            $file = $request->file('image');
            $filenameWithExt = $file->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $image = $request->title . Auth::user('vendor')->id . '_' . time() . '.' . $extension;
            // Upload new Image
            if ($file->storeAs('public/vendor/dish', $image)) {
                return $image;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    /**
     * Populate Vendor Menu Modal
     * @return object Laravel View Instance
     */
    public function get_menu(Request $request)
    {
        try {
            // Fetch Vendor Dishes
            $dishes = Item::where('vendor_id', Auth::user('vendor')->id);
            if (!empty($dishes->count())) {
                $dishes = $dishes->get();

                // Fetch the Menu Item
                $menu = Menu::where('vendor_id', Auth::user('vendor')->id)->first();

                if (!empty($menu)) {
                    $menu = json_decode($menu->items);

                    // Get the Array of Dish IDs
                    $menu_items = $menu->item;

                    if (!empty($menu_items)) {
                        // Fetch Dishes for Menu
                        $menu_data = Item::select("*")
                            ->whereIn('id', $menu_items);
                        $menu_count = $menu_data->count();
                        $menu_dishes = $menu_data->get();
                    } else {
                        $menu_count = 0;
                        $menu_dishes = null;
                    }
                } else {
                    $menu_items = null;
                    $menu_dishes = null;
                }
            } else {
                $dishes = null;
                $menu_items = null;
                $menu_dishes = null;
            }

            return view('vendor.components.menu-update', compact('dishes', 'menu_items', 'menu_dishes'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Update Vendor Menu
     * @return string JSON response
     */
    public function update_menu(Request $request)
    {
        try {
            $items = ['item' => $request->has('item') ? $request->item : null];
            Menu::updateOrCreate(['vendor_id' => Auth::user('vendor')->id], ['items' => json_encode($items)]);
            return response()->json(['success' => true, 'message' => "Menu Updated Successfully"], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Get Dish To Delete
     * @return object Laravel View Instance
     */
    public function dish_delete(Request $request, $dish_id)
    {
        try {
            $dish = Item::where(['vendor_id' => Auth::user('vendor')->id, 'id' => $dish_id])->first();
            return view('vendor.components.dish-delete', compact('dish'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Delete Dish
     * @return string JSON
     */
    public function delete_dish(Request $request, $dish_id)
    {
        try {
            // Get dish
            $dish = Item::find($dish_id);

            // Get user menu
            $menu = Menu::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
            $menu_items = json_decode($menu->items)->item;

            // Delete item from menu first
            if (($key = array_search($dish->id, $menu_items)) !== false) {
                unset($menu_items[$key]);
                $menu_items = array_values($menu_items);
            }
            $menu->items = json_encode(['item' => $menu_items]);

            // Update menu
            $menu->save();

            // Delete dish
            $dish->forceDelete();

            return response()->json(['success' => true, 'message' => "Dish Deleted Successfully"], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Get user orders
     * @param Request $request
     * @return Json $response
     */
    public function get_order(Request $request, $type = "today")
    {
        try {
            $orders = $this->order_query($type);
            $to_check = $orders->toArray();

            // Number of orders
            $order_count = $orders->count();

            // Get pending orders for user
            $pending_count = Order::where([['user_id', '=', Auth::user()->id], ['status', '=', 0]])->count();

            if (!empty($to_check)) {
                foreach ($orders as $order) {
                    $order->title = explode(',', $order->title);
                    $order->quantity = explode(',', $order->quantity);
                    $order->order_detail = explode(',', $order->order_detail);

                    // Fix order quantity & order details
                    $quant_arr = [];
                    $ord_arr = [];
                    foreach ($order->quantity as $key => $val) {
                        $quant_arr[$key] = base64_decode($val);
                        $ord_arr[$key] = base64_decode($order->order_detail[$key]);
                    }
                    $order->quantity = $quant_arr;
                    $order->order_detail = $ord_arr;
                    // Fix order quantity & order details

                    // Fix order status
                    $order->order_status = $this->order_status($order->order_status);

                    $order->image = explode(',', $order->image);
                    $order->order_type = explode(',', $order->order_type);
                }
            } else {
                $orders = null;
            }

            // Total amount for orders
            $total_amount = ($orders == null) ? 0 : $this->get_order_total($orders);

            $order_view = view('vendor.components.order', compact('orders'))->render();

            return response()->json(['success' => true, 'order_view' => $order_view, 'total_amount' => $total_amount, 'pending_count' => $pending_count, 'order_count' => $order_count], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Fix order fetching query based on type parameter
     * @param string $type
     * @return object $orders
     */
    public function order_query($type)
    {
        $order = "";
        //  $posts = Post::whereDate('created_at', Carbon::today())->get();
        if ($type == "history") {
            $order = User::join('orders', 'orders.user_id', '=', 'users.id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('items', 'items.id', '=', 'order_items.item_id')->select("orders.id as order_id", "orders.status as order_status", "orders.created_at as date_time", DB::raw("GROUP_CONCAT(items.title) as title, GROUP_CONCAT(TO_BASE64(items.quantity)) AS quantity, GROUP_CONCAT(items.image) AS image,GROUP_CONCAT(order_items.order_type) AS order_type, GROUP_CONCAT(TO_BASE64(order_items.order_detail)) AS order_detail, GROUP_CONCAT(DISTINCT users.username) AS username, GROUP_CONCAT(DISTINCT users.profile_image) AS profile_image"))->where('orders.vendor_id', Auth::user()->id)->whereIn('orders.status', ['1', '-1'])->groupBy('orders.id')->orderBy('orders.updated_at', 'DESC')->get();
        } else {
            $order = User::join('orders', 'orders.user_id', '=', 'users.id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('items', 'items.id', '=', 'order_items.item_id')->select("orders.id as order_id", "orders.status as order_status", "orders.created_at as date_time", DB::raw("GROUP_CONCAT(items.title) as title, GROUP_CONCAT(TO_BASE64(items.quantity)) AS quantity, GROUP_CONCAT(items.image) AS image,GROUP_CONCAT(order_items.order_type) AS order_type, GROUP_CONCAT(TO_BASE64(order_items.order_detail)) AS order_detail, GROUP_CONCAT(DISTINCT users.username) AS username, GROUP_CONCAT(DISTINCT users.profile_image) AS profile_image"))->where([['orders.vendor_id', '=', Auth::user()->id], ['orders.status', '=', 0]])->groupBy('orders.id')->orderBy('orders.created_at', 'DESC')->get();
        }
        return $order;
    }

    /**
     * Get total amount for user order
     * @param Object $orders
     * @return Int $sum
     */
    public function get_order_total($orders)
    {
        $sum = 0;

        foreach ($orders as $order) {
            $inner_sum = 0;
            foreach ($order->title as $key => $title) {
                if ($order->order_type[$key] == "simple") {
                    $price = (Integer) json_decode($order->quantity[$key], true)['price'];
                    $quantity = (Integer) json_decode($order->order_detail[$key])[0];
                    $inner_sum += ($price * $quantity);
                } else {
                    $inner_details = json_decode($order->order_detail[$key]);
                    $inner_inner_sum = 0;
                    foreach ($inner_details as $inner_detail) {
                        $type = $inner_detail[0];
                        $index = $inner_detail[1];
                        $qty = (Integer) $inner_detail[2];
                        $price = 0;

                        if ($type == "regular") {
                            $price = (Integer) json_decode(json_decode($order->quantity[$key], true)['regular'], true)[$index]['price'];
                        } else {
                            $price = (Integer) json_decode(json_decode($order->quantity[$key], true)['bulk'], true)[$index]['price'];
                        }

                        $inner_inner_sum += ($price * $qty);
                    }
                    $inner_sum += $inner_inner_sum;
                }
            }
            $sum += $inner_sum;
        }
        return $sum;
    }

    /**
     * Convert order status to human readable format
     * @param Integer $order_status
     * @return String $status
     */
    public function order_status($order_status)
    {
        $status = array();

        switch ($order_status) {
            case 0:
                $status['status'] = "Pending";
                $status['colour'] = "badge-info";
                break;
            case 1:
                $status['status'] = "Accepted";
                $status['colour'] = "badge-success";
                break;
            case -1:
                $status['status'] = "Rejected";
                $status['colour'] = "badge-warning";
                break;
            case -2:
                $status['status'] = "Cancelled";
                $status['colour'] = "badge-warning";
                break;
            case -3:
                $status['status'] = "Expired";
                $status['colour'] = "badge-warning";
                break;
        }

        return $status;
    }

    /**
     * Reject user order
     * @param Request $request
     * @return string json response
     */
    public function reject_order(Request $request, $order_id = null)
    {
        try {
            if (!empty($order_id)) {
                // Fetch order
                $order = Order::find($request->order_id);
                $order->status = -1;

                // Update order-item quantity
                $vendor_id = Auth::user()->id;
                OrderItem::query()
                    ->where([['vendor_id', '=', $vendor_id], ['order_id', '=', $order_id]])
                    ->each(function ($record) {
                        // Update item quantity
                        $this->update_reject_quantity($record);
                    });

                // Update order status
                $order->save();
            } else {
                $orders = Order::where([['vendor_id', '=', Auth::user()->id], ['status', '=', 0]]);
                $vendor_id = Auth::user()->id;

                // Update order-item quantity
                foreach ($orders->get() as $order) {
                    // Update order-item quantity
                    OrderItem::query()
                        ->where([['vendor_id', '=', $vendor_id], ['order_id', '=', $order->id]])
                        ->each(function ($record) {
                            // Update item quantity
                            $this->update_reject_quantity($record);
                        });
                }

                // Update order status
                $orders->update(['status' => -1]);
            }
            return response()->json(['success' => true, 'message' => 'Order rejected successfully.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Make necessary changes to the quantity of items when order is rejected
     *
     * @param Request $request
     * @return Array $validate_data
     */
    public function update_reject_quantity($record)
    {
        $item_id = $record->item_id;

        // Get the particular item
        $item = Item::find($item_id);

        if ($record->order_type == "simple") {
            $new_quantity = json_decode($record->order_detail)[0];
            $item_quantity = json_decode($item->quantity, true);
            $item_quantity['quantity'] = ($item_quantity['quantity'] + $new_quantity);
            $item->quantity = json_encode($item_quantity);
        } else {
            $order_detail = json_decode($record->order_detail);
            foreach ($order_detail as $key => $detail) {
                $type = $detail[0];
                $index = $detail[1];
                $order_quantity = $detail[2];
                if ($type == "regular") {
                    // Get values
                    $item_quantity = json_decode($item->quantity, true);
                    $regular_quantity = json_decode($item_quantity['regular']);
                    $sub_item = $regular_quantity[$index];
                    $sub_item->quantity = (string) ($sub_item->quantity + $order_quantity);

                    // Reassign values
                    $regular_quantity[$index] = $sub_item;
                    $item_quantity['regular'] = json_encode($regular_quantity);
                    $item->quantity = json_encode($item_quantity);
                } else {
                    // Get values
                    $item_quantity = json_decode($item->quantity, true);
                    $regular_quantity = json_decode($item_quantity['bulk']);
                    $sub_item = $regular_quantity[$index];
                    $sub_item->quantity = (string) ($sub_item->quantity + $order_quantity);

                    // Reassign values
                    $regular_quantity[$index] = $sub_item;
                    $item_quantity['bulk'] = json_encode($regular_quantity);
                    $item->quantity = json_encode($item_quantity);
                }
            }
        }
        $item->save();
    }

    /**
     * Accept user order
     * @param Request $request
     * @return string json response
     */
    public function accept_order(Request $request, $order_id = null)
    {
        try {
            if (!empty($order_id)) {
                // Fetch order
                $order = Order::find($request->order_id);
                $order->status = 1;

                // Update order status
                $order->save();
            } else {
                $orders = Order::where([['vendor_id', '=', Auth::user()->id], ['status', '=', 0]]);

                // Update order status
                $orders->update(['status' => 1]);
            }
            return response()->json(['success' => true, 'message' => 'Order accepted successfully.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Get user orders
     * @param Request $request
     * @param integer $order_id
     * @param string $type
     * @return Json $response
     */
    public function get_order_detail(Request $request, $order_id)
    {
        try {
            $order = $this->order_detail_query($order_id);
            // $to_check = $order->toArray();

            // Get pending orders for user
            // $pending_count = Order::where([['user_id', '=', Auth::user()->id], ['status', '=', 0]])->count();

            if (!empty($order)) {
                // foreach ($orders as $order) {
                $order->title = explode(',', $order->title);
                $order->quantity = explode(',', $order->quantity);
                $order->order_detail = explode(',', $order->order_detail);

                // Fix order quantity & order details
                $quant_arr = [];
                $ord_arr = [];
                foreach ($order->quantity as $key => $val) {
                    $quant_arr[$key] = base64_decode($val);
                    $ord_arr[$key] = base64_decode($order->order_detail[$key]);
                }
                $order->quantity = $quant_arr;
                $order->order_detail = $ord_arr;
                // Fix order quantity & order details

                // Fix order status
                $order->order_status = $this->order_status($order->order_status);

                $order->image = explode(',', $order->image);
                $order->order_type = explode(',', $order->order_type);
                // }
            } else {
                $order = null;
            }

            // Total amount for orders
            // $total_amount = ($orders == null) ? 0 : $this->get_order_total($orders);

            $order_detail_view = view('vendor.components.order-detail', compact('order'))->render();

            return response()->json(['success' => true, 'order_detail_view' => $order_detail_view], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Fix order-detail fetching query
     *
     * @return object $order
     */
    public function order_detail_query($order_id)
    {
        $order = User::join('orders', 'orders.user_id', '=', 'users.id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('items', 'items.id', '=', 'order_items.item_id')->select("orders.id as order_id", "orders.status as order_status", "orders.created_at as date_time", DB::raw("GROUP_CONCAT(items.title) as title, GROUP_CONCAT(TO_BASE64(items.quantity)) AS quantity, GROUP_CONCAT(items.image) AS image,GROUP_CONCAT(order_items.order_type) AS order_type, GROUP_CONCAT(TO_BASE64(order_items.order_detail)) AS order_detail, GROUP_CONCAT(DISTINCT users.username) AS username, GROUP_CONCAT(DISTINCT users.name) AS name, GROUP_CONCAT(DISTINCT users.phone_number) AS phone, GROUP_CONCAT(DISTINCT users.profile_image) AS profile_image"))->where([['orders.vendor_id', '=', Auth::user()->id], ['orders.id', '=', $order_id]])->groupBy('orders.id')->orderBy('orders.created_at', 'DESC')->first();

        return $order;
    }

    /**
     * Get the total rating for a vendor
     *
     * @param integer $vendor_id
     */
    public function get_rating($vendor_id, $user_id)
    {
        $total_rating = Rating::where('vendor_id', $vendor_id)->selectRaw('SUM(rating)/COUNT(user_id) AS avg_rating')->first()->avg_rating;
        $total_rating = number_format((float) $total_rating, 1, '.', '');

        $user_rating = Rating::where([['user_id', '=', $user_id], ['vendor_id', '=', $vendor_id]]);

        if ($user_rating->count() > 0) {
            $user_rating = true;
        } else {
            $user_rating = false;
        }

        return compact('total_rating', 'user_rating');
    }
}
