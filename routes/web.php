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
    $user = factory('App\User')->create();
    $worker = $user->worker()->create();
    return $worker->user->getAttributes();
});

$router->post('/signup/staff', 'StaffController@store');
$router->post('/signup/worker', 'WorkersController@store');
$router->post('/login', 'UsersController@login');
$router->post('/logout', 'UsersController@logout');

$router->get('/jobs', 'JobsController@index');
$router->get('/jobs/{job}', 'JobsController@show');

$router->get('/profiles/{staff}/jobs', 'ProfilesController@showJobs');

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->group(['middleware' => 'staff'], function () use ($router) {
        $router->post('/jobs', 'JobsController@store');
        $router->delete('/jobs/{job}', 'JobsController@destroy');
    });

    $router->post('/jobs/apply/{job}',
        ['middleware' => 'worker', 'uses' => 'ApplicationsController@store']
    );
});