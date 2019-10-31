<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\item_type;
use Faker\Generator as Faker;

$factory->define(item_type::class, function (Faker $faker) {

    return [
        'itt_name' => $faker->word
    ];
});
