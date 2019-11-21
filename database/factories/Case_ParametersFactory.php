<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Case_Parameters;
use Faker\Generator as Faker;

$factory->define(Case_Parameters::class, function (Faker $faker) {

    return [
        'opt_selected' => $faker->numberBetween($min=1, $max=50),
        'csp_id' => $faker->numberBetween($min=1, $max=50),
        'cid' => $faker->numberBetween($min=1, $max=50)
    ];
});
