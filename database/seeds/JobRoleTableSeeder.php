<?php

use Illuminate\Database\Seeder;

class JobRoleTableSeeder extends Seeder
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
        DB::table('job_roles')->truncate();
        // generate 3 users
        DB::table('job_roles')->insert([
            [
                'name' => 'Account Manager',
            ],
            [
                'name' => 'Agent',
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
                'name' => 'Deputy General Manager',
            ],
            [
                'name' => 'Deputy Manager',
            ],
            [
                'name' => 'Digital Content Creator',
            ],
            [
                'name' => 'Executive',
            ],
            [
                'name' => 'General Manager',
            ],
            [
                'name' => 'Head of People & Culture',
            ],
            [
                'name' => 'Manager',
            ],
            [
                'name' => 'Managing Director',
            ],
            [
                'name' => 'Quality Evaluator',
            ],
            [
                'name' => 'SDL',
            ],
            [
                'name' => 'Senior Executive',
            ],
            [
                'name' => 'Specialist',
            ],
            [
                'name' => 'Sr. Manager',
            ],
            [
                'name' => 'Team Leader',
            ],
            [
                'name' => 'Team Manager',
            ],
            [
                'name' => 'Trainer',
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
