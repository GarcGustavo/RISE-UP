<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\user::class, 25)->create();
      // factory(App\Models\user::class, 3)->create();
    }
}
