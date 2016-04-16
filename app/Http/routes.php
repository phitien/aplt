<?php
Route::get ( '/', function () {
	return view ( 'welcome', [ ] );
} );

Route::group ( [ 
		'prefix' => 'api' 
], function () {
	Route::post ( 'register', 'IM\Controllers\RegisterController@register' );
	Route::get ( 'activate/{activationCode}', 'IM\Controllers\RegisterController@activate' );
	Route::post ( 'activate', 'IM\Controllers\RegisterController@sendActivationCode' );
	Route::post ( 'deactivate', 'IM\Controllers\RegisterController@deactivate' );
	
	Route::post ( 'login', 'IM\Controllers\AuthenticableController@login' );
	Route::any ( 'refresh', 'IM\Controllers\AuthenticableController@refresh' );
	Route::any ( 'logout', 'IM\Controllers\AuthenticableController@logout' );
	
	Route::get ( 'profile', 'IM\Controllers\ProfileController@profile' );
	Route::post ( 'profile', 'IM\Controllers\ProfileController@updateProfile' );
	Route::post ( 'exinfo', 'IM\Controllers\ProfileController@updateExInfo' );
	
	Route::any ( 'followers', 'IM\Controllers\SocietyController@followers' );
	Route::any ( 'following', 'IM\Controllers\SocietyController@following' );
	Route::post ( 'follow', 'IM\Controllers\SocietyController@follow' );
	Route::post ( 'accept', 'IM\Controllers\SocietyController@accept' );
	
	Route::post ( 'password', 'IM\Controllers\AccountController@password' );
	Route::post ( 'email', 'IM\Controllers\AccountController@email' );
	Route::post ( 'account', 'IM\Controllers\AccountController@account' );
	Route::post ( 'forget', 'IM\Controllers\AccountController@forget' );
	Route::post ( 'reset', 'IM\Controllers\AccountController@reset' );
} );