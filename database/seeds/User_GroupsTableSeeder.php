<?php

use Illuminate\Database\Seeder;

class User_GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\user_groups::class, 50)->create();
    }
}
