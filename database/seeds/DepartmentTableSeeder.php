<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
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
        DB::table('departments')->truncate();
        // generate 3 users
        DB::table('departments')->insert([
            [
                'name' => 'Accounts',
            ],
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Business Development',
            ],
            [
                'name' => 'Business Support',
            ],
            [
                'name' => 'Management',
            ],
            [
                'name' => 'MIS & WFM',
            ],
            [
                'name' => 'Operations',
            ],
            [
                'name' => 'People & Culture',
            ],
            [
                'name' => 'Public Relations',
            ],
            [
                'name' => 'Quality Assurance',
            ],
            [
                'name' => 'Technology',
            ],
            [
                'name' => 'Technology - Automation',
            ],
            [
                'name' => 'Training',
            ],
        ]);
    }
}
