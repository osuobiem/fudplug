<?php

namespace App\Http\Controllers;

use App\Area;
use App\Item;
use App\Menu;
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
    public function profile()
    {
        try {
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
        } catch (\Throwable $th) {
            Log::error($th);
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
                $vendor = Vendor::find(Auth::user()->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "ven_" . Auth::user()->id . '_' . time() . '.' . $extension;
                // Previous Image
                $prev_image = Auth::user()->profile_image;
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
                $vendor = Vendor::find(Auth::user()->id);
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('image')->getClientOriginalExtension();
                // Filename to store
                $image = "cover_" . Auth::user()->id . '_' . time() . '.' . $extension;
                // Delete prev image
                Storage::delete('/public/vendor/cover/' . Auth::user()->cover_image);
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
                return response()->json(['success' => false, 'message' => $validator->errors('image')->messages()], 200);
            } else {
                if ($request->form_type == "simple") {
                    $this->simple_put($request);
                } else {
                    $this->advanced_put($request);
                }
                return response()->json(['success' => true, 'message' => "Your dish was successfully uploaded."], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Process Vendor Simple Dish Upload
     * @return void
     */
    public function simple_put($request)
    {
        foreach ($request->title as $key => $value) {
            $data = [
                'title' => $value,
                'quantity' => json_encode(['price' => $request->price[$key], 'quantity' => $request->quantity[$key]]),
                'image' => $this->dish_img_upload($request, $key) ? $this->dish_img_upload($request, $key) : null,
                'type' => "simple",
            ];
            $item = new Item($data);
            $vendor = Vendor::find(Auth::user()->id);
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
            $vendor = Vendor::find(Auth::user()->id);
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
            $image = $request->title[$key] . Auth::user()->id . '_' . time() . '.' . $extension;
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

        if (empty($key)) {
            // Executed when editing dish
            foreach ($request->regular_title as $key => $value) {
                $regular_arr[$key] = ['title' => $value, 'price' => $request->regular_price[$key], 'quantity' => $request->regular_quantity[$key]];
            }
        } else {
            // Executed when uploading dish
            switch ($key) {
                case 0:
                    # Array for first group of quantities
                    foreach ($request->regular_title_one as $key_one => $value_one) {
                        $regular_arr[$key_one] = ['title' => $value_one, 'price' => $request->regular_price_one[$key_one], 'quantity' => $request->regular_quantity_one[$key_one]];
                    }
                    break;

                case 1:
                    # Array for second group of quantities
                    foreach ($request->regular_title_two as $key_two => $value_two) {
                        $regular_arr[$key_two] = ['title' => $value_two, 'price' => $request->regular_price_two[$key_two], 'quantity' => $request->regular_quantity_two[$key_two]];
                    }
                    break;

                case 2:
                    # Array for third group of quantities
                    foreach ($request->regular_title_three as $key_three => $value_three) {
                        $regular_arr[$key_three] = ['title' => $value_three, 'price' => $request->regular_price_three[$key_three], 'quantity' => $request->regular_quantity_three[$key_three]];
                    }
                    break;

                case 3:
                    # Array for fourth group of quantities
                    foreach ($request->regular_title_four as $key_four => $value_four) {
                        $regular_arr[$key_four] = ['title' => $value_four, 'price' => $request->regular_price_four[$key_four], 'quantity' => $request->regular_quantity_four[$key_four]];
                    }
                    break;

                case 4:
                    # Array for fifth group of quantities
                    foreach ($request->regular_title_five as $key_five => $value_five) {
                        $regular_arr[$key_five] = ['title' => $value_five, 'price' => $request->regular_price_five[$key_five], 'quantity' => $request->regular_quantity_five[$key_five]];
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

        if (empty($key)) {
            // Executed when editing dish
            foreach ($request->bulk_title as $key => $value) {
                $bulk_arr[$key] = ['title' => $value, 'price' => $request->bulk_price[$key]];
            }
        } else {
            if (in_array(null, $request->bulk_title_one) || in_array(null, $request->bulk_price_one)) {
                $bulk_arr = null;
            } else {
                switch ($key) {
                    case 0:
                        # Array for first group of quantities
                        foreach ($request->bulk_title_one as $key_one => $value_one) {
                            $bulk_arr[$key_one] = ['title' => $value_one, 'price' => $request->bulk_price_one[$key_one]];
                        }
                        break;

                    case 1:
                        # Array for second group of quantities
                        foreach ($request->bulk_title_two as $key_two => $value_two) {
                            $bulk_arr[$key_two] = ['title' => $value_two, 'price' => $request->bulk_price_two[$key_two]];
                        }
                        break;

                    case 2:
                        # Array for third group of quantities
                        foreach ($request->bulk_title_three as $key_three => $value_three) {
                            $bulk_arr[$key_three] = ['title' => $value_three, 'price' => $request->bulk_price_three[$key_three]];
                        }
                        break;

                    case 3:
                        # Array for fourth group of quantities
                        foreach ($request->bulk_title_four as $key_four => $value_four) {
                            $bulk_arr[$key_four] = ['title' => $value_four, 'price' => $request->bulk_price_four[$key_four]];
                        }
                        break;

                    case 4:
                        # Array for fifth group of quantities
                        foreach ($request->bulk_title_five as $key_five => $value_five) {
                            $bulk_arr[$key_five] = ['title' => $value_five, 'price' => $request->bulk_price_five[$key_five]];
                        }
                        break;

                    default:
                        # code...
                        break;
                }
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
            'required' => 'All except bulk fields are required.',
            'alpha_dash' => 'Title fields only allow alphabets, hyphens and underscores.',
            'mimes' => 'Images must be of type jpg or jpeg.',
            'numeric' => 'Quantity and price fields must be numeric characters.',
            'max' => 'The :attribute may not be greater than 25mb.',

        ];
        // Make and return validation rules
        return Validator::make($request->all(), [
            'title.*' => 'required',
            'image.*' => 'required|image|mimes:jpeg,jpg|max:25000',
            'regular_title_one.*' => 'required',
            'regular_price_one.*' => 'required|numeric',
            'regular_quantity_one.*' => 'required|numeric',
            'bulk_title_one.*' => 'nullable',
            'bulk_price_one.*' => 'nullable|numeric',

            'regular_title_two.*' => 'required',
            'regular_price_two.*' => 'required|numeric',
            'regular_quantity_two.*' => 'required|numeric',
            'bulk_title_two.*' => 'nullable',
            'bulk_price_two.*' => 'nullable|numeric',

            'regular_title_three.*' => 'required',
            'regular_price_three.*' => 'required|numeric',
            'regular_quantity_three.*' => 'required|numeric',
            'bulk_title_three.*' => 'nullable',
            'bulk_price_three.*' => 'nullable|numeric',

            'regular_title_four.*' => 'required',
            'regular_price_four.*' => 'required|numeric',
            'regular_quantity_four.*' => 'required|numeric',
            'bulk_title_four.*' => 'nullable',
            'bulk_price_four.*' => 'nullable|numeric',

            'regular_title_five.*' => 'required',
            'regular_price_five.*' => 'required|numeric',
            'regular_quantity_five.*' => 'required|numeric',
            'bulk_title_five.*' => 'nullable',
            'bulk_price_five.*' => 'nullable|numeric',

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
                $dish = Item::where(['vendor_id' => Auth::user()->id, 'id' => $dish_id])->first();
                $data = [];
                if ($dish->type == "simple") {
                    $qty = json_decode($dish->quantity);
                    $data['dish'] = $dish;
                    $data['price'] = $qty->price;
                    $data['quantity'] = $qty->quantity;
                } else {
                    $qty = $dish->quantity = json_decode($dish->quantity);
                    $data['dish'] = $dish;
                    $data['regular_qty'] = json_decode($qty->regular);
                    $data['bulk_qty'] = json_decode($qty->bulk);
                }
                return view('vendor.components.dish-view', $data);
            } else {
                // Get All Vendor Dishes
                $dish_data = Item::where('vendor_id', Auth::user()->id);

                if ($dish_data->count() > 0) {
                    // Set Dish Parameters
                    $dish_count = $dish_data->count();
                    $dishes = $dish_data->get();

                    // Fetch the Menu Item
                    $menu_data = Menu::where('vendor_id', Auth::user()->id)->first("items");
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
                    $item->quantity = json_encode(['price' => $request->price, 'quantity' => $request->quantity]);
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
            'mimes' => 'Images must be of type jpg or jpeg.',
            'numeric' => 'Quantity and price fields must be numeric characters.',
            'max' => 'The :attribute may not be greater than 25mb.',

        ];
        // Make and return validation rules
        if ($request->form_type == "simple") {
            return Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,jpg|max:25000',
                'price' => 'required|numeric',
                'quantity' => 'required|numeric',
            ], $message);
        } else {
            return Validator::make($request->all(), [
                'title' => 'required',
                'image' => 'image|mimes:jpeg,jpg|max:25000',
                'regular_title.*' => 'required',
                'regular_price.*' => 'required|numeric',
                'regular_quantity.*' => 'required|numeric',
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
            $image = $request->title . Auth::user()->id . '_' . time() . '.' . $extension;
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
            $dishes = Item::where('vendor_id', Auth::user()->id)->get();

            if (!empty($dishes)) {
                // Fetch the Menu Item
                $menu = Menu::where('vendor_id', Auth::user()->id)->first("items");
                if (!empty($menu)) {
                    $menu = json_decode($menu);

                    // Get the Array of Dish IDs
                    $menu_items = json_decode($menu->items);
                    $menu_items = $menu_items->item;

                    if (!empty($menu)) {
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
            Menu::updateOrCreate(['vendor_id' => Auth::user()->id], ['items' => json_encode($items)]);
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
            $dish = Item::where(['vendor_id' => Auth::user()->id, 'id' => $dish_id])->first();
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
            $dish = Item::find($dish_id);
            $dish->forceDelete();

            return response()->json(['success' => true, 'message' => "Dish Deleted Successfully"], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
