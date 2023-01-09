<?php

use Illuminate\Database\Seeder;
use App\User;

class EmployeesTableSeeder extends Seeder
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
        DB::table('employees')->truncate();
        // generate 50 users
        factory(App\Employee::class, 50)->create();

        User::find(1)->assignRole('Super Admin');
    }
}
