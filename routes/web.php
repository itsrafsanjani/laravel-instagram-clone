<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PurchaseStatusController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ScreenshotController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\StaticPageController;
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

Route::get('/purchase', [PurchaseStatusController::class, 'index'])
    ->name('purchase.index');
Route::post('/purchase', [PurchaseStatusController::class, 'purchaseCode'])
    ->name('purchase.purchase_code');

Route::group(['middleware' => 'purchase'], function () {});


Auth::routes(['verify' => true]);

Route::get('/welcome-email', function () {
    return new NewUserWelcomeMail();
});

Route::get('/language', LanguageController::class)->name('change_language');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::resource('/posts', PostController::class)->except(['index']);

    Route::get('/users/{user}/followings', [UserController::class, 'followings'])->name('users.followings');
    Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::resource('/users', UserController::class)->only(['index', 'show', 'edit', 'update']);

    Route::post('/follows/{user}', [FollowController::class, 'toggle'])->name('follows.toggle');
    Route::post('/likes/{post}', [LikeController::class, 'toggle'])->name('likes.toggle');

    Route::resource('/comments', CommentController::class)->only(['store', 'destroy']);

    Route::get('/explore', [PostController::class, 'explore'])->name('posts.explore');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::resource('/screenshots', ScreenshotController::class);

    Route::resource('/short-urls', ShortUrlController::class)->except(['edit', 'update']);

    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
});

// admin routes
require __DIR__.'/admin.php';

Route::get('/notices/username', function () {
    return view('notices.username');
})->name('notices.username');

Route::get('/notices/image', function () {
    return view('notices.image');
})->name('notices.image');

Route::get('/{page}', StaticPageController::class)
    ->name('static-pages')
    ->whereIn('page', ['privacy-policy', 'terms-of-service', 'cookies']);
