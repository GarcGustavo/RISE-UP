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
       // factory(App\Models\case_study::class, 30)->create();
       factory(App\Models\case_study::class, 10)->create();
    }
}
