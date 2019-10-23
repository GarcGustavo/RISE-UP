<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {

    return [
        'g_name' => $faker->word,
        'g_status' => $faker->word,
        'g_creation_date' => $faker->word,
        'g_owner' => $faker->randomDigitNotNull
    ];
});
