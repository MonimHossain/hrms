<?php

use Illuminate\Database\Seeder;

class ProcessTableSeeder extends Seeder
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
        DB::table('processes')->truncate();
        // generate
        DB::table('processes')->insert([
            [
                'department_id' => 7,
                'name' => 'All',
            ],
            [
                'department_id' => 7,
                'name' => 'Akash',
            ],
            [
                'department_id' => 7,
                'name' => 'Banglalink',
            ],
            [
                'department_id' => 7,
                'name' => 'BAT',
            ],
            [
                'department_id' => 7,
                'name' => 'Beximco',
            ],
            [
                'department_id' => 7,
                'name' => 'CPP',
            ],
            [
                'department_id' => 7,
                'name' => 'DIGI',
            ],
            [
                'department_id' => 7,
                'name' => 'Foodpanda',
            ],
            [
                'department_id' => 7,
                'name' => 'Genex Academy',
            ],
            [
                'department_id' => 7,
                'name' => 'Genex Solutions',
            ],
            [
                'department_id' => 7,
                'name' => 'GP',
            ],
            [
                'department_id' => 7,
                'name' => 'IBBL',
            ],
            [
                'department_id' => 7,
                'name' => 'NIC',
            ],
            [
                'department_id' => 7,
                'name' => 'Robi',
            ],
            [
                'department_id' => 7,
                'name' => 'Samsung',
            ],
            [
                'department_id' => 7,
                'name' => 'Uber',
            ],
        ]);
    }
}
