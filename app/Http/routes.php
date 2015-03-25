<?php

Route::get('/', 'PagesController@home');

Route::resource('notices', 'NoticesController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
