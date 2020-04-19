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
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

	Route::get('/home', 'HomeController@index')->name('home');
	
	// Skill
	Route::group(['prefix' => '/skill'], function() {
		Route::get('/', 'SkillController@index')->name('index')->middleware('admin_middleware');
		
		Route::get('/create', 'SkillController@create')->name('create');
		Route::post('/add', 'SkillController@store')->name('add');
		
		Route::get('/edit/{id}', 'SkillController@edit')->name('edit');
		Route::post('/update/{id}', 'SkillController@update')->name('update');
		
		Route::get('/getData', 'SkillController@show')->name('getData');
		Route::any('/delete/{id}', 'SkillController@destroy')->name('delete');
	});

	// User Details
	Route::group(['prefix' => '/user_details'], function() {
		Route::get('/', 'UserDetailsController@index')->name('index');
		// ->middleware('admin_middleware');

		Route::get('/create', 'UserDetailsController@create')->name('create');
		Route::post('/add', 'UserDetailsController@store')->name('add');
		
		Route::get('/edit/{id}', 'UserDetailsController@edit')->name('edit');
		Route::post('/update/{id}', 'UserDetailsController@update')->name('update');
		
		Route::get('/getData', 'UserDetailsController@show')->name('getData');
		Route::any('/delete/{id}', 'UserDetailsController@destroy')->name('delete');
		
		Route::get('/my_friend_request', 'UserDetailsController@myFridendRequest')->name('my_friend_request');
		Route::any('/friend_request_list', 'UserDetailsController@friendRequestList')->name('friend_request_list');

		Route::get('/my_friend', 'UserDetailsController@myFriends')->name('my_friend');
		Route::any('/friend_list', 'UserDetailsController@friendList')->name('friend_list');

		// user action for accept, reject, cancel and unfriend
		Route::any('/friend_action/{id}/{status}', 'UserDetailsController@friendAction')->name('friend_action');
		
		Route::get('/user_skill_index', 'UserDetailsController@userSkillIndex')->name('user_skill_index');
		Route::any('/user_skill', 'UserDetailsController@userSkill')->name('user_skill');
		Route::any('/friend_request/{id}', 'UserDetailsController@friendRequest')->name('friend_request');
		Route::any('/cancel_request/{id}', 'UserDetailsController@cancelRequest')->name('cancel_request');
	});

	
});

Route::get('/home', 'HomeController@index')->name('home');
