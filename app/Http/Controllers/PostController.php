<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    // List all posts for the logged-in user
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get(); // show only own posts
        return view('posts.index', compact('posts'));
    }

    // Show form to create new post
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post (already done!)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image' => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Display a specific post
    public function show(Post $post)
    {
        // Optional: ensure only owner can view
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.show', compact('post'));
    }

    // Show edit form
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    // Update a post
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            //'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,

        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
