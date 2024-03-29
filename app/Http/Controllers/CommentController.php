<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notification;
use App\Post;
use App\SocketData;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get comments of a specific post
     * @param int $post_id Post ID
     * @param int $from Previous comment ID.
     * @return view
     */
    function get($post_id, $from = 0)
    {
        $post = $from == 0 ? Post::findOrfail($post_id) : [];
        
        // Check if this is the first fetch
        $comments = $from == 0
            ? Comment::where('post_id', $post_id)->orderBy('created_at', 'desc')->take(11)->get()
            : Comment::where('post_id', $post_id)->where('id', '<', $from)->orderBy('created_at', 'desc')->take(11)->get();

        $comments = $comments->reverse();

        // Check for pagination
        $show_load_more = (count($comments) == 11) ? true : false;
        $fr = (count($comments) == 11) ? $comments[10]->id : 0;

        return view('components.post.comments-inner', [
            'comments' => $comments,
            'slm' => $show_load_more,
            'post_id' => $post_id,
            'from' => $fr,
            'post' => $post
        ]);
    }

    /**
     * Create a comment
     * @param int $post_id Post ID
     * @return json/view
     */
    public function create(Request $request, $post_id)
    {
        // Get validation rules
        $validate = $this->comment_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors()
            ]);
        }

        // Get Post
        $post = Post::findOrFail($post_id);

        // Get commentor
        if (!Auth::guard('vendor')->guest()) {
            $commentor = $request->user();
            $commentor_id = $commentor->id;
            $commentor_type = 'vendor';
        } elseif (!Auth::guard('user')->guest()) {
            $commentor = $request->user('user');
            $commentor_id = $commentor->id;
            $commentor_type = 'user';
        } else {
            return response()->json([
                'success' => false,
                'message' => "You're not logged in"
            ]);
        }

        // Create new comment object
        $comment = new Comment();

        $comment->content = trim($request['comment_content']);
        $comment->commentor_id = $commentor_id;
        $comment->commentor_type = $commentor_type;
        $comment->post_id = $post_id;

        // Increase post comments count
        $post->comments++;

        if (!($commentor->id == $post->vendor_id && $commentor_type == 'vendor')) {
            // Create notification
            $notification = new Notification();
            $notification->notice_type = 'comment';
            $notification->owner_id = $post->vendor_id;
            $notification->post_id = $post->id;
            $notification->status = 0;
            $notification->content = "$commentor_type-$commentor->id//content//commented on your post";
        }

        // Try Save
        try {
            $comment->save();
            $post->save();

            if(!($commentor->id == $post->vendor_id && $commentor_type == 'vendor')) {
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

                // Send Notification
                $data = [
                    "owner_socket" => SocketData::where('username', $post->vendor->username)->first()->socket_id,
                    "content" => view('components.notification-s', ['notification' => $notification])->render(),
                    "content_nmu" => $name . ' ' . $content_data[1] . ': "' . $trunc_content . '"',
                    "type" => "comment",
                    "id" => $post->id
                ];
                (new NotificationController())->send_notification($data, $post->vendor_id, 'vendor');

                // Update nviewed
                $other_details = json_decode($post->vendor->other_details, true);
                if (isset($other_details['nviewed'])) {
                    $other_details['nviewed'] += 1;
                } else {
                    $other_details['nviewed'] = 1;
                }
                $post->vendor->other_details = json_encode($other_details);
                $post->vendor->save();
            }

            // Send Notification
            Http::post(env('NODE_SERVER') . '/send-comments-count', [
                "post_id" => $post->id,
                "comments_count" => $post->comments,
                "area" => $post->vendor->area_id
            ]);

            // Send Notification
            Http::post(env('NODE_SERVER') . '/send-new-comment', [
                "new_comment" => view('components/post/comment-new', ['comment' => $comment])->render(),
                "post_id" => $post->id,
                "commentor_socket" => SocketData::where('username', $commentor->username)->first()->socket_id,
                "area" => $post->vendor->area_id
            ]);

            return view('components/post/comment', ['comment' => $comment]);
        } catch (\Throwable $th) {
            Log::error($th);

            // Delete comments on error
            $comment->forceDelete();

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Create Comment validation Rules
     * @return object
     */
    public function comment_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'comment_content' => 'required|max:1500',
        ]);
    }

    /**
     * Delete Comment
     * @param int $id Comment ID
     * @return json
     */
    public function delete(Request $request, $id)
    {
        // Get Comment
        $comment = Comment::findOrFail($id);

        // Get commentor
        if (!Auth::guard('vendor')->guest()) {
            $commentor = $request->user();
        } elseif (!Auth::guard('user')->guest()) {
            $commentor = $request->user('user');
        } else {
            return response()->json([
                'success' => false,
                'message' => "You're not logged in"
            ]);
        }

        // Get post
        $post = $comment->post;
        // Upadate post comment count
        $post->comments = $post->comments > 0 ? $post->comments - 1 : 0;

        // Try Delete and Save
        try {
            $post->save();
            $comment->forceDelete();

            // Send Notification
            Http::post(env('NODE_SERVER') . '/send-comments-count', [
                "post_id" => $post->id,
                "comments_count" => $post->comments,
                "area" => $post->vendor->area_id
            ]);

            // Send Notification
            Http::post(env('NODE_SERVER') . '/delete-comment', [
                "comment_id" => $comment->id,
                "post_id" => $post->id,
                "commentor_socket" => SocketData::where('username', $commentor->username)->first()->socket_id,
                "area" => $post->vendor->area_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment Deleted'
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
