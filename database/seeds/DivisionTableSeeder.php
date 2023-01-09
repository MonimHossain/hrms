<?php

use Illuminate\Database\Seeder;

class DivisionTableSeeder extends Seeder
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
        DB::table('divisions')->truncate();

        DB::table('divisions')->insert([
            [
                'name' => 'Genex Infosys Ltd.',
            ]
        ]);
    }
}
