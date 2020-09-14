<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create Post
     * @return json
     */
    public function post(Request $request)
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
        dd($_FILES);

        // Post Data
        $post = new Post();
        $post->content = $request['content'];
        $post->likes = 0;
        $post->comments = 0;
        $post->vendor_id = $request->user()->id;

        // Check if there's any image in the request
        if ($request['images']) {
            dd($request['images']);
            $upload = $this->upload_photo($request);

            // Check upload status
            if (!$upload['success']) {
                return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
            }
        }
    }

    /**
     * Create Post validation Rules
     * @return array
     */
    public function post_rules(Request $request)
    {
        // Make and return validation rules
        return Validator::make($request->all(), [
            'content' => 'required|max:300',
            'images.*' => 'image|max:26214400',
            'video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
        ]);
    }
}
