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

Route::get('/', function () {
	return view('welcome');
});
Route::get('/posts','PostController@index');

Route::get('/gym', function () {
	return view('gym');
});

Route::get('/api/pokemon','ApiController@pokemon');
Route::get('/api/location','ApiController@location');

Route::post('/send', 'EmailController@send');


Route::group(['middleware' => ['auth']], function()
{

	Route::get('/home', 'HomeController@index');
	Route::get('/location', 'LocationController@index');
	Route::post('/addLocation', 'LocationController@store');
	Route::get('/alert', 'AlertController@index');
	Route::post('/addAlert', 'AlertController@store');
	Route::get('/my-alerts', 'MyAlertsController@index');
	Route::delete('/my-alerts/{alert}', 'MyAlertsController@destroy');


	Route::get('new-post','PostController@create');
 // save new post
	Route::post('new-post','PostController@store');
 // edit post form
	Route::get('edit/{slug}','PostController@edit');
 // update post
	Route::post('update','PostController@update');
 // delete post
	Route::get('delete/{id}','PostController@destroy');
 // display user's all posts
	Route::get('my-all-posts','UserController@user_posts_all');
 // display user's drafts
	Route::get('my-drafts','UserController@user_posts_draft');
 // add comment
	Route::post('comment/add','CommentController@store');
 // delete comment
	Route::post('comment/delete/{id}','CommentController@distroy');
});
Route::get('user/{id}','UserController@profile')->where('id', '[0-9]+');
// display list of posts
Route::get('user/{id}/posts','UserController@user_posts')->where('id', '[0-9]+');
// display single post

Route::get('/{slug}',['as' => 'post', 'uses' => 'PostController@show'])->where('slug', '[A-Za-z0-9-_]+');