<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
    return view('notice.username');
})->name('notice.username');

Route::get('/notices/image', function () {
    return view('notice.image');
})->name('notice.image');

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

    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/{user}', [ProfileController::class, 'show'])->name('profiles.show');
    Route::get('/profiles/{user}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::patch('/profiles/{user}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::get('/profiles/{username}/followings', [ProfileController::class, 'followings'])->name('profiles.followings');
    Route::get('/profiles/{username}/followers', [ProfileController::class, 'followers'])->name('profiles.followers');

    Route::resource('/comments', CommentController::class)->only(['store', 'destroy']);
});
