<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('home', ['middleware' => ['auth', 'role_disabled'], 'as' => 'home', 'uses' => 'HomeController@index']);

Route::get('/authlanding', ['middleware' => ['auth', 'role_disabled'], 'as' => 'authlanding', 'uses' => 'HomeController@landingPage']);

Route::get('/disabled', ['as' => 'disabled', 'uses' => 'HomeController@disabledAccount']);

Route::get('/', ['as' => 'guestlanding', 'uses' => 'WelcomeController@index']);

Route::resource('pbrowser', 'ProjectBrowserController');

Route::resource('users', 'UserController');

Route::get('disable/{id}', ['uses' => 'UserController@disable', 'as' => 'userdisable']);

Route::get('download/{id}', ['uses' => 'MediaController@download', 'as' => 'download']);

Route::get('adminpanel', ['uses' => 'AdminController@showAdministratorPanel', 'as' => 'adminpanel']);

Route::get('admincreateuser', ['uses' => 'AdminController@showCreateUser', 'as' => 'admincreateuser']);

Route::get('/photos/{id}', ['uses' => 'ProjectGalleryController@showPhotos', 'as' => 'photos']);

Route::get('/videos/{id}', ['uses' => 'ProjectGalleryController@showVideos', 'as' => 'videos']);