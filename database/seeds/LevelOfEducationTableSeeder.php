<?php

use Illuminate\Database\Seeder;

class LevelOfEducationTableSeeder extends Seeder
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
        DB::table('level_of_education')->truncate();
        // generate 3 users
        DB::table('level_of_education')->insert([
            [
                'name' => 'PSC/5 pass',
            ],
            [
                'name' => 'JSC/JDC/8 pass',
            ],
            [
                'name' => 'SSC',
            ],
            [
                'name' => 'HSC',
            ],
            [
                'name' => 'Diploma',
            ],
            [
                'name' => 'Bachelor/Honors',
            ],
            [
                'name' => 'Masters',
            ],
            [
                'name' => 'PhD (Doctor of Philosophy)',
            ],
        ]);
    }
}
