<?php

use Illuminate\Database\Seeder;

class ActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		//factory(App\Models\action::class, 25)->create();
		
		DB::table('action')->insert([
			'a_date'=> now(),
			'a_user'=> 12,
			'a_type'=>  2,
		]);
		
    }
}
