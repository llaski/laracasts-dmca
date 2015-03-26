<?php

Route::get('/', 'PagesController@home');

Route::get('notices/confirm', 'NoticesController@confirm');
Route::resource('notices', 'NoticesController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
