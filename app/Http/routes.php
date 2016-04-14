<?php
Route::group ( [ 
		'prefix' => 'api' 
], function () {
	Route::post ( 'register', 'IM\Controllers\RegisterController@register' );
	Route::get ( 'activate/{activationCode}', 'IM\Controllers\RegisterController@activate' );
	Route::post ( 'activate', 'IM\Controllers\RegisterController@sendActivationCode' );
	Route::post ( 'deactivate', 'IM\Controllers\RegisterController@deactivate' );
	
	Route::post ( 'login', 'IM\Controllers\AuthenticateController@login' );
	Route::any ( 'refresh', 'IM\Controllers\AuthenticateController@refresh' );
	Route::any ( 'logout', 'IM\Controllers\AuthenticateController@logout' );
	
	Route::get ( 'profile', 'IM\Controllers\ProfileController@profile' );
	Route::post ( 'profile', 'IM\Controllers\ProfileController@updateProfile' );
	
	Route::post ( 'password', 'IM\Controllers\AccountController@password' );
	Route::post ( 'email', 'IM\Controllers\AccountController@email' );
	Route::post ( 'account', 'IM\Controllers\AccountController@account' );
	Route::post ( 'forget', 'IM\Controllers\AccountController@forget' );
	Route::post ( 'reset', 'IM\Controllers\AccountController@reset' );
} );