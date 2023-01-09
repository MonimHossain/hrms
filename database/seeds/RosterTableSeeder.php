<?php

use Illuminate\Database\Seeder;

class RosterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the Roster table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('rosters')->truncate();

        DB::table('rosters')->insert([
            [
                'Title' => 'R1',
                'roster_start' => '06:00:00',
                'roster_end' => '14:00:00',
            ],
            [
                'Title' => 'R2',
                'roster_start' => '06:30:00',
                'roster_end' => '14:30:00',
            ],
            [
                'Title' => 'R3',
                'roster_start' => '07:00:00',
                'roster_end' => '15:00:00',
            ],
            [
                'Title' => 'R4',
                'roster_start' => '08:00:00',
                'roster_end' => '16:00:00',
            ],
            [
                'Title' => 'R5',
                'roster_start' => '08:30:00',
                'roster_end' => '16:30:00',
            ],
            [
                'Title' => 'R6',
                'roster_start' => '09:00:00',
                'roster_end' => '17:00:00',
            ],
            [
                'Title' => 'R7',
                'roster_start' => '09:30:00',
                'roster_end' => '17:30:00',
            ],
            [
                'Title' => 'R8',
                'roster_start' => '10:00:00',
                'roster_end' => '18:00:00',
            ],
            [
                'Title' => 'R9',
                'roster_start' => '10:30:00',
                'roster_end' => '18:30:00',
            ],
            [
                'Title' => 'R10',
                'roster_start' => '11:00:00',
                'roster_end' => '19:00:00',
            ],
            [
                'Title' => 'R11',
                'roster_start' => '18:00:00',
                'roster_end' => '00:00:00',
            ],
            [
                'Title' => 'R12',
                'roster_start' => '20:00:00',
                'roster_end' => '02:00:00',
            ],
            [
                'Title' => 'R13',
                'roster_start' => '22:00:00',
                'roster_end' => '07:00:00',
            ],
            [
                'Title' => 'R14',
                'roster_start' => '23:00:00',
                'roster_end' => '05:00:00',
            ],
        ]);
    }
}
