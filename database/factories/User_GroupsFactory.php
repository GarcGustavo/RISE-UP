
<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\user_groups;
use Faker\Generator as Faker;
$factory->define(user_groups::class, function (Faker $faker) {
    return [
<<<<<<< HEAD
        'uid' => $faker->numberBetween($min=1, $max=25),
        'gid' => $faker->numberBetween($min=1, $max=10)

=======
        'uid' => $faker->numberBetween($min=1, $max=50),
        'gid' => $faker->numberBetween($min=1, $max=10)
>>>>>>> Gustavo
    ];
});
