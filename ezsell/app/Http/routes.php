<?php
Route::get ( '/', function () {
	return view ( 'welcome', [ ] );
} );
Route::post ( 'register', 'Ezsell\Controllers\AccountController@register' );
Route::any ( 'code', 'Ezsell\Controllers\AccountController@code' );
Route::get ( 'activate/{code}', 'Ezsell\Controllers\AccountController@activate' );
Route::post ( 'deactivate', 'Ezsell\Controllers\AccountController@deactivate' );

Route::any ( 'login', 'Ezsell\Controllers\AccountController@login' );
Route::any ( 'logout', 'Ezsell\Controllers\AccountController@logout' );

Route::any ( 'profile', 'Ezsell\Controllers\AccountController@profile' );
Route::any ( 'profilex', 'Ezsell\Controllers\AccountController@profilex' );

Route::any ( 'followers', 'Ezsell\Controllers\AccountController@followers' );
Route::any ( 'following', 'Ezsell\Controllers\AccountController@following' );
Route::post ( 'follow/{id}', 'Ezsell\Controllers\AccountController@follow' );
Route::post ( 'accept/{id}', 'Ezsell\Controllers\AccountController@accept' );
Route::post ( 'refuse/{id}', 'Ezsell\Controllers\AccountController@refuse' );

Route::post ( 'password', 'Ezsell\Controllers\AccountController@password' );
Route::post ( 'email', 'Ezsell\Controllers\AccountController@email' );
Route::post ( 'account', 'Ezsell\Controllers\AccountController@account' );
Route::post ( 'forget', 'Ezsell\Controllers\AccountController@forget' );
Route::post ( 'reset', 'Ezsell\Controllers\AccountController@reset' );