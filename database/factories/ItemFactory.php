<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {

    return [
        'i_content' => $faker->text,
        'i_case' => $faker->randomDigitNotNull,
        'i_type' => $faker->randomDigitNotNull
    ];
});
