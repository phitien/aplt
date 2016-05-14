<?php
Route::group ( [ 
		'prefix' => 'api' 
], function () {
	Route::post ( 'register', 'AccountController@register' );
	Route::any ( 'code', 'AccountController@code' );
	Route::get ( 'activate/{code}', 'AccountController@activate' );
	Route::post ( 'deactivate', 'AccountController@deactivate' );
	
	Route::post ( 'login', 'AccountController@login' );
	Route::any ( 'logout', 'AccountController@logout' );
	
	Route::any ( 'profile', 'AccountController@profile' );
	Route::any ( 'profilex', 'AccountController@profilex' );
	
	Route::any ( 'followers', 'AccountController@followers' );
	Route::any ( 'following', 'AccountController@following' );
	Route::post ( 'follow/{id}', 'AccountController@follow' );
	Route::post ( 'unfollow/{id}', 'AccountController@unfollow' );
	Route::post ( 'accept/{id}', 'AccountController@accept' );
	Route::post ( 'refuse/{id}', 'AccountController@refuse' );
	
	Route::post ( 'password', 'AccountController@password' );
	Route::post ( 'email', 'AccountController@email' );
	Route::post ( 'account', 'AccountController@account' );
	Route::post ( 'forget', 'AccountController@forget' );
	Route::post ( 'reset', 'AccountController@reset' );
} );