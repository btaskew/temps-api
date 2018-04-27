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

$router->get('/stats', 'StatsController@index');

$router->post('/signup/staff', 'StaffController@store');
$router->post('/signup/worker', 'WorkersController@store');
$router->post('/login', 'UsersController@login');
$router->post('/logout', 'UsersController@logout');

$router->get('/jobs', 'JobsController@index');
$router->get('/jobs/{job}', 'JobsController@show');

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->group(['middleware' => 'staff'], function () use ($router) {
        $router->post('/jobs', 'JobsController@store');
        $router->patch('/jobs/{job}', 'JobsController@update');
        $router->delete('/jobs/{job}', 'JobsController@destroy');

        $router->get('/jobs/{job}/applications', 'JobsApplicationsController@index');
        $router->get('/jobs/{job}/applications/{application}', 'JobsApplicationsController@show');
        $router->post('/jobs/{job}/applications/{application}/respond', 'ApplicationResponseController@store');
    });

    $router->group(['middleware' => 'worker'], function () use ($router) {
        $router->post('/jobs/{job}/apply', 'WorkersApplicationsController@store');

        $router->get('/profile/applications', 'WorkersApplicationsController@index');
        $router->get('/profile/applications/{application}', 'WorkersApplicationsController@show');

        $router->get('/profile/education', 'EducationController@index');
        $router->get('/profile/education/{education}', 'EducationController@show');
        $router->post('/profile/education', 'EducationController@store');
        $router->patch('/profile/education/{education}', 'EducationController@update');
        $router->delete('/profile/education/{education}', 'EducationController@destroy');

        $router->get('/profile/experience', 'ExperienceController@index');
        $router->get('/profile/experience/{experience}', 'ExperienceController@show');
        $router->post('/profile/experience', 'ExperienceController@store');
        $router->patch('/profile/experience/{experience}', 'ExperienceController@update');
        $router->delete('/profile/experience/{experience}', 'ExperienceController@destroy');

        $router->get('/profile/{worker}', 'WorkersController@show');
        $router->patch('/profile/{worker}', 'WorkersController@update');
    });

});