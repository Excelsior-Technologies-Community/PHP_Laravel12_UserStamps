<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     */
    public function index()
    {
        $posts = Post::with(['creator', 'updater'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // For demo, login as first user if not authenticated
        if (!Auth::check()) {
            Auth::loginUsingId(1);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Display trashed posts.
     */
    public function trashed()
    {
        $posts = Post::onlyTrashed()->with(['creator', 'deleter'])->get();
        return view('posts.trashed', compact('posts'));
    }

    /**
     * Restore trashed post.
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed')
            ->with('success', 'Post restored successfully!');
    }

    /**
     * Permanently delete post.
     */
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.trashed')
            ->with('success', 'Post permanently deleted!');
    }
}