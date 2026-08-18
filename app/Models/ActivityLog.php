<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'action',
        'description',
    ];

    /**
     * User who performed the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post associated with the activity.
     */
    public function post()
    {
        return $this->belongsTo(Post::class)->withTrashed();
    }
}