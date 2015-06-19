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

Route::get('disableenable/{id}', ['uses' => 'AdminController@disableOrEnable', 'as' => 'userdisableenable']);

Route::get('download/{id}', ['uses' => 'MediaController@download', 'as' => 'download']);

Route::get('adminpanel', ['uses' => 'AdminController@showAdministratorPanel', 'as' => 'adminpanel']);

Route::get('authorpanel', ['uses' => 'AuthorController@showAuthorPanel', 'as' => 'authorpanel']);

Route::get('editorpanel', ['uses' => 'EditorController@showEditorPanel', 'as' => 'editorpanel']);

Route::get('editorpanelapproved', ['uses' => 'EditorController@showEditorPanelApproved', 'as' => 'editorpanelapproved']);

Route::get('editorpanelrefused', ['uses' => 'EditorController@showEditorPanelRefused', 'as' => 'editorpanelrefused']);

Route::get('authorpanelrefused', ['uses' => 'AuthorController@showAuthorRefusedPanel', 'as' => 'authorpanelrefused']);

Route::get('adminpanel/reset/{id}', ['uses' => 'AdminController@showPasswordReset', 'as' => 'adminpanelreset']);

Route::get('admincreateuser', ['uses' => 'AdminController@showCreateUser', 'as' => 'admincreateuser']);

Route::post('admincreateuser', ['uses' => 'AdminController@postCreateUser', 'as' => 'admincreateuser-post']);

Route::post('admineditpassword/{id}', ['uses' => 'AdminController@editPassword', 'as' => 'admineditpassword']);

Route::post('delete/{id}', ['uses' => 'AdminController@showDeleteUser', 'as' => 'admindeleteuser']);

Route::post('delete/remove/{id}', ['uses' => 'AdminController@delete', 'as' => 'admindeleteuserdatabase']);

Route::get('/photos/{id}', ['uses' => 'ProjectGalleryController@showPhotos', 'as' => 'photos']);

Route::get('/videos/{id}', ['uses' => 'ProjectGalleryController@showVideos', 'as' => 'videos']);

Route::get('/edituser/{id}', ['uses' => 'AdminController@showEditUser', 'as' => 'edituser']);

Route::post('/edituser/{id}', ['uses' => 'AdminController@edit', 'as' => 'adminedituser-post']);

Route::get('/contactrequest/{contacteeid}/{contacterid}/{projectid}', ['uses' => 'MailController@sendContactRequest', 'as' => 'contactrequest']);

Route::get('/contactrequest/{contacteeid}/{projectid}', ['uses' => 'MailController@sendAnonContactRequest', 'as' => 'anoncontactrequest']);

Route::post('/submitcomment/{id}', ['uses' => 'ProjectBrowserController@submitComment', 'as' => 'submitcomment']);

Route::post('/pendingprojdelete/{id}', ['uses' => 'AuthorController@deletePendingProject', 'as' => 'pendingprojdelete']);

Route::post('/pendingmediadelete/{id}', ['uses' => 'AuthorController@deletePendingMedia', 'as' => 'pendingmediadelete']);

Route::get('/createproject', ['uses' => 'AuthorController@showCreateProject', 'as' => 'authorcreateproject']);

Route::post('/createproject', ['uses' => 'AuthorController@submitCreatedProject', 'as' => 'authorcreateproject-post']);

Route::get('/viewcomments', ['uses' => 'AuthorController@showComments', 'as' => 'authorpanelcomments']);

Route::post('/pendingprojsubmitmedia/{id}', ['uses' => 'AuthorController@showSubmitMediaPendingProject', 'as' => 'pendingprojsubmitmedia-show']);

Route::post('/pendingprojsubmitmediaupload/{id}', ['uses' => 'AuthorController@submitMediaPendingProject', 'as' => 'pendingprojsubmitmedia-upload']);

Route::post('/pendingcommentdelete/{id}', ['uses' => 'AuthorController@deletePendingComment', 'as' => 'pendingcommentdelete']);

Route::get('/showapproveproject/{id}', ['uses' => 'EditorController@showApproveProject', 'as' => 'pendingprojapprove-show']);

Route::post('/approveproject/{id}', ['uses' => 'EditorController@approveProject', 'as' => 'pendingprojapprove']);

Route::post('refuseproject/{id}', ['uses' => 'EditorController@refuseProject', 'as' => 'pendingprojrefuse']);

Route::get('/showrefuseproject/{id}', ['uses' => 'EditorController@showRefuseProject', 'as' => 'pendingprojrefuse-show']);

Route::post('approvemedia/{id}', ['uses' => 'EditorController@approveMedia', 'as' => 'pendingmediaapprove']);

Route::get('showrefusemedia/{id}', ['uses' => 'EditorController@showRefuseMedia', 'as' => 'pendingmediarefuse-show']);

Route::post('/refusemedia/{id}', ['uses' => 'EditorController@refuseMedia', 'as' => 'pendingmediarefuse']);

Route::post('approvecomment/{id}', ['uses' => 'EditorController@approveComment', 'as' => 'pendingcommentapprove']);

Route::get('showrefusecomment/{id}', ['uses' => 'EditorController@showRefuseComment', 'as' => 'pendingcommentrefuse-show']);

Route::post('showrefusecomment/{id}', ['uses' => 'EditorController@refuseComment', 'as' => 'pendingcommentrefuse']);

Route::get('showeditoreditproj/{id}', ['uses' => 'EditorController@showEditProject', 'as' => 'editoreditproj-show']);

Route::post('editoreditproj/{id}', ['uses' => 'EditorController@editProject', 'as' => 'editoreditproj-post']);

Route::post('editorremoveproj/{id}', ['uses' => 'EditorController@removeProject', 'as' => 'editorremoveproj']);

Route::post('editorremovemedia/{id}', ['uses' => 'EditorController@removeMedia', 'as' => 'editorremovemedia']);

Route::post('editorremovecomment/{id}', ['uses' => 'EditorController@removeComment', 'as' => 'editorremovecomment']);