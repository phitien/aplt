<?php
Route::get ( '/', 'Controllers\ItemController@index' );
Route::any ( 'register', 'Controllers\AccountController@register' );
Route::any ( 'code', 'Controllers\AccountController@code' );
Route::any ( 'activate/{code}', 'Controllers\AccountController@activate' );
Route::any ( 'deactivate', 'Controllers\AccountController@deactivate' );

Route::any ( 'login', 'Controllers\AccountController@login' );
Route::any ( 'logout', 'Controllers\AccountController@logout' );

Route::any ( 'profile', 'Controllers\AccountController@profile' );
Route::any ( 'profilex', 'Controllers\AccountController@profilex' );

Route::any ( 'followers', 'Controllers\AccountController@followers' );
Route::any ( 'following', 'Controllers\AccountController@following' );
Route::post ( 'follow/{id}', 'Controllers\AccountController@follow' );
Route::post ( 'accept/{id}', 'Controllers\AccountController@accept' );
Route::post ( 'refuse/{id}', 'Controllers\AccountController@refuse' );

Route::any ( 'password', 'Controllers\AccountController@password' );
Route::any ( 'email', 'Controllers\AccountController@email' );
Route::any ( 'account', 'Controllers\AccountController@account' );
Route::any ( 'forget', 'Controllers\AccountController@forget' );
Route::any ( 'reset', 'Controllers\AccountController@reset' );

Route::any ( 'location', 'Controllers\LocationController@location' );
Route::any ( 'searchlocation', 'Controllers\LocationController@searchlocation' );