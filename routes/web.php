<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('register')->with('posts', 5);
});*/
Route::get('/', function () {
    return view('register');
});

Route::get('login','UserController@showLogin')->name('loginget');   
Route::get('register','UserController@showRegister');   

Route::post('/register','UserController@register')->name('register');   
Route::post('login','UserController@login')->name('login');   

Route::group(['middleware' => ['checksession']], function () {
	
	Route::get('/users', function () { return view('users');})->name('users');

	Route::get('/getusers','UserController@getUsersByAppId');   
	Route::get('/edituser','UserController@editUser');   
	Route::post('/updateuser','UserController@updateUser');   
	Route::post('/updatedonor','UserController@updateStatus');   
	Route::post('/deleteuser','UserController@deleteUser');   

    Route::get('/logout','UserController@logout')->name('logout');   

});
