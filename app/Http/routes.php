<?php
Route::group ( [ 
		'prefix' => 'api' 
], function () {
	// Route::resource ( 'login', 'IM\Controllers\AuthController', [
	// 'only' => [
	// 'index'
	// ]
	// ] );
	Route::post ( 'register', 'IM\Controllers\RegisterController@register' );
	Route::any ( 'activate/{activationCode}', 'IM\Controllers\RegisterController@activate' );
	Route::any ( 'activate', 'IM\Controllers\RegisterController@sendActivationCode' );
	
	Route::post ( 'login', 'IM\Controllers\AuthController@login' );
	Route::any ( 'refresh', 'IM\Controllers\AuthController@refresh' );
	Route::any ( 'logout', 'IM\Controllers\AuthController@logout' );
	
	Route::any ( 'profile', 'IM\Controllers\ProfileController@profile' );
	Route::post ( 'profile', 'IM\Controllers\ProfileController@updateProfile' );
	
	Route::post ( 'password', 'IM\Controllers\AccountController@password' );
	Route::post ( 'reset', 'IM\Controllers\AccountController@reset' );
	Route::post ( 'email', 'IM\Controllers\AccountController@email' );
	Route::post ( 'account', 'IM\Controllers\AccountController@account' );
} );