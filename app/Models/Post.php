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
        'deleted_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Boot method to handle userstamps manually if package fails
    protected static function booted()
    {
        static::creating(function ($post) {
            if (auth()->check()) {
                $post->created_by = auth()->id();
                $post->updated_by = auth()->id();
            }
        });

        static::updating(function ($post) {
            if (auth()->check()) {
                $post->updated_by = auth()->id();
            }
        });

        static::deleting(function ($post) {
            if (auth()->check() && !$post->isForceDeleting()) {
                $post->deleted_by = auth()->id();
                $post->save();
            }
        });
    }
}