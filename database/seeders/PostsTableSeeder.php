<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Check if there are any users
        $userCount = User::count();
        
        if ($userCount === 0) {
            $this->command->error('No users found. Please run UsersTableSeeder first!');
            return;
        }
        
        // Get admin user or first user
        $user = User::where('email', 'admin@example.com')->first();
        
        if (!$user) {
            $user = User::first();
            $this->command->info('Admin user not found, using first available user: ' . $user->name);
        }
        
        // Login as the user
        Auth::loginUsingId($user->id);
        
        $posts = [
            [
                'title' => 'Welcome to Laravel UserStamps',
                'content' => 'This post demonstrates how UserStamps automatically tracks the user who created it. The created_by field is set to the ID of the currently authenticated user.'
            ],
            [
                'title' => 'Understanding UserStamps',
                'content' => 'UserStamps is a Laravel package that automatically adds created_by, updated_by, and deleted_by fields to your models, similar to timestamps.'
            ],
            [
                'title' => 'Benefits of User Tracking',
                'content' => 'Tracking which user created, updated, or deleted records is crucial for auditing, security, and understanding data changes in your application.'
            ]
        ];

        $postCount = 0;
        foreach ($posts as $postData) {
            // Check if post already exists (optional)
            $existingPost = Post::where('title', $postData['title'])->first();
            
            if (!$existingPost) {
                Post::create($postData);
                $postCount++;
                $this->command->info("Post '{$postData['title']}' created successfully!");
            } else {
                $this->command->info("Post '{$postData['title']}' already exists, skipping...");
            }
        }
        
        Auth::logout();
        
        $this->command->info("{$postCount} new posts created successfully!");
        $this->command->info('Posts table seeding completed!');
    }
}