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
        $cs_parameters = [
            ['csp_id'=>1,'csp_name'=>'Incident date', 'is_default' => true],
            ['csp_id'=>2,'csp_name'=>'Damage type', 'is_default' => true],
            ['csp_id'=>3,'csp_name'=>'Infrastructure type', 'is_default' => true],
            ['csp_id'=>4,'csp_name'=>'Language', 'is_default' => true],
            ['csp_id'=>5,'csp_name'=>'Location', 'is_default' => true]
    ];
        App\Models\CS_Parameter::insert($cs_parameters);
    }
}
