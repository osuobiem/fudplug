<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications
     * @return json
     */
    public function get(Request $request) {
        // Get owner
        if (!Auth::guard('vendor')->guest()) {
            $owner = $request->user();
        } elseif (!Auth::guard('user')->guest()) {
            $owner = $request->user('user');
        } else {
            return response()->json([
                'success' => false,
                'message' => "You're not logged in"
            ]);
        }

        $notifications = Notification::where('owner_id', $owner->id)->orderBy('created_at', 'desc')->get();

        return view('components.notification', ['notifications' => $notifications]);
    }
}
