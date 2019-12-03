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

        [
         ['o_content'=>'This year','o_parameter'=>1],
		 ['o_content'=>'This month','o_parameter'=>1],
		 ['o_content'=>'This week','o_parameter'=>1],
		 ['o_content'=>'Today','o_parameter'=>1],
		 ['o_content'=>'Placeholder','o_parameter'=>1],

        //options for damage type

        ['o_content'=>'Hurricane','o_parameter'=>2],
        ['o_content'=>'Flooding','o_parameter'=>2],
        ['o_content'=>'Earthquake','o_parameter'=>2],
		['o_content'=>'Coast Erosion','o_parameter'=>2],

        //options for infrastructure


        ['o_content'=>'Hurricane','o_parameter'=>3],
        ['o_content'=>'Flooding','o_parameter'=>3],
        ['o_content'=>'Earthquake','o_parameter'=>3],

        ['o_content'=>'Concrete Home','o_parameter'=>3],
        ['o_content'=>'Wood Home','o_parameter'=>3],
        ['o_content'=>'Public Building','o_parameter'=>3],
        ['o_content'=>'Private Building','o_parameter'=>3],

       //options for language

       ['o_content'=>'English','o_parameter'=>4],
       ['o_content'=>'Spanish','o_parameter'=>4],

        //options for location
        ['o_content'=>'Dorado, PR','o_parameter'=>5],
        ['o_content'=>'Mayaguez, PR','o_parameter'=>5],
        ['o_content'=>'Fajardo, PR','o_parameter'=>5],
        ['o_content'=>'Ponce, PR','o_parameter'=>5]];

        App\Models\Option::insert($options);
    }
}
