<?php

use Illuminate\Database\Seeder;

class Action_TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $action_types =
        [['act_id'=>1, 'act_name'=>'Created case study'],
        ['act_id'=>2, 'act_name'=>'Updated case study'],
        ['act_id'=>3, 'act_name'=>'Deleted case study']
    ];
        App\Models\action_type::insert($action_types);
    }
}
