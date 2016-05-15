<?php
Route::get ( '/media/{code}', 'MediaController@media' );
Route::get ( '/media/{code}/{type}', 'MediaController@media' );
Route::post ( '/media', 'MediaController@media' );
Route::put ( '/media', 'MediaController@media' );
Route::delete ( '/media/{code}', 'MediaController@media' );

Route::any ( '/noavatarman', 'MediaController@noavatarman' );
Route::any ( '/noavatarwoman', 'MediaController@noavatarwoman' );