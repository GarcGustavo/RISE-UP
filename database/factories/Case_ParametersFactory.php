<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Case_Parameters;
use Faker\Generator as Faker;

$factory->define(Case_Parameters::class, function (Faker $faker) {

    return [
        'opt_selected' => $faker->word,
        'csp_id' => $faker->randomDigitNotNull
    ];
});
