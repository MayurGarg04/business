<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
	/*DB::table('users')->insert(
    ['user_name' => 'administrator', 'password' => app('hash')->make('admin@123'), 'email' => 'mayur@gmail.com', 'status' => 1, 'app_id'=> 'paytm', 'access_token' => '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad']);
  */
    return $router->app->version();
});

// API route group

/*$router->group(['prefix' => 'api'], function () use ($router) {
  $router->post('login', 'AuthController@login');
});*/

$router->post('login', 'AuthController@login');

// API route group with middleware

$router->group(['middleware' => 'checkapp'], function() use ($router) {

    $router->post('register', 'AuthController@register');

    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    //$router->post('users', 'UserController@store');
    $router->put('users/{id}', 'UserController@update');
    $router->patch('users/{id}', 'UserController@updateStatus');
    $router->delete('users/{id}', 'UserController@delete');  
    $router->get('usersbyappid', 'UserController@getUsersByAppId');

});