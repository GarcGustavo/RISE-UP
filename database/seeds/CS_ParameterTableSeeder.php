<?php

use Illuminate\Database\Seeder;

class CS_ParameterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CS_Parameter::class, 5)->create();
    }
}
