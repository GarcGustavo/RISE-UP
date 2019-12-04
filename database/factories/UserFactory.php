<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\user;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    $email = "$first_name.$last_name@upr.edu";
    $contact_email = "$first_name.$last_name@gmail.com";


    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'contact_email' => $contact_email,
        'u_expiration_date' => "2019-12-30",
        'u_creation_date' => Carbon::now()->format('Y-m-d'),
        'u_role_upgrade_request' => $faker->numberBetween($min=0, $max=1),
        'u_ban_status' => $faker->numberBetween($min=0,$max=1),
        'current_edit_cid' =>null,
        'u_role' => $faker->numberBetween($min=1,$max=3)


    ];
});
