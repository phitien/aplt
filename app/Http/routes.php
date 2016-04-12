<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::group ( [ 
		'prefix' => 'api' 
], function () {
	Route::resource ( 'login', 'IMAuthController', [ 
			'only' => [ 
					'index' 
			] 
	] );
	Route::post ( 'register', 'IMAuthController@register' );
	Route::get ( 'activate/{activationCode}', 'IMAuthController@activate' );
	Route::post ( 'activate', 'IMAuthController@sendActivationCode' );
	Route::post ( 'login', 'IMAuthController@login' );
	Route::get ( 'profile', 'IMAuthController@profile' );
} );