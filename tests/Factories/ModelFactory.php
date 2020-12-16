<?php

namespace Mjedari\Larafilter\Factories;

use Faker\Generator as Faker;
use Mjedari\Larafilter\Tests\Models\User;

$factory->define(User::class, function (Faker $faker) {
//    dd(3%3 === 0);
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $faker->name,
    ];
});
