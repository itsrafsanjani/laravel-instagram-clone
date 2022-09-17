<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PurchaseStatusController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ScreenshotController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// admin routes
require __DIR__.'/admin.php';

Auth::routes(['verify' => true]);

Route::get('/language', LanguageController::class)->name('change_language');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::resource('/posts', PostController::class)->except(['index']);

    Route::get('/users/{user}/followings', [UserController::class, 'followings'])->name('users.followings');
    Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::resource('/users', UserController::class)->only(['index', 'show', 'edit', 'update']);
    Route::get('/users-search', [UserController::class, 'search'])->name('users.search');

    Route::post('/follows/{user}', [FollowController::class, 'toggle'])->name('follows.toggle');

    Route::post('/likes/{post}', [LikeController::class, 'toggle'])->name('likes.toggle');

    Route::resource('/comments', CommentController::class)->only(['store', 'destroy']);

    Route::get('/explore', [PostController::class, 'explore'])->name('posts.explore');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::resource('/screenshots', ScreenshotController::class);

    Route::resource('/short-urls', ShortUrlController::class)->except(['edit', 'update']);

    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
});

/*
 * static pages for
 * notices and privacy policy, terms of service, cookie policy etc.
 */
Route::get('/notices/{notice}', NoticeController::class)
    ->name('notices')
    ->whereIn('notice', ['username', 'image']);

Route::get('/{page}', StaticPageController::class)
    ->name('static-pages')
    ->whereIn('page', ['privacy-policy', 'terms-of-service', 'cookies']);
