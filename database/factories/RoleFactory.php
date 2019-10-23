<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {

    return [
        'r_name' => $faker->word,
        'r_creation_date' => $faker->word
    ];
});
