<?php

use Illuminate\Database\Seeder;

class BloodGroupTableSeeder extends Seeder
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
        DB::table('blood_groups')->truncate();
        // generate 3 users
        DB::table('blood_groups')->insert([
            [
                'name' => 'A+',
            ],
            [
                'name' => 'A-',
            ],
            [
                'name' => 'B+',
            ],
            [
                'name' => 'B-',
            ],
            [
                'name' => 'AB+',
            ],
            [
                'name' => 'AB-',
            ],
            [
                'name' => 'O+',
            ],
            [
                'name' => 'O-',
            ],
        ]);
    }
}
