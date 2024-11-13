<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('index');
Route::get('/search', [BlogController::class, 'searchBlog']);

Route::get('/dashboard',[BlogController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('blogs')->group(function () {
    Route::post('/', [BlogController::class, 'store'])->name('blog.create')->middleware(['auth', 'verified']);
    Route::put('/{blog_id}', [BlogController::class, 'update'])->name('blog.update')->middleware(['auth', 'verified']);
    Route::delete('/{blog_id}', [BlogController::class, 'destroy'])->name('blog.delete')->middleware(['auth', 'verified']);
    Route::post('/comment', [BlogController::class, 'comment'])->name('blog.comment')->middleware(['auth', 'verified']);
    Route::delete('/comment/{comment_id}', [BlogController::class, 'deleteComment'])->name('blog.deleteComment')->middleware(['auth', 'verified']);
});


require __DIR__.'/auth.php';

Route::get('/{blog}', [BlogController::class, 'blog'])->name('blog');