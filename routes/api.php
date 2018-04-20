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
    // Use for testing
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

        $router->get('/jobs/{job}/applications', 'JobsApplicationsController@index');
        $router->get('/jobs/{job}/applications/{application}', 'JobsApplicationsController@show');
        $router->post('/jobs/{job}/applications/{application}/approve', 'ApprovedApplicationsController@store');
    });

    $router->group(['middleware' => 'worker'], function () use ($router) {
        $router->post('/jobs/{job}/apply', 'WorkersApplicationsController@store');

        $router->get('/profiles/applications', 'WorkersApplicationsController@index');
        $router->get('/profiles/applications/{application}', 'WorkersApplicationsController@show');
    });
});