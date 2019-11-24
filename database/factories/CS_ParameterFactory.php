<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CS_Parameter;
use Faker\Generator as Faker;

$factory->define(CS_Parameter::class, function (Faker $faker) {

    return [
        'csp_name' => $faker->word
    ];
});
