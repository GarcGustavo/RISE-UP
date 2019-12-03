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
         ['o_content'=>'None','o_parameter'=>1, 'is_default' => true],
         ['o_content'=>'This year','o_parameter'=>1, 'is_default' => true],
		 ['o_content'=>'This month','o_parameter'=>1, 'is_default' => true],
		 ['o_content'=>'This week','o_parameter'=>1, 'is_default' => true],
		 ['o_content'=>'Today','o_parameter'=>1, 'is_default' => true],
		 ['o_content'=>'Placeholder','o_parameter'=>1, 'is_default' => true],

        //options for damage type
        ['o_content'=>'None','o_parameter'=>2, 'is_default' => true],
        ['o_content'=>'Hurricane','o_parameter'=>2, 'is_default' => true],
        ['o_content'=>'Flooding','o_parameter'=>2, 'is_default' => true],
        ['o_content'=>'Earthquake','o_parameter'=>2, 'is_default' => true],
		['o_content'=>'Coast Erosion','o_parameter'=>2, 'is_default' => true],

        //options for infrastructure
        ['o_content'=>'None','o_parameter'=>3, 'is_default' => true],

        ['o_content'=>'Hurricane','o_parameter'=>3, 'is_default' => true],
        ['o_content'=>'Flooding','o_parameter'=>3, 'is_default' => true],
        ['o_content'=>'Earthquake','o_parameter'=>3, 'is_default' => true],
       
        ['o_content'=>'Concrete Home','o_parameter'=>3, 'is_default' => true],
        ['o_content'=>'Wood Home','o_parameter'=>3, 'is_default' => true],
        ['o_content'=>'Public Building','o_parameter'=>3, 'is_default' => true],
        ['o_content'=>'Private Building','o_parameter'=>3, 'is_default' => true],

       //options for language
	   ['o_content'=>'None','o_parameter'=>4, 'is_default' => true],
       ['o_content'=>'English','o_parameter'=>4, 'is_default' => true],
       ['o_content'=>'Spanish','o_parameter'=>4, 'is_default' => true],

        //options for location
        ['o_content'=>'None','o_parameter'=>5, 'is_default' => true],
        ['o_content'=>'Dorado, PR','o_parameter'=>5, 'is_default' => true],
        ['o_content'=>'Mayaguez, PR','o_parameter'=>5, 'is_default' => true],
        ['o_content'=>'Fajardo, PR','o_parameter'=>5, 'is_default' => true],
        ['o_content'=>'Ponce, PR','o_parameter'=>5, 'is_default' => true]
    ];

        App\Models\Option::insert($options);
    }
}
