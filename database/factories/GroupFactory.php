
<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\group;
use Faker\Generator as Faker;
$factory->define(group::class, function (Faker $faker) {
    return [
        'g_name' => $faker->word,
        'g_status' => $faker->word,
        'g_creation_date' => $faker->date,
        'g_owner' => $faker->numberBetween($min=1, $max=25)
     //  'g_owner' => $faker->numberBetween($min=1, $max=3)
    ];


});
