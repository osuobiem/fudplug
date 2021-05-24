<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Item;
use App\State;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * Feed/Home Page
     */
    public function feed()
    {
        $states = State::orderBy('name')->get();
        $tag_items = [];

        if(!Auth::guard('vendor')->guest()) {
            $menu = Auth::guard('vendor')->user()->menu;
            $tag_items = [];

            if($menu) {
                foreach(json_decode($menu->items)->item as $item_id) {
                    $tag_items[] = Item::findOrFail($item_id);
                }
            }
        }

        return view('feed', ['states' => $states, 'tag_items' => $tag_items]);
    }

    /**
     * Verify Page
     */
    public function verify_page()
    {
        if (session()->has('verify_email')) {
            $user_email = session('verify_email');
            return view('auth.verify', compact('user_email'));
        } else {
            return redirect()->route('.');
        }
    }

    /**
     * Expired Link Page
     */
    public function expired_link_page()
    {
        if (session()->has('verify_email')) {
            $user_email = session('verify_email');
            return view('auth.expired-link', compact('user_email'));
        } else if (session()->has('forgot_password')) {
            // Delete the forgot_password session variable after successful verification
            session()->forget('forgot_password');

            return view('auth.passwords.expired-link');
        } else {
            return redirect()->route('.');
        }
    }

    /**
     * Display Vendor Profile Page
     *
     * @param $username
     */
    public function profile($username)
    {
        $tag_items = [];

        // Check Login
        if (!Auth::guard('vendor')->guest()) {
            $vendor_controller = new VendorController();
            $data = $vendor_controller->profile($username);

            $tag_items = [];
            $data['data']['tag_items'] = $tag_items;

            // Display pages appropriately if user data is found or not
            if ($data['status'] == true) {
                
                // Get vendor menu
                $menu = Auth::guard('vendor')->user()->menu;
                if($menu) {
                    foreach(json_decode($menu->items)->item as $item_id) {
                        $tag_items[] = Item::findOrFail($item_id);
                    }
                    $data['data']['tag_items'] = $tag_items;
                }

                return view('vendor.profile', $data['data']);
            } else {
                // Another vendor
                $user_controller = new UserController();
                $data = $user_controller->vendor_profile($username);

                if ($data['status'] == true) {
                    return view('user.vendor-profile', $data['data']);
                } else {
                    abort(404);
                }
            }
        } else if (!Auth::guard('user')->guest()) {
            $user_controller = new UserController();
            $data = $user_controller->vendor_profile($username);

            if ($data['status'] == true) {
                return view('user.vendor-profile', $data['data']);
            } else {
                abort(404);
            }
        } else {
            return redirect()->route('.');
        }
    }
}
