<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Action_Type;
use Faker\Generator as Faker;

$factory->define(Action_Type::class, function (Faker $faker) {

    return [
        'act_name' => $faker->word
    ];
});
