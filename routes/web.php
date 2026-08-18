<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [PostController::class, 'dashboard']
)->name('dashboard');

/*
|--------------------------------------------------------------------------
| Post Routes
|--------------------------------------------------------------------------
*/

Route::resource(
    'posts',
    PostController::class
);

/*
|--------------------------------------------------------------------------
| Soft Delete Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/trashed-posts',
    [PostController::class, 'trashed']
)->name('posts.trashed');

Route::post(
    '/posts/{id}/restore',
    [PostController::class, 'restore']
)->name('posts.restore');

Route::delete(
    '/posts/{id}/force-delete',
    [PostController::class, 'forceDelete']
)->name('posts.force-delete');

/*
|--------------------------------------------------------------------------
| Post Activity
|--------------------------------------------------------------------------
*/

Route::get(
    '/posts/{postId}/activity',
    [ActivityLogController::class, 'postActivity']
)->name('posts.activity');

/*
|--------------------------------------------------------------------------
| Global Activity History
|--------------------------------------------------------------------------
*/

Route::get(
    '/activity-history',
    [ActivityLogController::class, 'index']
)->name('activity.history');

/*
|--------------------------------------------------------------------------
| CSV Export
|--------------------------------------------------------------------------
*/

Route::get(
    '/posts-export',
    [PostController::class, 'export']
)->name('posts.export');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});
