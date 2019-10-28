<?php

use Illuminate\Database\Seeder;

class CaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Case_Study::class, 50)->create();
    }
}
