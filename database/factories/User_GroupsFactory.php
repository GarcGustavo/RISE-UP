
<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\user_groups;
use Faker\Generator as Faker;
$factory->define(user_groups::class, function (Faker $faker) {
    return [
        'uid' => $faker->numberBetween($min=1, $max=25),
      //  'uid' => $faker->numberBetween($min=1, $max=3),
        'gid' => $faker->numberBetween($min=1, $max=10)
    ];
});
