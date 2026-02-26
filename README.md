# PHP_Laravel12_UserStamps
# Laravel UserStamps - Complete Project Guide

## Project Overview

This project demonstrates how to implement **UserStamps** in Laravel to automatically track which user created, updated, and deleted records in your application.

UserStamps are similar to Laravel's built-in timestamps but track **user IDs instead of timestamps**.

---

## Features

* Automatic tracking of `created_by`, `updated_by`, and `deleted_by`
* Soft deletes with user tracking
* Clean Bootstrap UI
* Full CRUD operations for posts
* Trashed posts management (restore & force delete)
* Authentication simulation for demo
* Database seeders with sample data

---

## Prerequisites

* PHP >= 8.1
* Composer
* MySQL >= 5.7
* Laravel 10.x
* Apache/Nginx or Laravel Artisan server

---

# Step-by-Step Installation Guide

## Step 1: Create New Laravel Project

```bash
composer create-project laravel/laravel laravel-userstamps-demo
cd laravel-userstamps-demo
```

---

## Step 2: Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=userstamps_demo
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create database manually:

```sql
CREATE DATABASE userstamps_demo;
```

---

## Step 3: Create Migrations

### Users Table Migration

```bash
php artisan make:migration create_users_table
```

Add:

* Soft deletes
* `created_by`
* `updated_by`
* `deleted_by`
* Self-referencing foreign keys

---

### Posts Table Migration

```bash
php artisan make:migration create_posts_table
```

Add:

* Soft deletes
* `created_by`
* `updated_by`
* `deleted_by`
* Foreign keys referencing users table

---

## Step 4: Create Models

### User Model

* Use `SoftDeletes`
* Add relationships:

  * `creator()`
  * `updater()`
  * `deleter()`
* Add model events inside `booted()`:

  * Set `created_by` on creating
  * Set `updated_by` on updating
  * Set `deleted_by` on soft deleting

---

### Post Model

* Use `SoftDeletes`
* Add relationships to `User`
* Implement model events:

  * `creating`
  * `updating`
  * `deleting`

---

## Step 5: Run Migrations

```bash
php artisan migrate
```

---

## Step 6: Create Seeders

### Users Seeder

```bash
php artisan make:seeder UsersTableSeeder
```

* Create Admin user
* Login as admin using `Auth::loginUsingId()`
* Create sample users

---

### Posts Seeder

```bash
php artisan make:seeder PostsTableSeeder
```

* Login as admin
* Create sample posts
* UserStamps will automatically populate

---

### Register in DatabaseSeeder

```php
$this->call([
    UsersTableSeeder::class,
    PostsTableSeeder::class,
]);
```

Run:

```bash
php artisan db:seed
```

---

## Step 7: Create Resource Controller

```bash
php artisan make:controller PostController --resource
```

Controller includes:

* index()
* create()
* store()
* show()
* edit()
* update()
* destroy()
* trashed()
* restore()
* forceDelete()

---

## Step 8: Create Routes

```php
Route::resource('posts', PostController::class);
Route::get('/trashed-posts', [PostController::class, 'trashed'])->name('posts.trashed');
Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');

Route::get('/', function () {
    return redirect()->route('posts.index');
});
```

---

## Step 9: Create Views

Create Bootstrap-based views:

* layouts/app.blade.php
* posts/index.blade.php
* posts/create.blade.php
* posts/edit.blade.php
* posts/show.blade.php
* posts/trashed.blade.php

UI includes:

* Post listing with creator/updater info
* Create & edit forms
* Soft delete handling
* Restore & force delete options

---

## Step 10: Run the Application

```bash
php artisan optimize:clear
php artisan serve
```

Visit:

```
http://localhost:8000
```
<img width="1761" height="872" alt="image" src="https://github.com/user-attachments/assets/6e7eaa13-180b-4280-8943-9a37040db023" />

---

# Testing UserStamps

1. Create a post → `created_by` and `updated_by` set
2. Edit post → `updated_by` changes
3. Delete post → `deleted_by` set
4. Restore post → `deleted_by` cleared
5. Force delete → record removed permanently

---

# Database Structure

## Users Table

* id
* name
* email
* password
* created_by
* updated_by
* deleted_by
* created_at
* updated_at
* deleted_at

## Posts Table

* id
* title
* content
* created_by
* updated_by
* deleted_by
* created_at
* updated_at
* deleted_at

---

# How UserStamps Works

Implemented using Laravel model events:

### Creating Event

Automatically sets:

* created_by
* updated_by

### Updating Event

Automatically updates:

* updated_by

### Deleting Event

On soft delete:

* Sets deleted_by

### Restoring Event

* Clears deleted_by

---

# Troubleshooting

### Duplicate Email Error During Seeding

```bash
php artisan migrate:fresh
php artisan db:seed
```

---

# Best Practices

* Always use foreign key constraints
* Handle first admin creation carefully
* Use model events instead of manual assignment
* Add policies for production security
* Use middleware for real authentication

---

# Suggested Enhancements

* Replace auth simulation with Laravel Breeze
* Add roles & permissions
* Add audit logs table
* Create API version of UserStamps
* Add activity timeline UI

---

# Conclusion

This project demonstrates a production-ready approach to implementing **UserStamps in Laravel** using:

* Model events
* Soft deletes
* Foreign key relationships
* Clean MVC structure

It is suitable for:

* Enterprise audit tracking
* Admin panels
* Compliance-based applications
* Interview portfolio projects

---

End of Documentation
