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
	
    return $router->app->version();
});

// API route group

/*$router->group(['prefix' => 'api'], function () use ($router) {
  $router->post('login', 'AuthController@login');
});*/

$router->post('login', 'AuthController@login');
$router->get('users', 'UserController@index');

// API route group with middleware

$router->group(['middleware' => 'checkapp'], function() use ($router) {

    $router->post('register', 'AuthController@register');
    $router->get('users/{id}', 'UserController@show');
    $router->put('users/{id}', 'UserController@update');
    $router->patch('users/{id}', 'UserController@updateStatus');
    $router->delete('users/{id}', 'UserController@delete');  
    $router->get('usersbyappid', 'UserController@getUsersByAppId');

});