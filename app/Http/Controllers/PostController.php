<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $post = Auth::user()->posts()->orderBy('created_at', 'desc')->get();

        return view('posts.index', compact('post'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
