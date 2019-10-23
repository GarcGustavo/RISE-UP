<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item_Type;
use Faker\Generator as Faker;

$factory->define(Item_Type::class, function (Faker $faker) {

    return [
        'itt_name' => $faker->word
    ];
});
