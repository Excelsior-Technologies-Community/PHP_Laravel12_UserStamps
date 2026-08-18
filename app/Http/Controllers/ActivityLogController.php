<?php

namespace App\Http\Controllers;

use App\Models\Post;

class ActivityLogController extends Controller
{
    /**
     * Display activity history for a post.
     *
     * Includes soft-deleted posts so activity
     * can also be viewed from the Trashed Posts page.
     */
    public function postActivity($postId)
    {
        /*
         * withTrashed() allows us to find both
         * normal and soft-deleted posts.
         */
        $post = Post::withTrashed()->findOrFail($postId);

        /*
         * Load activity history with the
         * user who performed each action.
         */
        $activities = $post->activityLogs()
            ->with('user')
            ->latest()
            ->get();

        return view(
            'activity.index',
            compact('post', 'activities')
        );
    }
}