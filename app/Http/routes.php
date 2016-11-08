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
    return view('auth/login');
});

// book page
Route::get('/book', 'BookingController@book');
Route::get('/getHalls', 'BookingController@getHalls');
Route::post('/bookHalls', 'BookingController@bookHalls');

// my halls page
Route::get('/myHalls', 'MyHallsController@myHalls');
Route::post('/cancelHalls', 'MyHallsController@cancelHalls');


Route::get('/admin/book',function(){
	return view('adminBooking');
});

Route::get('getadminhalls','AdminController@getHalls');
Route::post('bookadminhalls','AdminController@bookHalls');

// my halls page for the admin
Route::get('/admin/myHalls', 'AdminController@myHalls');
Route::post('/admin/cancelHalls', 'AdminController@cancelHalls');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
