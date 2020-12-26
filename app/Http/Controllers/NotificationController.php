<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    /**
     * Get notifications
     * @param int $from Pagination Id
     * 
     * @return json
     */
    public function get(Request $request, $from = 0)
    {
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

        // Check if this is the first fetch
        $notifications = $from == 0
            ? Notification::where('owner_id', $owner->id)->orderBy('created_at', 'desc')->take(10)->get()
            : Notification::where('owner_id', $owner->id)->where('id', '<', $from)->orderBy('created_at', 'desc')->take(10)->get();
        
        if($from != 0 && count($notifications) == 0) {
            return "";
        }
        // Check for pagination
        $fr = count($notifications) > 0 ? $notifications[count($notifications)-1]->id : 0;

        foreach ($notifications as $notification) {
            // Build notification content
            $content_data = explode('//content//', $notification->content);

            $initiator_data = explode('-', $content_data[0]);

            if ($initiator_data[0] == 'user') {
                $initiator = User::find($initiator_data[1]);
                $name = strlen($initiator->name) > 0 ? $initiator->name : '@' . $initiator->username;
            } else {
                $initiator = Vendor::find($initiator_data[1]);
                $name = $initiator->business_name;
            }

            $notification->content = '<strong>' . $name . '</strong> ' . $content_data[1] . ': "' . substr($notification->post->content, 0, 40) . '..."';
            $notification->photo = Storage::url($initiator_data[0] . '/profile/' . $initiator->profile_image);
        }

        return view('components.notification', [
            'notifications' => $notifications,
            'from' => $fr
        ]);
    }

    /**
     * Mark as read
     * @param int $id Notificaton Id
     * @return json
     */
    public function mark_as_read($id = null) {
        if($id) {
            $notification = Notification::findOrFail($id);
            $notification->status = 1;

            // Try Save
            try {
                $notification->save();

                return response()->json([
                    'success' => true,
                    'message' => 'MAR Successful'
                ]);
            } catch (\Throwable $th) {
                Log::error($th);

                return response()->json([
                    'success' => false,
                    'message' => 'Internal Server Error'
                ], 500);
            }
        }
    }
}
