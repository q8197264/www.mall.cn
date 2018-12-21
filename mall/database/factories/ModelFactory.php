<?php
use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
    static $password;

    return [
        'uname' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('admin'),
        'remember_token' => str_random(10),
    ];
});