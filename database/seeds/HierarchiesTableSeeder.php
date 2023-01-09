<?php

use Illuminate\Database\Seeder;

class HierarchiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('hierarchies')->truncate();
        DB::table('hierarchies')->insert([
            [
                'parent_id' => 0,
                'employee_id' => 1,
            ]
        ]);
        factory(App\Hierarchy::class, 10)->create();
    }
}
