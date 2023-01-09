<?php

use Illuminate\Database\Seeder;

class EmployeeDepartmentProcessTableSeeder extends Seeder
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
        DB::table('employee_department_processes')->truncate();
        $employees = \App\Employee::all();
        $data = [];
        foreach ($employees as $employee){
            $process_id = rand(1, \App\Process::count());
            $process_segment_id = rand(1, \App\ProcessSegment::where('process_id', $process_id)->count());
            $data[] = [
                'employee_id' => $employee->id,
                'process_id' => $process_id,
                'process_segment_id' => $process_segment_id,
                'department_id' => rand(1, \App\Department::count())
            ];
        }
        DB::table('employee_department_processes')->insert($data);
    }
}
