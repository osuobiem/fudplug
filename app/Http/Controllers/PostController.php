<?php

namespace App\Http\Controllers;

use App\Media;
use App\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $post->content = $request['content'];
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

        // Upload video
        $stored = Storage::put('/public/posts/videos/', $request['video']);

        // Save video thumbnail
        $name = '/public/posts/videos/thumbnails/' . explode('.', basename($stored))[0] . '.png';
        $image_parts = explode(";base64,", $request['thumbnail']);
        $image_base64 = base64_decode($image_parts[1]);

        $th = Storage::put($name, $image_base64);

        if ($stored && $th) {
            $resp = basename($stored);
        }

        return $resp;
    }

    /**
     * Create Post validation Rules
     * @return array
     */
    public function post_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'content' => 'required|max:1500',
            'images.*' => 'image|max:26214400',
            'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);
    }

    /**
     * Get Posts
     * @return view
     */
    public function get(Request $request)
    {
        // Vendor / User?
        if (Auth::guest() && Auth::guard('user')->guest()) {
            $posts = Post::orderBy('created_at', 'desc')->take(15)->get();

            return view('components.posts', ['posts' => $posts]);
        } else {
            // Get logged in vendor or user
            $logged_in = $request->user() ?? $request->user('user');

            // Get Posts according to area
            $posts = Post::whereHas('vendor', function (Builder $query) use ($logged_in) {
                $query->where('area_id', $logged_in->area_id);
            })->orderBy('created_at', 'desc')->take(15)->get();

            return view('components.posts', ['posts' => $posts]);
        }
    }
}
