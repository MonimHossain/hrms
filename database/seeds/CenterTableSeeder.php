<?php

use Illuminate\Database\Seeder;

class CenterTableSeeder extends Seeder
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
        DB::table('centers')->truncate();
        DB::table('centers')->insert([
            [
                'division_id' => 1,
                'center' => 'Dhaka',
            ],
            [
                'division_id' => 1,
                'center' => 'Chittagong',
            ],
        ]);
    }
}
