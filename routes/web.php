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

Route::get('/', function () {
    return view('register')->with('posts', 5);
});

/*Route::get('/login', function () {
    return view('login');
});*/


/*
Route::post('/register', function () {
	echo "<pre>";print_r($request->all());
    //return view('dashboard')->with('posts', 5);
})->name('register');*/

Route::post('/register','UserController@register')->name('register');   
Route::post('/login','UserController@login')->name('login');   

Route::get('/users', function () {
    return view('users');
});
Route::post('/users','UserController@users')->name('users');   
