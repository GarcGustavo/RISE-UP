
<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\case_study;
use Faker\Generator as Faker;
$factory->define(case_study::class, function (Faker $faker) {
    return [
        'c_title' => $faker->word,
        'c_description' => $faker->text($maxNbChars = 255),
        'c_thumbnail' => $faker->word,
        'c_status' => $faker->word,
        'c_date' => $faker->date,
        'c_owner' => $faker->numberBetween($min=1, $max=25),
       //'c_owner' => $faker->numberBetween($min=1, $max=3),
        'c_group' => $faker->numberBetween($min=1, $max=10)
    ];
});
