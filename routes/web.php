<?php

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


$router->group(['prefix' => 'api'], function () use ($router) {
  $router->post('users', ['uses' => 'UserController@create']);
  $router->put('users/{id}', ['uses' => 'UserController@update']);
  $router->delete('users/{id}', ['uses' => 'UserController@delete']);
  $router->get('users',  ['uses' => 'UserController@showAllUsers']);


  $router->post('teams', ['uses' => 'TeamController@create']);
  $router->put('teams/assign-owner/{id}', ['uses' => 'TeamController@assignOwner']);
  $router->put('teams/assignUsersToTeam/{id}', ['uses' => 'TeamController@assignUsersToTeam']);
});