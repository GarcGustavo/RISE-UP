<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {

    return [
        'o_content' => $faker->word,
        'o_parameter' => $faker->numberBetween($min=1, $max=4)
    ];
});
