<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('dashboard', 'DashboardController@index')->name('dashboard');

// Route::get('post', 'PostController@all_post')->name('post');

// Route::get('/{anypath}', 'DashboardController@index')->where('path','.*');

Route::post('/add-category', 'CategoryController@add_category')->name('category-add');

Route::get('/category', 'CategoryController@all_category')->name('category-all');

Route::get('/category/{id}', 'CategoryController@remove_category')->name('category-del');

Route::post('/update-category', 'CategoryController@update_category')->name('category-update');

Route::get('/post', 'PostController@all_post')->name('post-all');

Route::get('/post/{id}', 'PostController@remove_post')->name('post-del');

Route::post('/add-post', 'PostController@add_post')->name('post-add');

Route::post('/update-post', 'PostController@update_post')->name('post-update');