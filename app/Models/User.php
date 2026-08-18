<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Posts created by this user.
     */
    public function createdPosts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }

    /**
     * Posts updated by this user.
     */
    public function updatedPosts()
    {
        return $this->hasMany(Post::class, 'updated_by');
    }

    /**
     * Posts deleted by this user.
     */
    public function deletedPosts()
    {
        return $this->hasMany(Post::class, 'deleted_by');
    }

    /**
     * Activity logs performed by this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}