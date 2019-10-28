<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\user;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(user::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'contact_email' => $faker->unique()->safeEmail,
        'u_creation_date' => $faker->date,
        'u_ban_status' => $faker->numberBetween($min=0,$max=1),
        'current_edit_cid' =>'',
        'u_role' => $faker->numberBetween($min=1,$max=4)


    ];
});
