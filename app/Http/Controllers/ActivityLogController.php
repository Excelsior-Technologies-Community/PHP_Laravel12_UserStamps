<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Activity history for one post.
     */
    public function postActivity($postId)
    {
        $post = Post::withTrashed()
            ->findOrFail($postId);

        $activities = $post->activityLogs()
            ->with('user')
            ->oldest()
            ->get();

        return view(
            'activity.index',
            compact('post', 'activities')
        );
    }

    /**
     * Global activity history.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'action' => 'nullable|in:created,updated,deleted,restored,force_deleted',
            'user_id' => 'nullable|integer|exists:users,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'per_page' => 'nullable|integer|in:5,6,10,25,50,100',
        ]);

        $query = ActivityLog::with([
            'user',
            'post',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhereHas('post', function ($postQuery) use ($search) {
                        $postQuery->where(
                            'title',
                            'like',
                            '%' . $search . '%'
                        );
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Action
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {
            $query->where(
                'action',
                $request->action
            );
        }

        /*
        |--------------------------------------------------------------------------
        | User
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {
            $query->where(
                'user_id',
                $request->user_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        $perPage = (int) $request->input(
            'per_page',
            10
        );

        $activities = $query
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        return view(
            'activity.history',
            compact(
                'activities',
                'users'
            )
        );
    }
}
