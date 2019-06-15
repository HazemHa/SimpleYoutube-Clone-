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

Route::prefix('api/')->group(function () {
    Route::post('/checkToken', 'UsersController@checkToken');
    Route::post('/singin', 'UsersController@singin');
    Route::post('/singup', 'UsersController@singup');
    Route::post('/profile', 'UsersController@profile');
    Route::post('/increaseView', 'UsersController@increaseView');
    Route::post('/addVideo','UsersController@addVideo');
});
Route::get('/{any}', function () {
    return view('welcome');
})->where('any','.*');
