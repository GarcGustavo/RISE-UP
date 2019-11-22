<?php

use Illuminate\Database\Seeder;

class Case_ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Case_Parameters::class, 5)->create();
    }
}
