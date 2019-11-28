<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [['rid'=>1,'r_name'=>'Visitor'],
        ['rid'=>2,'r_name'=>'Viewer'],
        ['rid'=>3,'r_name'=>'Collaborator'],
        ['rid'=>4,'r_name'=>'Admin']];

        App\Models\role::insert($roles);
    }
}
