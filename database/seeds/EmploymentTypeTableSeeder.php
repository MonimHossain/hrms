<?php

use Illuminate\Database\Seeder;

class EmploymentTypeTableSeeder extends Seeder
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
        DB::table('employment_types')->truncate();
        // generate 3 users
        DB::table('employment_types')->insert([
            [
                'type' => 'Hourly',
            ],
            [
                'type' => 'Contractual',
            ],
            [
                'type' => 'Probation',
            ],
            [
                'type' => 'Permanent',
            ],

        ]);
    }
}
