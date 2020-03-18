<?php

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
Route::get('/', 'PostController@index')->name('index');

    Route::middleware(['auth','verified'])->group(function(){
    Route::post('/', 'PostController@store');
    Route::delete('/posts/{id}', 'PostController@destroy');
    Route::patch('/posts/{id}', 'PostController@update')->name('update');
    Route::get('/post/{id}', 'PostController@show')->name('show');

    Route::get("/posts/topViews","PostController@topViews");


    Route::get('/post/{id}/like','ReactionController@like')->name('like');
    Route::get('/post/{id}/dislike','ReactionController@dislike')->name('dislike');

});

Auth::routes();
