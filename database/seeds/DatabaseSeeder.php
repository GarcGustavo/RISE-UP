<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(User_GroupsTableSeeder::class);
        $this->call(CaseTableSeeder::class);
        $this->call(Item_TypeTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(CS_ParameterTableSeeder::class);
        $this->call(OptionTableSeeder::class);
        $this->call(Case_ParametersTableSeeder::class);

    }
}
