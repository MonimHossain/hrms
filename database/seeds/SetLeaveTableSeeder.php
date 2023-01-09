<?php

use Illuminate\Database\Seeder;

class SetLeaveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        // generate 3 users

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('set_leaves')->truncate();
        DB::table('set_leaves')->insert([
            [
                'name' => 'Casual',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 10,
                'probation_quantity' => 10
            ],[
                'name' => 'Sick',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 14,
                'probation_quantity' => 14
            ],[
                'name' => 'Earned',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 16,
                'probation_quantity' => 16
            ],[
                'name' => 'Maternity',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 120,
                'probation_quantity' => 0
            ],[
                'name' => 'Paternity',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 3,
                'probation_quantity' => 0
            ],[
                'name' => 'LWP',
                'hourly_quantity' => 0,
                'contractual_quantity' => 0,
                'parmanent_quantity' => 0,
                'probation_quantity' => 0
            ]
        ]);
    }
}
