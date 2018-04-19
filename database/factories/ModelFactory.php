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
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $faker->word,
        'role_id' => $faker->numberBetween(0, 1)
    ];
});

$factory->define(App\ActiveUser::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull,
        'token' => $faker->word
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'role' => $faker->word
    ];
});