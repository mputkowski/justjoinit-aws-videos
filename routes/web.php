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

Route::get('/', 'HomeController@index')->name('index');

Route::prefix('video')->name('video.')->group(function () {
    Route::get('create', 'VideoController@create')->name('create');
    Route::get('{video}', 'VideoController@show')->name('show');

    Route::post('create', 'VideoController@store');
});
