<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, x-xsrf-token');
header('Access-Control-Allow-Credentials: true');


$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\V1\AuthenticateController@authenticate');
    $api->post('register', 'App\Http\Controllers\V1\AuthenticateController@register');
    $api->get('verification', 'App\Http\Controllers\V1\AuthenticateController@verified');

});
//['middleware' => 'jwt.auth']

$api->version('v1', function ($api) {
    // Routes that require authentication.
    $api->get('users', 'App\Http\Controllers\V1\UserController@show');
    $api->post('users/{id}', 'App\Http\Controllers\V1\UserController@getUserById');
    $api->put('users/{id}', 'App\Http\Controllers\V1\UserController@update');
    $api->delete('users/{id}', 'App\Http\Controllers\V1\UserController@delete');
    $api->post('users', 'App\Http\Controllers\V1\UserController@create');
    $api->get('usersGroups/{id}', 'App\Http\Controllers\V1\UserController@getUserGroups');

    $api->post('addUserToGroup', 'App\Http\Controllers\V1\UserController@addUserToGroup');
    $api->post('deleteUserFromGroup', 'App\Http\Controllers\V1\UserController@deleteUserFromGroup');

    $api->get('groups', 'App\Http\Controllers\V1\GroupController@show');
    $api->put('groups/{id}', 'App\Http\Controllers\V1\GroupController@update');
    $api->post('deleteGroup', 'App\Http\Controllers\V1\GroupController@delete');
    $api->post('groups', 'App\Http\Controllers\V1\GroupController@create');

});

