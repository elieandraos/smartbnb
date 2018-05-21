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
		// user actions
		Route::post('user/info', 'UserController@index');
    	Route::post('user/update', 'UserController@update');
    	Route::post('user/deposit', 'UserController@deposit');
    	Route::post('user/withdraw', 'UserController@withdraw');
    	// transactions
    	Route::post('transactions/', 'TransactionsController@index');
    	Route::post('transactions/{id}/show', 'TransactionsController@show');
	});

	Route::post('reports/dashboard', 'ReportsController@dashboard');
	Route::post('reports/aggregated', 'ReportsController@aggregated');
});

