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
        $item_types = [['itt_id'=>1, 'itt_name'=>'text'],
        ['itt_id'=>2, 'itt_name'=>'images']
    ];

        App\Models\item_type::insert($item_types);
    }
}
