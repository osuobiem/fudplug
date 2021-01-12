<?php

namespace App\Http\Controllers;

use App\Area;
use App\Basket;
use App\Item;
use App\Menu;
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
    // Number Of Items Per Page
    private $vendor_paginate = 6;

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
            'name' => 'required|max:25',
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
            'name' => 'required|max:25',
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
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try Again!"]);
        }
    }

    /**
     * Get All Vendors In User Area
     * @return string HTML
     */
    public function all_vendors(Request $request)
    {
        try {
            $area_id = Auth::guard('user')->user()->area_id;
            $option = $request->fetch_status;
            $search_data = $request->search_data;
            $state_data = $request->state_data;
            $area_data = $request->area_data;
            $vendors = "";

            switch ($option) {
                case 'all':
                    $vendors = $this->fetch_all($area_id);
                    break;

                case 'search':
                    $vendors = $this->fetch_search($area_id, $search_data, $state_data, $area_data);
                    break;

                case 'filter':
                    $vendors = $this->fetch_filter($area_id, $search_data, $state_data, $area_data);
                    break;

                default:
                    # code...
                    break;
            }

            // Variable to hold Html
            $html = '';

            foreach ($vendors as $vendor) {
                $html .= $this->card($vendor);
            }

            if ($request->ajax()) {
                return $html;
            } else {
                return view('user.components.view-all', compact('vendors'));
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try Again!"]);
        }
    }

    /**
     * Fetch All Vendors
     * @return Array
     */
    public function fetch_all($area_id)
    {
        $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
            ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
            ->where('areas.id', $area_id)->paginate($this->vendor_paginate);

        return $vendors;
    }

    /**
     * Fetch Vendors Based on Search Keyword
     * @return Array
     */
    public function fetch_search($area_id, $search_data, $state_data, $area_data)
    {
        try {
            $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
                ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where([['vendors.business_name', 'like', '%' . $search_data . '%'], $this->fix_condition('states.id', $state_data), $this->fix_condition('areas.id', $area_data)])->paginate($this->vendor_paginate);
            return $vendors;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try Again!"]);
        }
    }

    /**
     * Fetch Vendors Based on Filter Values
     * @return Array
     */
    public function fetch_filter($area_id, $search_data, $state_data, $area_data)
    {
        try {
            if (empty($search_data)) {
                $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
                    ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                    ->where([$this->fix_condition('states.id', $state_data), $this->fix_condition('areas.id', $area_data)])->paginate($this->vendor_paginate);
            } else {
                $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
                    ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                    ->where([['vendors.business_name', 'like', '%' . $search_data . '%'], $this->fix_condition('states.id', $state_data), $this->fix_condition('areas.id', $area_data)])->paginate($this->vendor_paginate);
            }
            return $vendors;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try Again!"]);
        }
    }

    /**
     * Format "All-Vendors" Card Component
     * @return string HTML
     */
    public function card($vendor)
    {
        $html = "
        <div class=\"col-md-4 col-6 text-center vend mb-2\">
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
        return $html;
    }

    /**
     * Fix Query Conditions Based On Value
     * @return Array
     */
    public function fix_condition($key, $value)
    {
        $condition = [];
        if ($value == "*") {
            $condition = [$key, '<>', $value];
        } else {
            $condition = [$key, '=', $value];
        }
        return $condition;
    }

    /**
     * Vendor Profile Page
     */
    public function vendor_profile($vendor_id)
    {
        try {
            // Get States Data
            $states = State::get();

            // Get Vendor Menu
            $vendor_menu = $this->vendor_menu($vendor_id)['menu_dishes'];

            // Vendor Details
            $vendor = Vendor::where('id', $vendor_id)->first();

            // Fetch Vendor Location Data
            $area_id = $vendor->area_id;
            $vendor_location = State::join('areas', 'areas.state_id', '=', 'states.id')
                ->select(['areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
                ->where('areas.id', $area_id)->first();

            // Get Areas In User State
            $areas = Area::where('state_id', $vendor_location->state_id)->get();

            // Social Media Links
            $social_handles = json_decode($vendor->social_handles);

            return view('user.vendor-profile', compact('vendor', 'vendor_location', 'states', 'areas', 'social_handles', 'vendor_menu'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Fetch Vendor Menu
     * @return Array
     */
    public function vendor_menu($vendor)
    {
        // Fetch the Menu Item
        $menu = Menu::where('vendor_id', $vendor)->first("items");
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
            $menu_count = 0;
            $menu_dishes = null;
        }

        return compact('menu_count', 'menu_dishes');
    }

    /**
     * Get Vendor Dishes
     * @return object Laravel View Instance
     */
    public function order_details(Request $request, $dish_id)
    {
        try {
            $dish = Item::where(['id' => $dish_id])->first();

            $data = [];
            if ($dish->type == "simple") {
                // Get basket items (simple)
                $simple_basket = Basket::where([['user_id', '=', Auth::guard('user')->user()->id], ['order_type', '=', 'simple']])->get();
                $simple_items = [];
                if (!empty($simple_basket)) {
                    foreach ($simple_basket as $key => $val) {
                        $simple_items[$key] = $val->item_id;
                    }
                }

                $qty = json_decode($dish->quantity);
                $data['dish'] = $dish;
                $data['price'] = $qty->price;
                $data['quantity'] = $qty->quantity;
                $data['basket_items'] = $simple_items;
            } else {
                // Get basket items (simple)
                $advanced_basket = Basket::where([['user_id', '=', Auth::guard('user')->user()->id], ['order_type', '=', 'advanced']])->get();
                $advanced_items = [];
                if (!empty($advanced_basket)) {
                    foreach ($advanced_basket as $key => $val) {
                        $basket_item = json_decode($val->order_detail);
                        $items = [];
                        foreach ($basket_item as $inner_key => $inner_val) {
                            $items[$inner_key] = $inner_val[1];
                        }
                        $advanced_items['item' . $val->item_id] = $items;
                    }
                }

                $qty = $dish->quantity = json_decode($dish->quantity);
                $data['dish'] = $dish;
                $data['regular_qty'] = json_decode($qty->regular);
                $data['bulk_qty'] = json_decode($qty->bulk);
                $data['basket_items'] = $advanced_items;
            }
            return view('user.components.regular-order', $data);
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Add items to basket
     * @param Request $request
     * @return String
     */
    public function add_to_basket(Request $request)
    {
        try {
            // Check if the dish already exists
            $dish = Basket::where([['item_id', '=', $request->item_id], ['user_id', '=', Auth::guard('user')->user()->id]]);
            if ($dish->count() > 0) {
                // Append new order details
                $basket_item = Basket::find($dish->first()->id);
                $detail = json_decode($basket_item->order_detail);
                $basket_item->order_detail = json_encode(array_merge($detail, $this->fix_details($request)));
                $basket_item->save();
            } else {
                $basket = new Basket();
                $basket->user_id = Auth::guard('user')->user()->id;
                $basket->vendor_id = $request->vendor_id;
                $basket->item_id = $request->item_id;
                $basket->order_type = $request->order_type;
                $basket->order_detail = json_encode($this->fix_details($request));
                $basket->save();
            }

            return response()->json(['success' => true, 'message' => 'Item added to basket', 'output' => $request->order_type], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Get user basket items
     * @param Request $request
     * @return String
     */
    public function get_basket(Request $request)
    {
        try {
            $basket = Item::join('baskets', 'baskets.item_id', '=', 'items.id')
                ->select(['items.title', 'items.quantity', 'items.image', 'baskets.id', 'baskets.order_type', 'baskets.order_detail'])
                ->where('baskets.user_id', Auth::guard('user')->user()->id);

            $basket_count = $basket->count();
            $basket_items = $basket->get();

            // dd($basket_items);

            $basket_view = view('user.components.basket', compact('basket_items'))->render();

            return response()->json(['success' => true, 'basket_view' => $basket_view, 'basket_count' => $basket_count], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }

    /**
     * Construct order details based on order type
     * @param Request $request
     * @return Array $order_detail
     */
    public function fix_details(Request $request)
    {
        $order_detail = $request->order_detail;
        $order_quantity = $request->order_quantity;

        if ($request->order_type == "simple") {
            $order_detail[0] = $order_quantity[0];
        } else {
            foreach ($order_detail as $key => $val) {
                $val = $this->to_array($val);
                if ($val[0] == "regular") {
                    $val[2] = $order_quantity[$key];
                }
                $order_detail[$key] = $val;
            }
        }

        return $order_detail;
    }

    public function to_array($str)
    {
        $str = substr($str, 1, strlen($str));
        $str = substr($str, 0, strlen($str) - 1);
        $str = str_replace("'", "", $str);

        return explode(',', $str);
    }

    /**
     * Remove item from basket
     * @param Request $request
     * @return Json $response
     */
    public function delete_basket(Request $request)
    {
        try {
            if ($request->order_type == "simple") {
                Basket::where([['id', '=', $request->basket_id], ['user_id', '=', Auth::guard('user')->user()->id]])->delete();
            } else {
                $basket_item = Basket::find($request->basket_id);
                $order_detail = json_decode($basket_item->order_detail);
                if (count($order_detail) > 1) {
                    unset($order_detail[$request->item_position]);
                    $basket_item->order_detail = json_encode(array_values($order_detail));
                    $basket_item->save();
                } else {
                    Basket::where([['id', '=', $request->basket_id], ['user_id', '=', Auth::guard('user')->user()->id]])->delete();
                }
            }
            return response()->json(['success' => true, 'message' => 'Item removed from basket'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try Again!"], 500);
        }
    }
}
