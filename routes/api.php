<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->prefix('v1/')->group(function () {
	
	// guest apis
	Route::post('login', 'AuthController@login');
	Route::post('register', 'AuthController@register');

	// authenticated user apis
	Route::group(['middleware' => 'auth:api'], function(){
    	Route::post('update', 'UserController@update');
	});
});

