<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/','DashboardController@show_page');
    Route::get('createNewBooks','BookController@show_create_new_books_page');
    Route::post('postCreateNewBooks','BookController@save_new_books');
});

Route::auth();
