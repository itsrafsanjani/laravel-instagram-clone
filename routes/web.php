<?php

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

use App\Mail\NewUserWelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/notices/username', function () {
    return view('notice.username');
})->name('notice.username');

Route::get('/notices/image', function () {
    return view('notice.image');
})->name('notice.image');

Route::get('/welcome-email', function () {
    return new NewUserWelcomeMail();
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::post('/follows/{user}', 'FollowController@store');
    Route::post('/likes/{post}', 'PostController@like');

    Route::get('/', 'PostController@index')->name('posts.index');
    Route::get('/p/create', 'PostController@create')->name('posts.create');
    Route::post('/p', 'PostController@store')->name('posts.store');
    Route::get('/p/{post}', 'PostController@show')->name('posts.show');
    Route::delete('/p/{post}', 'PostController@destroy')->name('posts.destroy');

    Route::get('/profiles', 'ProfileController@index')->name('profiles.index');
    Route::get('/profiles/{user}', 'ProfileController@show')->name('profiles.show');
    Route::get('/profiles/{user}/edit', 'ProfileController@edit')->name('profiles.edit');
    Route::patch('/profiles/{user}', 'ProfileController@update')->name('profiles.update');
});


