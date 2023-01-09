<?php

use Illuminate\Database\Seeder;
use App\Workflow;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('divisions')->truncate();
        DB::table('centers')->truncate();
        DB::table('permissions')->truncate();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //if (App::environment() === 'production') exit();

        $this->call(BloodGroupTableSeeder::class);
        //$this->call(DivisionTableSeeder::class);
        //$this->call(CenterTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(DesignationTableSeeder::class);
        $this->call(EmployeeStatusTableSeeder::class);
        $this->call(EmploymentTypeTableSeeder::class);
        $this->call(JobRoleTableSeeder::class);
        $this->call(InstituteTableSeeder::class);
        $this->call(LevelOfEducationTableSeeder::class);
        $this->call(ProcessTableSeeder::class);
        $this->call(ProcessSegmentTableSeeder::class);
        $this->call(NearbyLocationTableSeeder::class);
        $this->call(LeaveTypeTableSeeder::class);
        $this->call(LeaveBalanceSettingsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        //$this->call(PermissionTableSeeder::class);
        //$this->call(EmployeesTableSeeder::class);
        //$this->call(EmployeeJourneyTableSeeder::class);
        //$this->call(EmployeeDepartmentProcessTableSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(TrainingTableSeeder::class);
        $this->call(HierarchiesTableSeeder::class);
        $this->call(RosterTableSeeder::class);
//        $this->call(WorkflowTableSeeder::class);
//        $this->call(SetLeaveTableSeeder::class);
    }
}
