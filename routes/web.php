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

Auth::routes();

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follows/{user}', 'FollowController@store');

Route::get('/', 'PostController@index');
Route::get('/p/create', 'PostController@create')->name('posts.create');
Route::post('/p', 'PostController@store');
Route::get('/p/{post}', 'PostController@show');
Route::delete('/p/{post}', 'PostController@destroy')->name('posts.destroy');

Route::get('/profiles', 'ProfileController@index')->name('profiles.index');
Route::get('/profiles/{user}', 'ProfileController@show')->name('profiles.show');
Route::get('/profiles/{user}/edit', 'ProfileController@edit')->name('profiles.edit');
Route::patch('/profiles/{user}', 'ProfileController@update')->name('profiles.update');
