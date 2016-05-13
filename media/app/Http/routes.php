<?php
Route::get ( '/', 'Media\Controllers\ItemController@index' );
Route::any ( 'register', 'Media\Controllers\AccountController@register' );
Route::any ( 'code', 'Media\Controllers\AccountController@code' );
Route::any ( 'activate/{code}', 'Media\Controllers\AccountController@activate' );
Route::any ( 'deactivate', 'Media\Controllers\AccountController@deactivate' );

Route::any ( 'login', 'Media\Controllers\AccountController@login' );
Route::any ( 'logout', 'Media\Controllers\AccountController@logout' );

Route::any ( 'profile', 'Media\Controllers\AccountController@profile' );
Route::any ( 'profilex', 'Media\Controllers\AccountController@profilex' );

Route::any ( 'followers', 'Media\Controllers\AccountController@followers' );
Route::any ( 'following', 'Media\Controllers\AccountController@following' );
Route::post ( 'follow/{id}', 'Media\Controllers\AccountController@follow' );
Route::post ( 'accept/{id}', 'Media\Controllers\AccountController@accept' );
Route::post ( 'refuse/{id}', 'Media\Controllers\AccountController@refuse' );

Route::any ( 'password', 'Media\Controllers\AccountController@password' );
Route::any ( 'email', 'Media\Controllers\AccountController@email' );
Route::any ( 'account', 'Media\Controllers\AccountController@account' );
Route::any ( 'forget', 'Media\Controllers\AccountController@forget' );
Route::any ( 'reset', 'Media\Controllers\AccountController@reset' );

Route::any ( 'location', 'Media\Controllers\LocationController@location' );
Route::any ( 'searchlocation', 'Media\Controllers\LocationController@searchlocation' );