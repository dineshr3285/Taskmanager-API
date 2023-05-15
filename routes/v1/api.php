<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'App\Http\Controllers\Api\V1'], function () {
    // Task module
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('/all', 'TaskController@getAllTasks')->name('all');
        Route::post('/store', 'TaskController@store')->name('store');
        Route::get('{id}/edit', 'TaskController@edit')->name('edit');
        Route::post('/update', 'TaskController@update')->name('update');
        Route::post('/change-status', 'TaskController@changeStatus')->name('change-status');
        Route::delete('{id}/delete', 'TaskController@delete')->name('delete');
    });
});
