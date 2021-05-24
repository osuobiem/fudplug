<?php

namespace App\Http\Controllers;

use App\Area;
use App\Basket;
use App\Item;
use App\Jobs\EmailJob;
use App\Menu;
use App\Order;
use App\OrderItem;
use App\Rating;
use App\Rules\MatchOldPassword;
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
        $user->email_verification_token = Str::random(32);

        // Try user save or catch error if any
        try {
            $user->save();

            // Send verification email by dispatching email job five seconds after it has been dispatched
            $job_data = ['email_type' => 'email_verification', 'user_data' => ['user' => $user, 'link' => route('verify', $user->email_verification_token)]];
            EmailJob::dispatch($job_data)->delay(now()->addSeconds(1));

            // Add user email to session to be used for resending verification emails
            session()->put('verify_email', [$user->email, "registration"]);

            // Attempt login
            // $this->fast_login($request);

            return ['success' => true, 'status' => 200, 'message' => 'Signup Successful.'];
        } catch (\Throwable $th) {
            Log::error($th);
            return ['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try again!'];
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
                $view = view('user.components.right-side-mobile', compact('user_location'))->render();
            } else {
                $view = view('user.components.right-side-desktop', compact('user_location'))->render();
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
                return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Try again!'], 500);
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
        try {
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

            $this->update_store($request);

            return response()->json(['success' => true, 'status' => 200, 'message' => 'Update Successful'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Try again!'], 500);
        }
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

        $username = $user->username;

        // Assign user object properties
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->area_id = $request->area;
        $user->address = $request->address;

        $socket = SocketData::where('username', $username)->first();
        $socket->username = $user->username;

        $user->save();
        $socket->save();
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
            return response()->json(['success' => false, 'status' => 500, 'message' => 'Oops! Something went wrong. Try again!']);
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
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try again!"]);
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

            // Format "All-Vendors" Card Component
            foreach ($vendors as $vendor) {
                $vendor->cover_image = Storage::url("vendor/cover/") . $vendor->cover_image;
                $vendor->profile_image = Storage::url('vendor/profile/') . $vendor->profile_image;
                $html .= view('user.components.view-all-card', compact('vendor'));
            }

            if ($request->ajax()) {
                return $html;
            } else {
                return view('user.components.view-all', compact('vendors'));
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => "Oops! Something went wrong. Try again!"]);
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
        $vendors = Vendor::join('areas', 'areas.id', '=', 'vendors.area_id')
            ->join('states', 'areas.state_id', '=', 'states.id')->select(['vendors.business_name as business_name', 'vendors.username as username', 'vendors.id as vendor_id', 'vendors.cover_image as cover_image', 'vendors.profile_image as profile_image', 'areas.name AS area', 'areas.id AS area_id', 'states.name AS state', 'states.id AS state_id'])
            ->where([['vendors.business_name', 'like', '%' . $search_data . '%'], $this->fix_condition('states.id', $state_data), $this->fix_condition('areas.id', $area_data)])->orWhere([['vendors.username', 'like', '%' . $search_data . '%']])->paginate($this->vendor_paginate);
        return $vendors;
    }

    /**
     * Fetch Vendors Based on Filter Values
     * @return Array
     */
    public function fetch_filter($area_id, $search_data, $state_data, $area_data)
    {
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
    public function vendor_profile($username)
    {
        try {
            $vendor = Vendor::where('username', $username)->firstOrFail();

            $vendor_location = Auth::user('vendor')->areas;

            // Social Media Links
            $social_handles = json_decode($vendor->social_handles);

            // Rating Data
            $rating_data = Auth::guard('user')->guest() ? $this->get_rating($vendor->id, 0) : $this->get_rating($vendor->id, Auth::guard('user')->user()->id);

            return ['status' => true, 'data' => compact('vendor', 'vendor_location', 'social_handles', 'rating_data', 'vendor')];
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Fetch Vendor Menu
     *
     * @param Request $request
     * @param int $vendor
     * @return Array
     */
    public function vendor_menu(Request $request, $vendor)
    {
        try {
            $curr_page = $request->page;

            // Fetch the Menu Item
            $menu = Menu::where('vendor_id', $vendor)->first();

            if (!empty($menu)) {
                $menu = json_decode($menu->items);

                // Get the Array of Dish IDs
                $menu_items = $menu->item;

                if (!empty($menu_items)) {
                    // Fetch Dishes for Menu
                    $menu_data = Item::select("*")
                        ->whereIn('id', $menu_items);
                    $menu_count = $menu_data->count();
                    $menu_dishes = $menu_data->paginate(6);
                    $paginate_count = $menu_dishes->count();
                } else {
                    $menu_count = 0;
                    $menu_dishes = null;
                    $paginate_count = 0;
                }
            } else {
                $menu_count = 0;
                $menu_dishes = null;
                $paginate_count = 0;
            }

            // Prepare next page
            $next_page = $paginate_count > 0 ? ($curr_page + 1) : (int) $curr_page;

            // Get view data
            $menu_view = view('user.components.vendor-menu', compact('curr_page', 'menu_dishes'));

            // dd($menu_view->render());

            // return compact('menu_count', 'menu_dishes');
            return response()->json(['success' => true, 'next_page' => $next_page, 'menu_view' => $menu_view->render()], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Get Vendor Dishes
     * @return object Laravel View Instance
     */
    public function order_details(Request $request, $dish_id, $dish_type = null)
    {
        try {
            // Check if user's address is set
            $address = User::where('id', Auth::guard('user')->user()->id)->first()->address;
            if (empty($address)) {
                return response()->json(['success' => false, 'message' => 'Please add an address to your profile in order to continue.'], 200);
            }

            $dish = Item::where(['id' => $dish_id])->first();

            $view = "";

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
                $data['qty_title'] = $qty->qty_title;
                $data['basket_items'] = $simple_items;

                $view = view('user.components.regular-order', $data);
            } else {
                // Get basket items (simple)
                $advanced_basket = Basket::where([['user_id', '=', Auth::guard('user')->user()->id], ['order_type', '=', 'advanced']])->get();
                $advanced_items = [];
                if (!empty($advanced_basket)) {
                    foreach ($advanced_basket as $key => $val) {
                        $basket_item = json_decode($val->order_detail);
                        $regular_items = [];
                        $bulk_items = [];
                        foreach ($basket_item as $inner_key => $inner_val) {
                            if ($inner_val[0] == 'regular') {
                                $regular_items[$inner_key] = $inner_val[1];
                            } else {
                                $bulk_items[$inner_key] = $inner_val[1];
                            }
                        }
                        $advanced_items['item' . $val->item_id] = ['regular_items' => $regular_items, 'bulk_items' => $bulk_items];
                    }
                }

                $qty = $dish->quantity = json_decode($dish->quantity);
                $data['dish'] = $dish;
                $data['regular_qty'] = json_decode($qty->regular);
                $data['bulk_qty'] = json_decode($qty->bulk);
                $data['basket_items'] = $advanced_items;

                if (empty($dish_type)) {
                    $view = view('user.components.regular-order', $data);
                } else {
                    $view = view('user.components.bulk-order', $data);
                }
            }

            return response()->json(['success' => true, 'data' => $view->render()], 200);
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

            // Validate basket request (Returns boolean value when correct and array when wrong)
            $result = gettype($this->validate_quantity($request));
            if ($result != "boolean") {
                return response()->json(['success' => true, 'type' => 'error', 'message' => 'Quantity error', 'data' => $this->validate_quantity($request), 'order_type' => $request->order_type], 200);
            }

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

            return response()->json(['success' => true, 'type' => 'success', 'message' => 'Item added to basket', 'output' => $request->order_type], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Check if quantity requested is available
     * @param Request $request
     * @return Boolean true
     * @return Array $validate_info
     */
    public function validate_quantity(Request $request)
    {
        // Fetch item
        $item = Item::where([['id', '=', $request->item_id], ['vendor_id', '=', $request->vendor_id]])->first();

        $order_detail = $request->order_detail;
        $order_quantity = $request->order_quantity;
        $validate_info = array();

        if ($request->order_type == "simple") {
            $available_qty = json_decode($item->quantity, true)['quantity'];
            $order_qty = $order_quantity[0];
            if ($order_qty > $available_qty) {
                $validate_info['item'] = 'item-' . $request->item_id;
                $validate_info['new_qty'] = $available_qty;
            } else {
                $validate_info = true;
            }
        } else {
            $i = 0;
            $err_count = 0;
            $validate_info = array();
            foreach ($order_detail as $key => $val) {
                $val = $this->to_array($val);
                if ($val[0] == "regular") {
                    $index = $val[1];
                    $available_qty = json_decode(json_decode($item->quantity, true)['regular'], true)[$index]['quantity'];
                    $order_qty = $request->order_quantity[$key];
                    if ($order_qty > $available_qty) {
                        $validate_info[$i] = ['item' => 'item-' . $request->item_id . '-' . $index, 'new_qty' => $available_qty];
                    } else {
                        $err_count++;
                    }
                    $i++;
                } else {
                    $index = $val[1];
                    $available_qty = json_decode(json_decode($item->quantity, true)['bulk'], true)[$index]['quantity'];
                    $order_qty = $request->order_quantity[$key];
                    if ($order_qty > $available_qty) {
                        $validate_info[$i] = ['item' => 'item-' . $request->item_id . '-' . $index, 'new_qty' => $available_qty];
                    } else {
                        $err_count++;
                    }
                    $i++;
                }
            }

            if ($err_count == $i) {
                $validate_info = true;
            }
        }

        return $validate_info;
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

            // Early return for when basket is empty
            if ($basket_count < 1) {
                return response()->json(['success' => true, 'basket_count' => $basket_count, 'paginate_count' => 0, 'total_price' => 0, 'next_page' => 1], 200);
            }

            $total_price = $this->get_basket_total($basket->get());
            $basket_items = $basket->paginate(6);
            $paginate_count = $basket_items->count();
            $curr_page = $request->page;

            // Prepare next page
            $next_page = $paginate_count > 0 ? ($curr_page + 1) : (int) $curr_page;

            $basket_view = view('user.components.basket', compact('basket_items', 'curr_page'))->render();

            if ($paginate_count > 0) {
                // Initiate validation of basket
                $result = $this->validate_order_quantity();

                if ($result['track_err'] > 0) {
                    return response()->json(['success' => true, 'basket_view' => $basket_view, 'basket_count' => $basket_count, 'paginate_count' => $paginate_count, 'total_price' => $total_price, 'next_page' => $next_page, 'validate_status' => true, 'data' => $result['validate_data']], 200);
                } else {
                    return response()->json(['success' => true, 'basket_view' => $basket_view, 'basket_count' => $basket_count, 'paginate_count' => $paginate_count, 'total_price' => $total_price, 'next_page' => $next_page, 'validate_status' => false], 200);
                }
            } else {
                return response()->json(['success' => true, 'basket_view' => $basket_view, 'basket_count' => $basket_count, 'paginate_count' => $paginate_count, 'total_price' => $total_price, 'next_page' => $next_page], 200);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Get total amount for user basket
     * @param Object $basket
     * @return Int $sum
     */
    public function get_basket_total($basket)
    {
        $sum = 0;

        foreach ($basket as $bas) {
            $inner_sum = 0;
            $order_detail = json_decode($bas->order_detail, true);

            if ($bas->order_type == "simple") {
                $price = (Integer) json_decode($bas->quantity, true)['price'];
                $quantity = (Integer) json_decode($bas->order_detail)[0];
                $inner_sum += ($price * $quantity);
            } else {
                $inner_inner_sum = 0;
                foreach ($order_detail as $key => $detail) {
                    $type = $detail[0];
                    $index = $detail[1];
                    $qty = (Integer) $detail[2];
                    $price = 0;

                    if ($type == "regular") {
                        $price = (Integer) json_decode(json_decode($bas->quantity, true)['regular'], true)[$index]['price'];
                    } else {
                        $price = (Integer) json_decode(json_decode($bas->quantity, true)['bulk'], true)[$index]['price'];
                    }

                    $inner_inner_sum += ($price * $qty);
                }
                $inner_sum += $inner_inner_sum;
            }

            $sum += $inner_sum;
        }
        return $sum;
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
                $val[2] = $order_quantity[$key];
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
                Basket::where([['id', '=', $request->basket_id], ['user_id', '=', Auth::guard('user')->user()->id]])->forceDelete();
            } else {
                $basket_item = Basket::find($request->basket_id);
                $order_detail = json_decode($basket_item->order_detail);
                if (count($order_detail) > 1) {
                    unset($order_detail[$request->item_position]);
                    $basket_item->order_detail = json_encode(array_values($order_detail));
                    $basket_item->save();
                } else {
                    Basket::where([['id', '=', $request->basket_id], ['user_id', '=', Auth::guard('user')->user()->id]])->forceDelete();
                }
            }

            // Get updated basket total
            $basket = Item::join('baskets', 'baskets.item_id', '=', 'items.id')
                ->select(['items.title', 'items.quantity', 'items.image', 'baskets.id', 'baskets.order_type', 'baskets.order_detail'])
                ->where('baskets.user_id', Auth::guard('user')->user()->id);

            $total_price = $this->get_basket_total($basket->get());

            return response()->json(['success' => true, 'total_price' => $total_price, 'message' => 'Item removed from basket'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Update item in basket
     * @param Request $request
     * @return Json $response
     */
    public function update_basket(Request $request)
    {
        try {
            if ($request->order_type == "simple") {
                $basket_item = Basket::find($request->basket_id);
                $order_detail = json_decode($basket_item->order_detail);
                $order_detail[0] = $request->quantity;
                $basket_item->order_detail = json_encode($order_detail);
                $basket_item->save();
            } else {
                $basket_item = Basket::find($request->basket_id);
                $order_detail = json_decode($basket_item->order_detail);
                $detail_item = $order_detail[$request->item_position];
                $detail_item[2] = $request->quantity;
                $order_detail[$request->item_position] = $detail_item;
                $basket_item->order_detail = json_encode($order_detail);
                $basket_item->save();
            }

            // Get updated basket total
            $basket = Item::join('baskets', 'baskets.item_id', '=', 'items.id')
                ->select(['items.title', 'items.quantity', 'items.image', 'baskets.id', 'baskets.order_type', 'baskets.order_detail'])
                ->where('baskets.user_id', Auth::guard('user')->user()->id);

            $total_price = $this->get_basket_total($basket->get());

            return response()->json(['success' => true, 'total_price' => $total_price, 'message' => 'Item updated'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Place order
     * @param Request $request
     * @return Json $response
     */
    public function place_order(Request $request)
    {
        try {
            // Validate order request
            $result = $this->validate_order_quantity();
            if ($result['track_err'] > 0) {
                return response()->json(['success' => true, 'type' => 'error', 'message' => 'Quantity error', 'data' => $result['validate_data']], 200);
            }

            $user_id = Auth::guard('user')->user()->id;
            $vendor_ids = Basket::where('user_id', $user_id)->groupBy('vendor_id')->get(['vendor_id']);

            foreach ($vendor_ids as $key => $val) {
                // $id_arr[$key] = $val->vendor_id;
                $order = new Order();
                $order->user_id = $user_id;
                $order->vendor_id = $val->vendor_id;
                $order->status = 0;
                $order->save();

                Basket::query()
                    ->where([['user_id', '=', $user_id], ['vendor_id', '=', $val->vendor_id]])
                    ->each(function ($old_record) use ($order) {
                        $new_record = $old_record->replicate();
                        $new_record->setTable('order_items');
                        $new_record->order_id = $order->id;
                        $new_record->save();

                        // Delete old basket record
                        $old_record->forceDelete();

                        // Update item quantity
                        $this->update_quantity($new_record);
                    });

                // Unset the order variable
                unset($order);
            }

            return response()->json(['success' => true, 'message' => 'Your order was placed successfully.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Make necessary changes to the quantity of items ordered
     *
     * @param Request $request
     * @return Array $validate_data
     */
    public function update_quantity($new_record)
    {
        $item_id = $new_record->item_id;

        // Get the particular item
        $item = Item::find($item_id);

        if ($new_record->order_type == "simple") {
            $new_quantity = json_decode($new_record->order_detail)[0];
            $item_quantity = json_decode($item->quantity, true);
            $item_quantity['quantity'] = ($item_quantity['quantity'] - $new_quantity);
            $item->quantity = json_encode($item_quantity);
        } else {
            $order_detail = json_decode($new_record->order_detail);
            foreach ($order_detail as $key => $detail) {
                $type = $detail[0];
                $index = $detail[1];
                $order_quantity = $detail[2];
                if ($type == "regular") {
                    // Get values
                    $item_quantity = json_decode($item->quantity, true);
                    $regular_quantity = json_decode($item_quantity['regular']);
                    $sub_item = $regular_quantity[$index];
                    $sub_item->quantity = (string) ($sub_item->quantity - $order_quantity);

                    // Reassign values
                    $regular_quantity[$index] = $sub_item;
                    $item_quantity['regular'] = json_encode($regular_quantity);
                    $item->quantity = json_encode($item_quantity);
                } else {
                    // Get values
                    $item_quantity = json_decode($item->quantity, true);
                    $regular_quantity = json_decode($item_quantity['bulk']);
                    $sub_item = $regular_quantity[$index];
                    $sub_item->quantity = (string) ($sub_item->quantity - $order_quantity);

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
     * Check if quantity requested is available when placing order
     *
     * @param Request $request
     * @return Array $validate_data
     */
    public function validate_order_quantity()
    {
        // Fetch item
        $basket_items = Basket::where('user_id', Auth::guard('user')->user()->id)->get();
        $validate_data = array();

        $track_err = 0;

        foreach ($basket_items as $key => $basket_item) {
            $item = Menu::where('vendor_id', $basket_item->vendor_id)->first()->items;
            $item = json_decode($item, true)['item'];
            $validate_info = array();

            // Vendor menu empty
            if (!empty($item)) {
                // Do something when menu is not empty (check if item exists in nonempty menu)
                if (in_array($basket_item->item_id, $item)) {
                    $item = Item::find($basket_item->item_id);

                    // Item exists in vendor menu
                    if ($basket_item->order_type == "simple") {
                        $available_qty = json_decode($item->quantity, true)['quantity'];
                        $order_qty = json_decode($basket_item->order_detail, true)[0];
                        if ($order_qty > $available_qty) {
                            $validate_info['validate_type'] = "item_in_menu";
                            $validate_info['item'] = 'inner-item-' . $basket_item->id;
                            $validate_info['new_qty'] = $available_qty;
                            $validate_info['status'] = true;
                            $validate_info['order_type'] = $basket_item->order_type;
                            $track_err++;
                        } else {
                            $validate_info['validate_type'] = "item_in_menu";
                            $validate_info['status'] = false;
                            $validate_info['order_type'] = $basket_item->order_type;
                        }
                    } else {
                        $i = 0;
                        $err_count = 0;
                        $validate_info = array();
                        $order_detail = json_decode($basket_item->order_detail, true);
                        $error_data = array();

                        foreach ($order_detail as $key => $val) {
                            // $val = $this->to_array($val);
                            if ($val[0] == "regular") {
                                $index = $val[1];
                                $available_qty = json_decode(json_decode($item->quantity, true)['regular'], true)[$index]['quantity'];
                                $order_qty = $val[2];
                                if ($order_qty > $available_qty) {
                                    $error_data[$i] = ['item' => 'inner-item-' . $basket_item->id . '-' . $index, 'new_qty' => $available_qty];
                                } else {
                                    $err_count++;
                                }
                                $i++;
                            } else {
                                $index = $val[1];
                                $available_qty = json_decode(json_decode($item->quantity, true)['bulk'], true)[$index]['quantity'];
                                $order_qty = $val[2];
                                if ($order_qty > $available_qty) {
                                    $error_data[$i] = ['item' => 'inner-item-' . $basket_item->id . '-' . $index, 'new_qty' => $available_qty];
                                } else {
                                    $err_count++;
                                }
                                $i++;
                            }
                        }

                        if ($err_count == $i) {
                            $validate_info['validate_type'] = "item_in_menu";
                            $validate_info['status'] = false;
                            $validate_info['order_type'] = $basket_item->order_type;
                        } else {
                            $validate_info['validate_type'] = "item_in_menu";
                            $validate_info['status'] = true;
                            $validate_info['order_type'] = $basket_item->order_type;
                            $validate_info['error_data'] = $error_data;
                            $track_err++;
                        }
                    }
                } else {
                    // Item not in vendor menu
                    $validate_info['validate_type'] = "item_not_in_menu";
                    $validate_info['item'] = 'item-' . $basket_item->id;
                    $validate_info['status'] = true;
                    $validate_info['order_type'] = $basket_item->order_type;
                    $track_err++;
                }
            } else {
                // Do something when menu is empty
                $validate_info['validate_type'] = "vendor_menu_empty";
                $validate_info['item'] = 'item-' . $basket_item->id;
                $validate_info['status'] = true;
                $validate_info['order_type'] = $basket_item->order_type;
                $track_err++;
            }

            $validate_data[$key] = $validate_info;
        }

        return compact('validate_data', 'track_err');
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

            // Get pending orders for user
            $pending_count = Order::where([['user_id', '=', Auth::guard('user')->user()->id], ['status', '=', 0]])->count();

            // Current page
            $curr_page = $request->page;

            if (!empty($orders->get()->toArray())) {
                // Total amount for orders
                $total_amount = $this->get_order_total($this->fix_order($orders->get()));

                // Paginated order data
                $order_pag = $this->fix_order($orders->paginate(6));

                $orders = $this->fix_order($orders->get());

                // Prepare next page
                $next_page = $order_pag->count() > 0 ? ($curr_page + 1) : (int) $curr_page;
            } else {
                $order_pag = null;
                $orders = null;

                // Prepare next page
                $next_page = (int) $curr_page;

                // Total amount for orders
                $total_amount = 0;
            }

            $order_view = view('user.components.order', compact('order_pag', 'curr_page'))->render();

            return response()->json(['success' => true, 'order_view' => $order_view, 'total_amount' => $total_amount, 'pending_count' => $pending_count, 'next_page' => $next_page], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Fix order attributes
     * @param object $orders
     * @return object $orders
     */
    public function fix_order($orders)
    {
        $j = 0;

        foreach ($orders as $order) {
            $order->title = explode(',', $order->title);
            $order->quantity = explode('],', $order->quantity);
            $order->order_detail = explode(',', $order->order_detail);

            // Fix order quantity & order details
            $quant_arr = [];
            $ord_arr = [];
            foreach ($order->quantity as $key => $val) {
                $quant_arr[$key] = $this->fix_order_qty($val);
                $ord_arr[$key] = base64_decode($order->order_detail[$key]);
            }

            $order->quantity = $quant_arr;
            $order->order_detail = $ord_arr;
            // Fix order quantity & order details

            // Fix order status
            $order->order_status = $this->order_status($order->order_status);

            $order->image = explode(',', $order->image);
            $order->order_type = explode(',', $order->order_type);
            $j++;
        }
        return $orders;
    }

    /**
     * Prepare order quantity fetched from database
     * @param string $order_quantity
     * @return string $refined
     */
    public function fix_order_qty($order_quantity)
    {
        $refined = trim(trim($order_quantity, '['), ']');
        return $refined;
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
            $order = Vendor::join('orders', 'orders.vendor_id', '=', 'vendors.id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('items', 'items.id', '=', 'order_items.item_id')->select("orders.id as order_id", "orders.status as order_status", DB::raw("GROUP_CONCAT(items.title) as title, GROUP_CONCAT(CONCAT('[', items.quantity, ']')) AS quantity, GROUP_CONCAT(items.image) AS image,GROUP_CONCAT(order_items.order_type) AS order_type, GROUP_CONCAT(TO_BASE64(order_items.order_detail)) AS order_detail, GROUP_CONCAT(DISTINCT vendors.business_name) AS vendor_name, GROUP_CONCAT(DISTINCT vendors.cover_image) AS vendor_image"))->where('orders.user_id', Auth::guard('user')->user()->id)->whereIn('orders.status', ['1', '-1', '-2'])->groupBy('orders.id')->orderBy('orders.updated_at', 'DESC');
        } else {
            $order = Vendor::join('orders', 'orders.vendor_id', '=', 'vendors.id')->join('order_items', 'order_items.order_id', '=', 'orders.id')->join('items', 'items.id', '=', 'order_items.item_id')->select("orders.id as order_id", "orders.status as order_status", DB::raw("GROUP_CONCAT(items.title) as title, GROUP_CONCAT(CONCAT('[', items.quantity, ']')) AS quantity, GROUP_CONCAT(items.image) AS image,GROUP_CONCAT(order_items.order_type) AS order_type, GROUP_CONCAT(TO_BASE64(order_items.order_detail)) AS order_detail, GROUP_CONCAT(DISTINCT vendors.business_name) AS vendor_name, GROUP_CONCAT(DISTINCT vendors.cover_image) AS vendor_image"))->where([['orders.user_id', '=', Auth::guard('user')->user()->id], ['orders.status', '=', 0]])->groupBy('orders.id')->orderBy('orders.created_at', 'DESC');
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
                try {
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
                } catch (\Throwable $th) {
                    logger($order);
                }

            }
            $sum += $inner_sum;
        }
        return $sum;
    }

    /**
     * Cancel user order
     * @param Request $request
     * @return string json response
     */
    public function cancel_order(Request $request, $order_id = null)
    {
        try {
            if (!empty($order_id)) {
                // Fetch order
                $order = Order::find($request->order_id);
                $order->status = -2;

                // Update order-item quantity
                $user_id = Auth::guard('user')->user()->id;
                OrderItem::query()
                    ->where([['user_id', '=', $user_id], ['order_id', '=', $order_id]])
                    ->each(function ($record) {
                        // Update item quantity
                        $this->update_cancel_quantity($record);
                    });

                // Update order status
                $order->save();
            } else {
                $orders = Order::where([['user_id', '=', Auth::guard('user')->user()->id], ['status', '=', 0]]);
                $user_id = Auth::guard('user')->user()->id;

                // Update order-item quantity
                foreach ($orders->get() as $order) {
                    // Update order-item quantity
                    OrderItem::query()
                        ->where([['user_id', '=', $user_id], ['order_id', '=', $order->id]])
                        ->each(function ($record) {
                            // Update item quantity
                            $this->update_cancel_quantity($record);
                        });
                }

                // Update order status
                $orders->update(['status' => -2]);
            }
            return response()->json(['success' => true, 'message' => 'Order cancelled successfully.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
    }

    /**
     * Make necessary changes to the quantity of items when order is cancelled
     *
     * @param Request $request
     * @return Array $validate_data
     */
    public function update_cancel_quantity($record)
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
     * Rate a vendor
     *
     * @param Request $request
     */
    public function rate(Request $request)
    {
        try {
            $user_id = Auth::guard('user')->user()->id;
            $vendor_id = $request->vendor_id;
            $rating = $request->rating;

            // Fetch user rating
            $ratings = Rating::where([['user_id', '=', $user_id], ['vendor_id', '=', $vendor_id]]);

            if ($ratings->count() < 1) {
                $rate = new Rating();
                $rate->user_id = $user_id;
                $rate->vendor_id = $vendor_id;
                $rate->rating = $rating;
                $rate->save();
            }

            return response()->json(['success' => true, 'data' => $this->get_rating($vendor_id, $user_id)], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'message' => "Oops! Something went wrong. Try again!"], 500);
        }
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
