<?php

namespace App\Http\Controllers;

use App\AreaVendor;
use App\Like;
use App\Media;
use App\Notification;
use App\Post;
use App\PostTag;
use App\SocketData;
use App\User;
use App\Vendor;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create Post
     * @return json
     */
    public function create(Request $request)
    {
        // Get validation rules
        $validate = $this->post_rules($request);

        // Run validation
        if ($validate->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validate->errors()
            ]);
        }

        // Post Data
        $post = new Post();
        $post->content = trim($request['content']);
        $post->likes = 0;
        $post->comments = 0;
        $post->vendor_id = $request->user()->id;

        $photos = [];
        $video = false;

        // Check if there's any image in the request
        if ($request['images']) {
            $upload = $this->upload_photos($request);

            // Check upload status
            if (!$upload['success']) {
                return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
            }

            $photos = $upload['photos'];
        } else {
            // Check if there's video
            if ($request['video']) {
                $upload = $this->upload_video($request);

                // Check upload status
                if (!$upload) {
                    return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
                }

                $video = $upload;
            }
        }

        // Try Post Save
        try {
            // Save Post
            $post->save();

            // Save Post Photos
            if ($request['images']) {
                $data = [];
                foreach ($photos as $photo) {
                    array_push($data, [
                        'name' => $photo,
                        'type' => 'image',
                        'post_id' => $post->id
                    ]);
                }
                Media::insert($data);
            } else {
                // Save video
                if ($request['video'] && $video) {
                    $media = new Media();
                    $media->name = $video;
                    $media->post_id = $post->id;
                    $media->type = 'video';

                    $media->save();
                }
            }

            // Check for post tags
            if (!empty($request['tags'])) {
                $tags = [];
                foreach ($request['tags'] as $tag) {
                    $tags[] = [
                        'item_id' => $tag,
                        'post_id' => $post->id
                    ];
                }

                PostTag::insert($tags);
            }

            // Send Notification
            Http::post(env('NODE_SERVER') . '/send-new-post', [
                "post_markup" => view('components.post.single-post', ['post' => $post])->render(),
                "area" => $post->vendor->area_id
            ]);

            return response()->json([
                'success' => true,
                'messgae' => 'Post Sent Successfully'
            ]);
        } catch (\Throwable $th) {
            // Delete uploaded photos
            if ($request['images'] && $photos) {
                foreach ($photos as $photo) {
                    Storage::delete('/public/posts/photos' . $photo);
                }
            }

            // Delete Video
            if ($request['video'] && $video) {
                Storage::delete('/public/posts/videos' . $video);

                $th_name = explode('.', $video)[0] . '.png';
                Storage::delete('/public/posts/videos/thumbnails/' . $th_name);
            }

            // Delete Post
            $post->delete();

            Log::error($th);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Upload post photos
     * @return array
     */
    public function upload_photos(Request $request)
    {
        $resp = [
            'success' => true,
            'photos' => []
        ];

        // Upload photos
        foreach ($request['images'] as $photo) {
            $stored = Storage::put('/public/posts/photos/', $photo);

            if ($stored) {
                array_push($resp['photos'], basename($stored));
            } else {
                $resp['success'] = false;
                break;
            }
        }

        // Check for upload errors
        if ($resp['success']) {
            return $resp;
        } else {
            // Delete uploaded photos
            if (count($resp['photos'])) {
                foreach ($resp['photos'] as $photo) {
                    Storage::delete('/public/posts/photos/' . $photo);
                }
            }

            return $resp;
        }
    }

    /**
     * Upload post video
     * @return array
     */
    public function upload_video(Request $request)
    {
        $resp = false;

        $video = Cloudinary::uploadVideo($request->file('video')->getRealPath());
        $video_url = $video->getSecurePath();
        $url_parts = explode('/', $video_url);
        $url_parts[8] = $url_parts[7];
        $url_parts[7] = $url_parts[6];
        $url_parts[6] = 'q_45';

        // Upload video
        copy(implode('/', $url_parts), 'storage/posts/videos/' . $url_parts[8]);

        // Save video thumbnail
        $name = '/public/posts/videos/thumbnails/' . explode('.', $url_parts[8])[0] . '.png';
        $image_parts = explode(";base64,", $request['thumbnail']);
        $image_base64 = base64_decode($image_parts[1]);

        $th = Storage::put($name, $image_base64);

        if ($video_url && $th) {
            $resp = $url_parts[8];
        }

        return $resp;
    }

    /**
     * Create Post validation Rules
     * @return object
     */
    public function post_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'content' => 'required|max:1500',
            'images.*' => 'image|max:614400',
            'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm|max:262144000',
        ]);
    }

    /**
     * Get Posts
     * @return view
     */
    public function get(Request $request)
    {
        // Vendor / User?
        if (Auth::guard('vendor')->guest() && Auth::guard('user')->guest()) {
            $posts = Post::orderBy('created_at', 'desc')->take(15)->get();

            return view('components.post.index', ['posts' => $posts]);
        } else {
            // Get logged in vendor or user
            $logged_in = $request->user() ?? $request->user('user');
            $type = $request->user() ? 'vendor' : 'user';

            $area = $type == 'vendor' ? count($logged_in->areas) > 0 : $logged_in->area;
            $posts = [];

            if($area) {
                // Get Posts according to area
                if($type == 'vendor') {
                    $areas = $logged_in->areas->pluck('id');
                    $vendor_ids = AreaVendor::whereIn('area_id', $areas)->groupBy('vendor_id')->pluck('vendor_id');
                    $posts = Post::whereIn('vendor_id', $vendor_ids)->orderBy('created_at')->orderBy('created_at', 'desc')->take(15)->get();
                }
                else {
                    $vendor_ids = $logged_in->area->vendors->pluck('id');
                    $posts = Post::whereIn('vendor_id', $vendor_ids)->orderBy('created_at')->orderBy('created_at', 'desc')->take(15)->get();
                }
            }

            return view('components.post.index', ['posts' => $posts]);
        }
    }

    /**
     * Like Post
     * @param int $post_id Post ID
     * @return json
     */
    public function like(Request $request, $post_id)
    {
        // Check Login
        if (Auth::guard('vendor')->guest() && Auth::guard('user')->guest()) {
            return response()->json([
                "success" => false,
                "message" => "You're not logged in"
            ]);
        }

        $post = Post::findOrFail($post_id);

        // User or Vendor?
        $liker = Auth::guard('vendor')->guest() ? $request->user('user') : $request->user();
        $liker_type = Auth::guard('vendor')->guest() ? 'user' : 'vendor';

        // Check for duplication
        $liked_before = Like::where('post_id', $post->id)->where('liker_type', $liker_type)->where('liker_id', $liker->id)->count();
        if ($liked_before > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Duplicate like not allowed'
            ]);
        }

        // Create New Like
        $like = new Like();
        $like->post_id = $post_id;
        $like->liker_id = $liker->id;
        $like->liker_type = $liker_type;

        // Update post like count
        $post->likes += 1;

        if (!($liker->id == $post->vendor_id && $liker_type == 'vendor')) {
            // Create notification
            $notification = new Notification();
            $notification->notice_type = 'like';
            $notification->owner_id = $post->vendor_id;
            $notification->post_id = $post->id;
            $notification->status = 0;
            $notification->content = "$liker_type-$liker->id//content//likes your post";
        }

        try {
            $like->save();
            $post->save();

            if (!($liker->id == $post->vendor_id && $liker_type == 'vendor')) {
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
                $trunc_content = $ncount > 40 ? grapheme_substr($notification->post->content, 0, 40) . '...' : $notification->post->content;
                $notification->content = '<strong>' . $name . '</strong> ' . $content_data[1] . ': "' . $trunc_content . '"';
                $notification->photo = Storage::url($initiator_data[0] . '/profile/' . $initiator->profile_image);

                // Send Notification
                $data = [
                    "owner_socket" => SocketData::where('username', $post->vendor->username)->first()->socket_id,
                    "content" => view('components.notification-s', ['notification' => $notification])->render(),
                    "content_nmu" => $name . ' ' . $content_data[1] . ': "' . $notification->post->content,
                    "type" => "like",
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
            Http::post(env('NODE_SERVER') . '/send-likes-count', [
                "post_id" => $post->id,
                "likes_count" => $post->likes,
                "area" => $post->vendor->area_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Like Successful'
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
     * Unlike Post
     * @param int $post_id Post ID
     * @return json
     */
    public function unlike(Request $request, $post_id)
    {
        // Check Login
        if (Auth::guard('vendor')->guest() && Auth::guard('user')->guest()) {
            return response()->json([
                "success" => false,
                "message" => "You're not logged in"
            ]);
        }

        $post = Post::findOrFail($post_id);

        // User or Vendor?
        $liker = Auth::guard('vendor')->guest() ? $request->user('user') : $request->user();
        $liker_type = Auth::guard('vendor')->guest() ? 'user' : 'vendor';

        $like = Like::where('post_id', $post->id)->where('liker_type', $liker_type)->where('liker_id', $liker->id)->first();

        // Check if post is liked
        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => "You can't unlike this post"
            ]);
        }

        $post->likes -= 1;
        try {
            $like->forceDelete();
            $post->save();

            // Send Notification
            Http::post(env('NODE_SERVER') . '/send-likes-count', [
                "post_id" => $post->id,
                "likes_count" => $post->likes,
                "area" => $post->vendor->area_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Unlike Successful'
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
     * Delete Post
     * @param int $post_id Post ID
     * @return json
     */
    public function delete(Request $request, $post_id)
    {
        // Check Login
        if (Auth::guard('vendor')->guest()) {
            return response()->json([
                "success" => false,
                "message" => "You're not logged in"
            ]);
        }

        $post = Post::findOrFail($post_id);

        $vendor = $request->user();

        // Check post owner
        if ($post->vendor_id != $vendor->id) {
            return response()->json([
                "success" => false,
                "message" => "You cannot delete this post"
            ]);
        }

        // Get post media
        $media = $post->media;

        if (!empty($media)) {
            foreach ($media as $m) {
                if ($m->type == 'image') {
                    Storage::delete('/public/posts/photos/' . $m->name);
                } else {
                    Storage::delete('/public/posts/videos/' . $m->name);
                    Storage::delete('/public/posts/videos/thumbnails/' . explode('.', $m->name)[0] . '.png');
                }
            }
        }

        try {
            $post->notification()->forceDelete();
            $post->forceDelete();

            // Send Notification
            Http::post(env('NODE_SERVER') . '/delete-post', [
                "post_id" => $post->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted'
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
