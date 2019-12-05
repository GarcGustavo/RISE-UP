<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Case_Parameters;
use Faker\Generator as Faker;

$factory->define(Case_Parameters::class, function (Faker $faker) {

    return [
        'opt_selected' => 1,
        'csp_id' => $faker->unique()->numberBetween($min=1, $max=5),
        'cid' => 1
    ];
});
