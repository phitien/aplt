<?php
Route::get ( '/', 'Ezsell\Controllers\ItemController@index' );
Route::any ( 'register', 'Ezsell\Controllers\AccountController@register' );
Route::any ( 'code', 'Ezsell\Controllers\AccountController@code' );
Route::any ( 'activate/{code}', 'Ezsell\Controllers\AccountController@activate' );
Route::any ( 'deactivate', 'Ezsell\Controllers\AccountController@deactivate' );

Route::any ( 'login', 'Ezsell\Controllers\AccountController@login' );
Route::any ( 'logout', 'Ezsell\Controllers\AccountController@logout' );

Route::any ( 'profile', 'Ezsell\Controllers\AccountController@profile' );
Route::any ( 'profilex', 'Ezsell\Controllers\AccountController@profilex' );

Route::any ( 'followers', 'Ezsell\Controllers\AccountController@followers' );
Route::any ( 'following', 'Ezsell\Controllers\AccountController@following' );
Route::post ( 'follow/{id}', 'Ezsell\Controllers\AccountController@follow' );
Route::post ( 'accept/{id}', 'Ezsell\Controllers\AccountController@accept' );
Route::post ( 'refuse/{id}', 'Ezsell\Controllers\AccountController@refuse' );

Route::any ( 'password', 'Ezsell\Controllers\AccountController@password' );
Route::any ( 'email', 'Ezsell\Controllers\AccountController@email' );
Route::any ( 'account', 'Ezsell\Controllers\AccountController@account' );
Route::any ( 'forget', 'Ezsell\Controllers\AccountController@forget' );
Route::any ( 'reset', 'Ezsell\Controllers\AccountController@reset' );