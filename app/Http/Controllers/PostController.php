<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;

class PostController extends Controller
{
    public function store(Request $request, Website $website)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = $website->posts()->create($request->only('title', 'description'));

        return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }


}
