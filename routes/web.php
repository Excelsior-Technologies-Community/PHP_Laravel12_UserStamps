<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Post routes
Route::resource('posts', PostController::class);
Route::get('/trashed-posts', [PostController::class, 'trashed'])->name('posts.trashed');
Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');

// Home route
Route::get('/', function () {
    return redirect()->route('posts.index');
});