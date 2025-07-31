<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                return $this->addImageUrl($post);
            });

        return response()->json([
            'message' => 'Posts retrieved successfully',
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $this->addImageUrl($post),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access',
            ], 403);
        }

        return response()->json([
            'message' => 'Post retrieved successfully',
            'data' => $this->addImageUrl($post),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access',
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                $this->deleteImageFile($post->image);
            }
            $data['image'] = $request->file('image')->store('post_images', 'public');
        }

        // Handle image removal if requested
        if ($request->has('remove_image') && $request->remove_image) {
            if ($post->image) {
                $this->deleteImageFile($post->image);
            }
            $data['image'] = null;
        }

        $post->update($data);
        $post->refresh(); // Refresh to get updated data

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $this->addImageUrl($post),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if the post belongs to the authenticated user
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access',
            ], 403);
        }

        // Delete image file if exists
        if ($post->image) {
            $this->deleteImageFile($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }

    /**
     * Add image URL to post data
     */
    private function addImageUrl($post)
    {
        $postData = $post->toArray();
        
        if ($post->image) {
            $postData['image_url'] = asset('storage/' . $post->image);
        } else {
            $postData['image_url'] = null;
        }
        
        return $postData;
    }

    /**
     * Delete image file from storage
     */
    private function deleteImageFile($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
} 