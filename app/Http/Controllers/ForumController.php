<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;

class ForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::all();
        return response()->json($posts);
    }

    public function postMessage(Request $request)
    {
        $post = new ForumPost();
        $post->user_id = Auth::id();
        $post->content = $request->input('content');
        $post->save();

        return response()->json(['message' => 'Post created', 'data' => $post]);
    }
}
