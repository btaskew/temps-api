<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Job::class, function (Faker\Generator $faker) {
    return [
        'staff_id' => function() {
            return factory('App\Staff')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'closing_date' => \Carbon\Carbon::tomorrow(),
        'open_vacancies' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $faker->word
    ];
});

$factory->define(App\Staff::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
    ];
});

$factory->define(App\Worker::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
    ];
});

$factory->define(App\ActiveUser::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull,
        'token' => $faker->word
    ];
});

$factory->define(App\Application::class, function (Faker\Generator $faker) {
    return [
        'worker_id' => function() {
            return factory('App\Worker')->create()->id;
        },
        'job_id' => function() {
            return factory('App\Job')->create()->id;
        },
    ];
});

$factory->define(App\ApplicationResponse::class, function (Faker\Generator $faker) {
    return [
        'application_id' => function() {
            return factory('App\Application')->create()->id;
        },
        'type' => 'rejected',
        'comment' => $faker->text()
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag' => $faker->word,
        'job_id' => function() {
            return factory('App\Job')->create()->id;
        },
    ];
});