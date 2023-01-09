<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
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
        DB::table('users')->truncate();
        // generate 3 users
        DB::table('users')->insert([
            [
                'email' => 'admin@genexinfosys.com',
                'password' => bcrypt('12345678'),
                'must_change_password' => 0
            ],
        ]);
    }
}
