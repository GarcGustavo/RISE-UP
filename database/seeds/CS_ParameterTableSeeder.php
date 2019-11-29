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
        $cs_parameters = [['csp_id'=>1,'csp_name'=>'Incident date'],
        ['csp_id'=>2,'csp_name'=>'Damage type'],
        ['csp_id'=>3,'csp_name'=>'Infrastructure type'],
        ['csp_id'=>4,'csp_name'=>'Language'],
        ['csp_id'=>5,'csp_name'=>'Location']
    ];
        App\Models\CS_Parameter::insert($cs_parameters);
    }
}
