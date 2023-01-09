<?php

use Illuminate\Database\Seeder;

class EmployeeJourneyTableSeeder extends Seeder
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
        DB::table('employee_journeys')->truncate();
        // generate 50 users
        factory(App\EmployeeJourney::class, 50)->create();
        factory(App\EmployeeJourneyArchive::class, 50)->create();
    }
}
