<?php

use Illuminate\Database\Seeder;

class WorkflowTableSeeder extends Seeder
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
        DB::table('workflows')->truncate();
        // generate 3 users
        DB::table('workflows')->insert([
            [
                'parent_id' => '0',
                'name' => 'Workflow'
            ],
            [
                'parent_id' => '1',
                'name' => 'Center One'
            ],
            [
                'parent_id' => '2',
                'name' => 'Leave'
            ],
            [
                'parent_id' => '2',
                'name' => 'Recusition'
            ],
            [
                'parent_id' => '2',
                'name' => 'Recruitment'
            ]
        ]);
    }
}
