
<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\role;
use Faker\Generator as Faker;
<<<<<<< HEAD
$factory->define(role::class, function (Faker $faker) {
    return [
        'r_name' => $faker->word,
        'r_creation_date' => $faker->date
=======

$factory->define(role::class, function (Faker $faker) {
    return [
        'r_creation_date' => $faker->date,
        'r_name' => $faker->word
>>>>>>> Gustavo
    ];
});
