<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Action;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {

    return [
        'a_date' => $faker->date,
        'a_user' => $faker->randomDigitNotNull,
        'a_type' => $faker->randomDigitNotNull
    ];
});
