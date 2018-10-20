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

Route::get('/','UserController@home')->name('home');
Route::get('/login','UserController@loginPage')->name('login');
Route::post('/login','UserController@login')->name('postLogin');
Route::get('/register','UserController@registerUserPage')->name('registerUser');
Route::post('/register','UserController@registerUser')->name('storeUser');
Route::get('/logout','UserController@logout')->name('logout');
Route::get('/account','UserController@viewAccount')->name('viewAccount');
Route::post('/account/{user}','UserController@editAccount')->name('editAccount');
Route::get('/profile/{user}','UserController@profile')->name('profile');
Route::get('/{hashTag}','UserController@hashTag')->name('hashTag');

Route::group(['prefix' => 'users'],function (){
    Route::get('/', 'userController@index')->name('listUsers');

    Route::group(['prefix' => '{user}'], function () {
        Route::get('/edit', 'userController@edit')->name('editUser');
        Route::post('/update', 'userController@update')->name('updateUser');
        Route::get('/delete', 'userController@destroy')->name('deleteUser');
    });
});

// posts
Route::group(['prefix' => 'posts'],function (){
    Route::post('/store', 'PostController@store')->name('storePost');

    Route::group(['prefix' => '{post}'], function () {
        Route::get('/', 'PostController@show')->name('showPost');
        Route::get('/edit', 'PostController@edit')->name('editPost');
        Route::post('/update', 'PostController@update')->name('updatePost');
        Route::get('/delete', 'PostController@destroy')->name('deletePost');
    });
});

// comments
Route::group(['prefix' => 'comments'],function (){
    Route::post('/{post}/store', 'CommentController@store')->name('storeComment');

    Route::group(['prefix' => '{comment}'], function () {
        Route::get('/edit', 'CommentController@edit')->name('editComment');
        Route::post('/update', 'CommentController@update')->name('updateComment');
        Route::get('/delete', 'CommentController@destroy')->name('deleteComment');
    });
});
