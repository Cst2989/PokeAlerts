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

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/location', 'LocationController@index');
Route::post('/addLocation', 'LocationController@store');
Route::get('/alert', 'AlertController@index');
Route::post('/addAlert', 'AlertController@store');
Route::get('/my-alerts', 'MyAlertsController@index');
Route::delete('/my-alerts/{alert}', 'MyAlertsController@destroy');