<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User_Groups;
use Faker\Generator as Faker;

$factory->define(User_Groups::class, function (Faker $faker) {

    return [
        'uid' => $faker->randomDigitNotNull
    ];
});
