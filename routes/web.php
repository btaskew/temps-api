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

$router->post('/signup', 'UsersController@store');
$router->post('/login', 'UsersController@login');
$router->post('/logout', 'UsersController@logout');

$router->get('/jobs', 'JobsController@index');
$router->get('/jobs/{job}', 'JobsController@show');

$router->get('/profiles/{user}/jobs', 'ProfilesController@showJobs');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('/jobs', ['middleware' => 'staff', 'uses' => 'JobsController@store']);

    $router->post('/jobs/apply/{job}', 'ApplicationsController@store');
});