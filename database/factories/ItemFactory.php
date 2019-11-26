<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\item;
use Faker\Generator as Faker;

$factory->define(item::class, function (Faker $faker) {

    return [
        'i_content' => $faker->text,
        'i_case' => $faker->numberBetween($min=1, $max=10),
        'i_type' => $faker->numberBetween($min=1, $max=50),
        'i_name' => $faker->firstName
    ];
});
