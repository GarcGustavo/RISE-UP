<?php

use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $options =
        //option for incident date
        [['o_content'=>'Placeholder','o_parameter'=>1],

        //options for damage type
        ['o_content'=>'Hurricane','o_parameter'=>2],
        ['o_content'=>'Flooding','o_parameter'=>2],
        ['o_content'=>'Earthquake','o_parameter'=>2],

        //options for infrastructure
        ['o_content'=>'Hurricane','o_parameter'=>3],
        ['o_content'=>'Flooding','o_parameter'=>3],
        ['o_content'=>'Earthquake','o_parameter'=>3],

       //options for language
       ['o_content'=>'English','o_parameter'=>3],
       ['o_content'=>'Spanish','o_parameter'=>3],

        //options for location
        ['o_content'=>'Dorado, PR','o_parameter'=>5],
        ['o_content'=>'Mayaguez, PR','o_parameter'=>5],
        ['o_content'=>'Fajardo, PR','o_parameter'=>5],
        ['o_content'=>'Ponce, PR','o_parameter'=>5]];

        App\Models\Option::insert($options);
    }
}
