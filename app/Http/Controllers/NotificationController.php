<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        
        foreach($notifications as $notification) {
            // Build notification content
            $content_data = explode('//content//', $notification->content);
            
            $initiator_data = explode('-', $content_data[0]);

            if($initiator_data[0] == 'user') {
                $initiator = User::find($initiator_data[1]);
                $name = strlen($initiator->name) > 0 ? $initiator->name : '@'.$initiator->username;
            }
            else {
                $initiator = Vendor::find($initiator_data[1]);
                $name = $initiator->business_name;
            }

            $notification->content = '<strong>'.$name.'</strong> '.$content_data[1];
            $notification->photo = Storage::url($initiator_data[0].'/profile/'.$initiator->profile_image);
        }

        return view('components.notification', ['notifications' => $notifications]);
    }
}
