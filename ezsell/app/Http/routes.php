<?php
Route::get ( '/', 'Platform\Controllers\ItemController@index' );
Route::any ( 'register', 'Platform\Controllers\AccountController@register' );
Route::any ( 'code', 'Platform\Controllers\AccountController@code' );
Route::any ( 'activate/{code}', 'Platform\Controllers\AccountController@activate' );
Route::any ( 'deactivate', 'Platform\Controllers\AccountController@deactivate' );

Route::any ( 'login', 'Platform\Controllers\AccountController@login' );
Route::any ( 'logout', 'Platform\Controllers\AccountController@logout' );

Route::any ( 'profile', 'Platform\Controllers\AccountController@profile' );
Route::any ( 'profilex', 'Platform\Controllers\AccountController@profilex' );

Route::any ( 'followers', 'Platform\Controllers\AccountController@followers' );
Route::any ( 'following', 'Platform\Controllers\AccountController@following' );
Route::post ( 'follow/{id}', 'Platform\Controllers\AccountController@follow' );
Route::post ( 'accept/{id}', 'Platform\Controllers\AccountController@accept' );
Route::post ( 'refuse/{id}', 'Platform\Controllers\AccountController@refuse' );

Route::any ( 'password', 'Platform\Controllers\AccountController@password' );
Route::any ( 'email', 'Platform\Controllers\AccountController@email' );
Route::any ( 'account', 'Platform\Controllers\AccountController@account' );
Route::any ( 'forget', 'Platform\Controllers\AccountController@forget' );
Route::any ( 'reset', 'Platform\Controllers\AccountController@reset' );

Route::any ( 'location', 'Platform\Controllers\LocationController@location' );
Route::any ( 'searchlocation', 'Platform\Controllers\LocationController@searchlocation' );