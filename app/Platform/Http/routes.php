<?php
Route::any ( '/', 'HomeController@index' );

Route::any ( 'register', 'AccountController@register' );
Route::any ( 'code', 'AccountController@code' );
Route::any ( 'activate/{code}', 'AccountController@activate' );
Route::any ( 'deactivate', 'AccountController@deactivate' );

Route::any ( 'login', 'AccountController@login' );
Route::any ( 'logout', 'AccountController@logout' );

Route::any ( 'profile', 'AccountController@profile' );
Route::any ( 'profilex', 'AccountController@profilex' );

Route::any ( '/followers', 'AccountController@followers' );
Route::any ( '/following', 'AccountController@following' );
Route::post ( '/follow/{id}', 'AccountController@follow' );
Route::post ( '/unfollow/{id}', 'AccountController@unfollow' );
Route::post ( '/accept/{id}', 'AccountController@accept' );
Route::post ( '/refuse/{id}', 'AccountController@refuse' );

Route::any ( 'password', 'AccountController@password' );
Route::any ( 'email', 'AccountController@email' );
Route::any ( 'account', 'AccountController@account' );
Route::any ( 'forget', 'AccountController@forget' );
Route::any ( 'reset', 'AccountController@reset' );

Route::any ( 'location', 'LocationController@location' );
Route::any ( 'searchlocation', 'LocationController@searchlocation' );

/**
 * chating actions
 */
Route::post ( 'sendmessage', 'SocketController@sendmessage' );
Route::post ( 'messages', 'SocketController@messages' );

/**
 * buy/sell forms
 */
Route::any ( '/buyitem', 'ItemController@buyitem' );
Route::any ( '/sellitem', 'ItemController@sellitem' );
Route::any ( '/like', 'ItemController@like' );
/**
 * list items -> need to be under buy/sellitem
 */
Route::any ( '/cat/{id}', 'CatItemsController@list' );
Route::any ( '/{username}', 'UserItemsController@list' );
Route::any ( '/item/{id}', 'ItemController@details' );


