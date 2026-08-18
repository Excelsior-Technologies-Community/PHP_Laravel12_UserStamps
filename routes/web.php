<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Post Routes
|--------------------------------------------------------------------------
*/

Route::resource('posts', PostController::class);

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
| Activity History
|--------------------------------------------------------------------------
|
| Use {postId} instead of {post} so Laravel does not use
| normal implicit model binding, which ignores soft-deleted posts.
|
*/

Route::get(
    '/posts/{postId}/activity',
    [ActivityLogController::class, 'postActivity']
)->name('posts.activity');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('posts.index');
});