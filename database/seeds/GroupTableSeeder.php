<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // factory(App\Models\group::class, 50)->create();
       factory(App\Models\group::class, 10)->create();
    }
}
