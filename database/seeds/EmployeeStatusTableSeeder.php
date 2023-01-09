<?php

use Illuminate\Database\Seeder;

class EmployeeStatusTableSeeder extends Seeder
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
        DB::table('employee_statuses')->truncate();
        // generate 3 users
        DB::table('employee_statuses')->insert([
            [
                'status' => 'Active',
            ],
            [
                'status' => 'Inactive',
            ],
            [
                'status' => 'Suspended',
            ],
        ]);
    }
}
