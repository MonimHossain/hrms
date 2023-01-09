<?php

use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
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
        DB::table('designations')->truncate();
        // generate 3 users
        DB::table('designations')->insert([
            [
                'name' => 'Account Manager',
            ],
            [
                'name' => 'Assistant General Manager',
            ],
            [
                'name' => 'Assistant Manager',
            ],
            [
                'name' => 'CEO',
            ],
            [
                'name' => 'COO',
            ],
            [
                'name' => 'CSO',
            ],
            [
                'name' => 'Deputy General Manager',
            ],
            [
                'name' => 'Deputy Manager',
            ],
            [
                'name' => 'Executive',
            ],
            [
                'name' => 'General Manager',
            ],
            [
                'name' => 'Manager',
            ],
            [
                'name' => 'Managing Director',
            ],
            [
                'name' => 'Senior Executive',
            ],
            [
                'name' => 'Specialist',
            ],
            [
                'name' => 'Sr. CSO',
            ],
            [
                'name' => 'Sr. Executive/Digital Content Creator',
            ],
            [
                'name' => 'Sr. Manager',
            ],
            [
                'name' => 'Vice President',
            ],
            [
                'name' => 'Sr. Vice President',
            ],
        ]);
    }
}
