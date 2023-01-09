<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeaveTypeTableSeeder extends Seeder
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
        DB::table('leave_types')->truncate();
        DB::table('leave_types')->insert([
            [
                'leave_type' => 'Casual',
                'short_code' => 'CL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'leave_type' => 'Sick',
                'short_code' => 'SL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'leave_type' => 'Earned',
                'short_code' => 'EL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'leave_type' => 'Maternity',
                'short_code' => 'ML',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'leave_type' => 'Paternity',
                'short_code' => 'PL',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'leave_type' => 'Leave Without Pay',
                'short_code' => 'LWP',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ]);
    }
}
