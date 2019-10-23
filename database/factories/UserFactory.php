<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {

    return [
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'email' => $faker->word,
        'contact_email' => $faker->word,
        'u_creation_date' => $faker->word,
        'u_ban_status' => $faker->word,
        'current_edit_cid' => $faker->randomDigitNotNull,
        'u_role' => $faker->randomDigitNotNull
    ];
});
