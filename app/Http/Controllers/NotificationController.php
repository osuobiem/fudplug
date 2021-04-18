<?php

namespace App\Http\Controllers;

use App\Notification;
use App\PushSubscription;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

        if ($from != 0 && count($notifications) == 0) {
            return "";
        }
        // Check for pagination
        $fr = count($notifications) > 0 ? $notifications[count($notifications) - 1]->id : 0;

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
            
            $ncount = grapheme_strlen($notification->post->content);
            $trunc_content = $ncount > 40 ? grapheme_substr($notification->post->content, 0, 40).'...' : $notification->post->content;
            $notification->content = '<strong>' . $name . '</strong> ' . $content_data[1] . ': "' . $trunc_content . '"';
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
    public function mark_as_read(Request $request, $id = null)
    {
        // Mark single notification
        if ($id) {
            $notification = Notification::findOrFail($id);
            $notification->status = 1;

            // Try Save
            try {
                $notification->save();

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

                $ncount = grapheme_strlen($notification->post->content);
                $trunc_content = $ncount > 40 ? grapheme_substr($notification->post->content, 0, 40).'...' : $notification->post->content;
                $notification->content = '<strong>' . $name . '</strong> ' . $content_data[1] . ': "' . $trunc_content . '"';
                $notification->photo = Storage::url($initiator_data[0] . '/profile/' . $initiator->profile_image);

                return view('components.notification-i', [
                    'notification' => $notification
                ]);
            } catch (\Throwable $th) {
                Log::error($th);

                return response()->json([
                    'success' => false,
                    'message' => 'Internal Server Error'
                ], 500);
            }
        }
        // Mark all
        else {
            // Get owner
            if (!Auth::guard('vendor')->guest()) {
                $owner = $request->user();
            } elseif (!Auth::guard('user')->guest()) {
                $owner = $request->user('user');
            }

            // Try Update
            try {
                Notification::where('owner_id', $owner->id)->update(['status' => 1]);

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

    /**
     * Clear nviewed (Notifications count viewed)
     * @return json
     */
    public function clear_nviewed(Request $request)
    {
        // Get user/vendor
        if (!Auth::guard('vendor')->guest()) {
            $owner = $request->user();
        } elseif (!Auth::guard('user')->guest()) {
            $owner = $request->user('user');
        }

        $other_details = json_decode($owner->other_details, true);
        if (isset($other_details['nviewed'])) {
            $other_details['nviewed'] = 0;
        } else {
            $other_details['nviewed'] = 0;
        }
        $owner->other_details = json_encode($other_details);

        // Try Save
        try {
            $owner->save();

            return response()->json([
                'success' => true,
                'message' => 'NViewed Cleared'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Register web push subscription
     * @return null
     */
    public function register_wps(Request $request) {
        if (!Auth::guard('vendor')->guest()) {
            $subscriber = $request->user();
            $type = 'vendor';
        } elseif (!Auth::guard('user')->guest()) {
            $subscriber = $request->user('user');
            $type = 'user';
        }

        if(empty($request->subscription)) {
            Log::error("Web Push Subscription not found!");
        }

        $existing_push = PushSubscription::where('subscriber_id', $subscriber->id)->where('subscriber_type', $type)->first();
        !empty($existing_push) ? $existing_push->delete() : null;

        $push = new PushSubscription();
        $push->subscriber_id = $subscriber->id;
        $push->subscriber_type = $type;
        $push->subscription = serialize($request->subscription);
        
        // Try Save
        try {
            $push->save();
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Send Notification
     * @param array $data Notification data 
     * @param int $subscriber_id Subscriber id
     * @param string $subscriber_type Subscriber type (user or vendor)
     * @param string $payload Notification payload
     */
    public function send_notification($data, $subscriber_id, $subscriber_type) {
        $subscription = PushSubscription::where('subscriber_id', $subscriber_id)->where('subscriber_type', $subscriber_type)->first();
        
        // Send socket notification
        Http::post(env('NODE_SERVER') . '/notify', $data);

        $icon = url('assets/img/fav.png');
        $url = url('?type='.$data['type'].'&id='.$data['id']);
        
        if(!empty($subscription)) {
            // Send push notification
            $response = Http::post(env('NODE_SERVER') . '/sw/send-notification', [
                'subscription'  => unserialize($subscription->subscription),
                'payload'       => ['content' => $data['content_nmu'], 'url' => $url, 'icon' => $icon],
                'ttl'           => 86400,
                'icon'          => url('assets/img/fav.png')
            ]);
            $response->throw();
        }
    }
}
