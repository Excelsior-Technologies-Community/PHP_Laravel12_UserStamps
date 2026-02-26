<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            // Check if user exists before creating
            $user = User::where('email', $userData['email'])->first();
            
            if (!$user) {
                User::create($userData);
                $this->command->info("User {$userData['email']} created successfully!");
            } else {
                $this->command->info("User {$userData['email']} already exists, skipping...");
            }
        }
        
        $this->command->info('Users table seeding completed!');
    }
}