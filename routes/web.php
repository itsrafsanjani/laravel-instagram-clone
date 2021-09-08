<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Mail\NewUserWelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes(['verify' => true]);

Route::get('/notices/username', function () {
    return view('notices.username');
})->name('notices.username');

Route::get('/notices/image', function () {
    return view('notices.image');
})->name('notices.image');

Route::get('/privacy-policy', function () {
    return view('static-pages.privacy-policy');
})->name('static-pages.privacy-policy');

Route::get('/terms-of-service', function () {
    return view('static-pages.terms-of-service');
})->name('static-pages.terms-of-service');

Route::get('/cookies', function () {
    return view('static-pages.cookies');
})->name('static-pages.cookies');

Route::get('/welcome-email', function () {
    return new NewUserWelcomeMail();
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('/follows/{username}', [FollowController::class, 'toggle'])->name('follows.toggle');
    Route::post('/likes/{post}', [PostController::class, 'like'])->name('likes.store');

    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::resource('/posts', PostController::class)->except(['index']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{username}/followings', [UserController::class, 'followings'])->name('users.followings');
    Route::get('/users/{username}/followers', [UserController::class, 'followers'])->name('users.followers');

    Route::resource('/comments', CommentController::class)->only(['store', 'destroy']);

    Route::get('/explore', [PostController::class, 'explore'])->name('posts.explore');

    Route::get('/notifications', [UserController::class, 'notifications'])->name('users.notifications');
});
