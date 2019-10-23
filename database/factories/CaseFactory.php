<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Case;
use Faker\Generator as Faker;

$factory->define(Case::class, function (Faker $faker) {

    return [
        'c_title' => $faker->word,
        'c_description' => $faker->word,
        'c_thumbnail' => $faker->word,
        'c_status' => $faker->word,
        'c_date' => $faker->word,
        'c_owner' => $faker->randomDigitNotNull,
        'c_group' => $faker->randomDigitNotNull
    ];
});
