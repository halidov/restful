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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'login' => $faker->userName,
        'password' => bcrypt('pass'),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'waiter', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['login'=>'waiter', 'is_waiter' => 1, 'admin_id' => 1]);
});

$factory->defineAs(App\User::class, 'client', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['login'=>'client', 'is_client' => 1, 'admin_id' => 1]);
});

$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['login' => 'admin', 'admin' => TRUE]);
});

$factory->defineAs(App\User::class, 'admin2', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['login' => 'admin2', 'admin' => TRUE]);
});

