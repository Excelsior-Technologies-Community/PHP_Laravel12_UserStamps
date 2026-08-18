<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    /**
     * Display all posts with search, filters, sorting and pagination.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Filters
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'search' => 'nullable|string|max:255',

            'created_by' => 'nullable|integer|exists:users,id',

            'updated_by' => 'nullable|integer|exists:users,id',

            'sort' => 'nullable|in:latest,oldest,title_asc,title_desc',

            /*
             * IMPORTANT:
             * These values must match the Blade dropdown.
             */
            'per_page' => 'nullable|integer|in:5,6,10,25,50',

            'date_from' => 'nullable|date',

            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $query = Post::query()
            ->with([
                'creator',
                'updater',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {

                /*
                 * Search ID if numeric.
                 */
                if (is_numeric($search)) {

                    $q->orWhere(
                        'id',
                        (int) $search
                    );
                }

                /*
                 * Search title.
                 */
                $q->orWhere(
                    'title',
                    'like',
                    '%' . $search . '%'
                );

                /*
                 * Search content.
                 */
                $q->orWhere(
                    'content',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Created By Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('created_by')) {

            $query->where(
                'created_by',
                $request->input('created_by')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Updated By Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('updated_by')) {

            $query->where(
                'updated_by',
                $request->input('updated_by')
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
                $request->input('date_from')
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
                $request->input('date_to')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->input('sort', 'latest')) {

            case 'oldest':

                $query->orderBy(
                    'created_at',
                    'asc'
                );

                break;


            case 'title_asc':

                $query->orderBy(
                    'title',
                    'asc'
                );

                break;


            case 'title_desc':

                $query->orderBy(
                    'title',
                    'desc'
                );

                break;


            case 'latest':

            default:

                $query->orderBy(
                    'created_at',
                    'desc'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | Per Page
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->input(
            'per_page',
            5
        );


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->paginate($perPage)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Users For Filters
        |--------------------------------------------------------------------------
        */

        $users = User::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'posts.index',
            compact(
                'posts',
                'users'
            )
        );
    }


    /**
     * Show create post page.
     */
    public function create()
    {
        return view('posts.create');
    }


    /**
     * Store a new post.
     *
     * UserStamp will automatically populate
     * created_by and updated_by when configured.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => 'required|string|max:255',

            'content' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Post
        |--------------------------------------------------------------------------
        */

        Post::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post created successfully.'
            );
    }


    /**
     * Display one post.
     */
    public function show(Post $post)
    {
        $post->load([
            'creator',
            'updater',
            'activityLogs.user',
        ]);

        return view(
            'posts.show',
            compact('post')
        );
    }


    /**
     * Show edit page.
     */
    public function edit(Post $post)
    {
        return view(
            'posts.edit',
            compact('post')
        );
    }


    /**
     * Update post.
     *
     * UserStamp automatically updates updated_by.
     */
    public function update(
        Request $request,
        Post $post
    ) {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'title' => 'required|string|max:255',

            'content' => 'required|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $post->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'posts.index'
            )
            ->with(
                'success',
                'Post updated successfully.'
            );
    }


    /**
     * Move post to trash.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post moved to trash successfully.'
            );
    }


    /**
     * Display trashed posts.
     */
    public function trashed(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'search' => 'nullable|string|max:255',

            'per_page' => 'nullable|integer|in:5,10,25,50',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query = Post::onlyTrashed()
            ->with([
                'creator',
                'updater',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                if (is_numeric($search)) {

                    $q->orWhere(
                        'id',
                        (int) $search
                    );
                }

                $q->orWhere(
                    'title',
                    'like',
                    '%' . $search . '%'
                );

                $q->orWhere(
                    'content',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->input(
            'per_page',
            10
        );


        $posts = $query
            ->latest('deleted_at')
            ->paginate($perPage)
            ->withQueryString();


        return view(
            'posts.trashed',
            compact('posts')
        );
    }


    /**
     * Restore a trashed post.
     */
    public function restore($id)
    {
        $post = Post::onlyTrashed()
            ->findOrFail($id);

        $post->restore();

        return redirect()
            ->route('posts.trashed')
            ->with(
                'success',
                'Post restored successfully.'
            );
    }


    /**
     * Permanently delete a post.
     */
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()
            ->findOrFail($id);

        $post->forceDelete();

        return redirect()
            ->route('posts.trashed')
            ->with(
                'success',
                'Post permanently deleted.'
            );
    }


    /**
     * Export filtered posts as CSV.
     */
    public function export(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Filters
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'search' => 'nullable|string|max:255',

            'created_by' => 'nullable|integer|exists:users,id',

            'updated_by' => 'nullable|integer|exists:users,id',

            'sort' => 'nullable|in:latest,oldest,title_asc,title_desc',

            'date_from' => 'nullable|date',

            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Query
        |--------------------------------------------------------------------------
        */

        $query = Post::query()
            ->with([
                'creator',
                'updater',
            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                if (is_numeric($search)) {

                    $q->orWhere(
                        'id',
                        (int) $search
                    );
                }

                $q->orWhere(
                    'title',
                    'like',
                    '%' . $search . '%'
                );

                $q->orWhere(
                    'content',
                    'like',
                    '%' . $search . '%'
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Created By
        |--------------------------------------------------------------------------
        */

        if ($request->filled('created_by')) {

            $query->where(
                'created_by',
                $request->input('created_by')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Updated By
        |--------------------------------------------------------------------------
        */

        if ($request->filled('updated_by')) {

            $query->where(
                'updated_by',
                $request->input('updated_by')
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
                $request->input('date_from')
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
                $request->input('date_to')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->input('sort', 'latest')) {

            case 'oldest':

                $query->orderBy(
                    'created_at',
                    'asc'
                );

                break;


            case 'title_asc':

                $query->orderBy(
                    'title',
                    'asc'
                );

                break;


            case 'title_desc':

                $query->orderBy(
                    'title',
                    'desc'
                );

                break;


            default:

                $query->orderBy(
                    'created_at',
                    'desc'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Records
        |--------------------------------------------------------------------------
        */

        $posts = $query->get();


        /*
        |--------------------------------------------------------------------------
        | CSV Headers
        |--------------------------------------------------------------------------
        */

        $headers = [
            'Content-Type' =>
            'text/csv; charset=UTF-8',

            'Content-Disposition' =>
            'attachment; filename="posts.csv"',
        ];


        /*
        |--------------------------------------------------------------------------
        | CSV Response
        |--------------------------------------------------------------------------
        */

        $callback = function () use ($posts) {

            $file = fopen(
                'php://output',
                'w'
            );


            /*
             * UTF-8 BOM
             */
            fprintf(
                $file,
                chr(0xEF) .
                    chr(0xBB) .
                    chr(0xBF)
            );


            /*
             * Header Row
             */
            fputcsv(
                $file,
                [
                    'ID',
                    'Title',
                    'Content',
                    'Created By',
                    'Updated By',
                    'Created At',
                    'Updated At',
                ]
            );


            /*
             * Data
             */
            foreach ($posts as $post) {

                fputcsv(
                    $file,
                    [
                        $post->id,

                        $post->title,

                        $post->content,

                        optional(
                            $post->creator
                        )->name ?? 'Unknown',

                        optional(
                            $post->updater
                        )->name ?? 'Unknown',

                        optional(
                            $post->created_at
                        )->format(
                            'Y-m-d H:i:s'
                        ),

                        optional(
                            $post->updated_at
                        )->format(
                            'Y-m-d H:i:s'
                        ),
                    ]
                );
            }


            fclose($file);
        };


        return Response::stream(
            $callback,
            200,
            $headers
        );
    }
}
