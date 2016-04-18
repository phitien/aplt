<?php
Route::get ( '/', function () {
	return view ( 'welcome', [ ] );
} );

Route::group ( [ 
		'prefix' => 'api' 
], function () {
	Route::post ( 'register', 'IM\Controllers\AccountController@register' );
	Route::any ( 'code', 'IM\Controllers\AccountController@code' );
	Route::get ( 'activate/{code}', 'IM\Controllers\AccountController@activate' );
	Route::post ( 'deactivate', 'IM\Controllers\AccountController@deactivate' );
	
	Route::post ( 'login', 'IM\Controllers\AccountController@login' );
	Route::any ( 'logout', 'IM\Controllers\AccountController@logout' );
	
	Route::any ( 'profile', 'IM\Controllers\AccountController@profile' );
	Route::any ( 'profilex', 'IM\Controllers\AccountController@profilex' );
	
	Route::any ( 'followers', 'IM\Controllers\AccountController@followers' );
	Route::any ( 'following', 'IM\Controllers\AccountController@following' );
	Route::post ( 'follow/{id}', 'IM\Controllers\AccountController@follow' );
	Route::post ( 'accept/{id}', 'IM\Controllers\AccountController@accept' );
	Route::post ( 'refuse/{id}', 'IM\Controllers\AccountController@refuse' );
	
	Route::post ( 'password', 'IM\Controllers\AccountController@password' );
	Route::post ( 'email', 'IM\Controllers\AccountController@email' );
	Route::post ( 'account', 'IM\Controllers\AccountController@account' );
	Route::post ( 'forget', 'IM\Controllers\AccountController@forget' );
	Route::post ( 'reset', 'IM\Controllers\AccountController@reset' );
} );