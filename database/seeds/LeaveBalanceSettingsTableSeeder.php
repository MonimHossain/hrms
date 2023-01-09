<?php

use Illuminate\Database\Seeder;

class LeaveBalanceSettingsTableSeeder extends Seeder
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
        DB::table('leave_balance_settings')->truncate();

        DB::table('leave_balance_settings')->insert([
//            for hourly employee
            [
                'leave_type_id' => 6,
                'quantity' => 0,
                'employment_type_id' => 1
            ],

//            for Contractual employee
            [
                'leave_type_id' => 6,
                'quantity' => 0,
                'employment_type_id' => 2
            ],

//            for probation employee
            [
                'leave_type_id' => 1,
                'quantity' => 10,
                'employment_type_id' => 3
            ],
            [
                'leave_type_id' => 2,
                'quantity' => 14,
                'employment_type_id' => 3
            ],
            [
                'leave_type_id' => 3,
                'quantity' => 16,
                'employment_type_id' => 3
            ],
            [
                'leave_type_id' => 6,
                'quantity' => 0,
                'employment_type_id' => 3
            ],

//            for permanent employee
            [
                'leave_type_id' => 1,
                'quantity' => 10,
                'employment_type_id' => 4
            ],
            [
                'leave_type_id' => 2,
                'quantity' => 14,
                'employment_type_id' => 4
            ],
            [
                'leave_type_id' => 3,
                'quantity' => 16,
                'employment_type_id' => 4
            ],
            [
                'leave_type_id' => 4,
                'quantity' => 240,
                'employment_type_id' => 4
            ],
            [
                'leave_type_id' => 5,
                'quantity' => 6,
                'employment_type_id' => 4
            ],
            [
                'leave_type_id' => 6,
                'quantity' => 0,
                'employment_type_id' => 4
            ],
        ]);
    }
}
