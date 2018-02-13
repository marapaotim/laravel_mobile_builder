<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

/*--------------------
    Basic Builder
----------------------*/ 
Route::group(['namespace' => 'Basic'], function () {

    Route::get('/basicbuilder/{id}', 'MobileprojectController@index');
    Route::get('/tree_files', 'MobileprojectController@get_tree_files');
    Route::post('/get_file', 'MobileprojectController@file_content');
    Route::post('/upload_file', 'MobileprojectController@upload_file_project');

});


Auth::routes();

/**
 * Builder Routes
 */
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');

Route::get('/app', 'MobileApplicationController@applist');
Route::post('/app/create', 'MobileApplicationController@appcreate');
Route::get('/app/create', 'MobileApplicationController@appcreateredirect');
Route::get('/builder/{id}', 'MobileApplicationController@builder');
Route::get('/screen/{id}', 'MobileApplicationController@screen');

Route::get('/img-proxy', 'MobileApplicationController@imgproxy');
Route::post('/img-upload', 'MobileApplicationController@imgupload');

Route::get('/thumbs/{id}', 'MobileApplicationController@getSceneThumbnails');

/**
 * Administrator Routes
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Administrator'], function () {
	//Login
	Route::get('/login', 'AdminLoginController@index');
    Route::post('/login', 'AdminLoginController@login');

    //Admin
    Route::get('/', 'AdminController@index');
    Route::post('/logout', 'AdminController@logout');
    Route::get('/components', 'AdminController@components')->middleware('idms.fbf:MAB.Components.View');
    Route::get('/users', 'AdminController@users');
    Route::get('/roles', 'AdminController@roles');
    Route::get('/categories', 'AdminController@categories')->middleware('idms.fbf:MAB.Category.View');
    Route::get('/prebuiltapps', 'AdminController@prebuiltapps')->middleware('idms.fbf:MAB.Prebuiltapps.View');
});

Route::get('/components/download/{name?}', 'Administrator\ComponentApiController@download')->middleware('idms.fbf:MAB.Components.Download');