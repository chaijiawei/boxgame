<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::get('/', 'TopicsController@index')->name('home');

Route::get('github/login', 'GithubController@login')->name('github.login');
Route::get('github/callback', 'GithubController@callback')->name('github.callback');

Route::resource('users', 'UsersController');

Route::resource('topics', 'TopicsController')->except('show');
Route::get('topics/show/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::post('topics/upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
