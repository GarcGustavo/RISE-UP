<?php

use Illuminate\Database\Seeder;

class Item_TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\item_type::class, 50)->create();
    }
}
