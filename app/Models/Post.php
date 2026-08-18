<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Used to identify Laravel's internal restore update.
     */
    protected static bool $isRestoring = false;

    /**
     * User who created the post.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User who last updated the post.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * User who deleted the post.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Activity history for this post.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    /**
     * UserStamp and activity logging events.
     */
    protected static function booted()
    {
        /*
        |--------------------------------------------------------------------------
        | Creating
        |--------------------------------------------------------------------------
        */

        static::creating(function ($post) {
            if (auth()->check()) {
                $post->created_by = auth()->id();
                $post->updated_by = auth()->id();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Created
        |--------------------------------------------------------------------------
        */

        static::created(function ($post) {
            if (auth()->check()) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    'action' => 'created',
                    'description' => 'Post "' . $post->title . '" was created.',
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Updating
        |--------------------------------------------------------------------------
        */

        static::updating(function ($post) {
            /*
             * Do not update updated_by during Laravel's
             * internal restore operation.
             */
            if (auth()->check() && !static::$isRestoring) {
                $post->updated_by = auth()->id();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Updated
        |--------------------------------------------------------------------------
        */

        static::updated(function ($post) {
            /*
             * Do not create an "updated" activity when
             * Laravel is restoring a soft-deleted post.
             */
            if (auth()->check() && !static::$isRestoring) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    'action' => 'updated',
                    'description' => 'Post "' . $post->title . '" was updated.',
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Deleting
        |--------------------------------------------------------------------------
        */

        static::deleting(function ($post) {
            /*
             * Only set deleted_by for soft deletes.
             */
            if (
                auth()->check() &&
                !$post->isForceDeleting()
            ) {
                $post->deleted_by = auth()->id();

                /*
                 * saveQuietly() prevents the deleted_by update
                 * from creating an additional "updated" activity.
                 */
                $post->saveQuietly();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Deleted
        |--------------------------------------------------------------------------
        */

        static::deleted(function ($post) {
            /*
             * Only log normal soft deletes here.
             */
            if (
                auth()->check() &&
                !$post->isForceDeleting()
            ) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    'action' => 'deleted',
                    'description' => 'Post "' . $post->title . '" was moved to trash.',
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Restoring
        |--------------------------------------------------------------------------
        */

        static::restoring(function ($post) {
            if (auth()->check()) {
                /*
                 * Tell the updating/updated events that this
                 * update is part of a restore operation.
                 */
                static::$isRestoring = true;

                /*
                 * Clear the deleted_by UserStamp.
                 */
                $post->deleted_by = null;
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Restored
        |--------------------------------------------------------------------------
        */

        static::restored(function ($post) {
            if (auth()->check()) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    'action' => 'restored',
                    'description' => 'Post "' . $post->title . '" was restored.',
                ]);
            }

            /*
             * Reset the restore flag.
             */
            static::$isRestoring = false;
        });

        /*
        |--------------------------------------------------------------------------
        | Force Deleted
        |--------------------------------------------------------------------------
        */

        static::forceDeleting(function ($post) {
            if (auth()->check()) {
                /*
                 * Create the activity before the post is
                 * permanently removed from the database.
                 */
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'post_id' => $post->id,
                    'action' => 'force_deleted',
                    'description' => 'Post "' . $post->title . '" was permanently deleted.',
                ]);
            }
        });
    }
}