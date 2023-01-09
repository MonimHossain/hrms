<?php

namespace App\Imports;

use App\Designation;
use App\Employee;
use App\EmployeeDivisionCenter;
use App\EmployeeJourney;
use App\EmployeeJourneyArchive;
use App\EmploymentType;
use App\Events\UserLoginEvent;
use App\JobRole;
use App\User;
use App\Utils\EmploymentTypeStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Validator;

// class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
class EmployeesImport implements OnEachRow, WithHeadingRow
{
    use Importable;
    public $dataset, $designations, $jobRoles, $employmentTypes;

    public function __construct()
    {
        $this->designations = Designation::all();
        $this->jobRoles = JobRole::all();
        $this->employmentTypes = EmploymentType::all();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        Validator::make($row, [
            'employee_id' => 'required|unique:employees,employer_id',
            'name' => 'required',
            'office_email' => 'nullable|email',
            'gender' => 'required|in:Male,Female',
            'doj' => 'required|date',
            'contract_end_date' => 'nullable|date',
            'designation' => 'required|exists:designations,name',
            'job_role' => 'required|exists:job_roles,name',
            'employment_type' => 'required|exists:employment_types,type',
            ],

            [

                'employee_id.required'   => 'Employee_id is required',
                'employee_id.unique'   =>  'Employee_id: '.$row['employee_id'].' already exists',
                'name.required'   => 'Name is required for employee id: ' . $row['employee_id'],
                'office_email.email'   => 'Office_email is invalid for employee id: ' . $row['employee_id'],
                'gender.in' => 'Gender field is invalid or has spelling mistake for employee id: '. $row['employee_id'].' (Ex:Male/Female)',
                'doj.required'   => 'Date of join (DOJ) is required for employee id: ' . $row['employee_id']. ' / Or invalid date formate',
                'contract_end_date.required'   => 'Contract_end_date is invalid date formate for employee id: ' . $row['employee_id'],
                'designation.exists' => 'Designation field is invalid or has spelling mistake for employee id: '. $row['employee_id'],
                'job_role.exists' => 'Job_role field is invalid or has spelling mistake for employee id: '. $row['employee_id'],
                'employment_type.exists' => 'Employment_type field is invalid or has spelling mistake for employee id: '. $row['employee_id'],

            ]
        )->validate();

        // dd($row);
        $designations = $this->designations;
        $jobRoles = $this->jobRoles;
        $employmentTypes = $this->employmentTypes;                
        $data['employer_id'] = rtrim($row['employee_id']);
        $data['first_name'] = $this->split_name(rtrim($row['name']))[0];
        $data['last_name'] = $this->split_name(rtrim($row['name']))[1];
        $data['email'] = ((rtrim($row['office_email'])) == '' || (rtrim($row['office_email'])) == 'NA' || (rtrim($row['office_email'])) == '-') ? null : rtrim($row['office_email']);
        $data['gender'] = (rtrim($row['gender']) == 'Male' || rtrim($row['gender']) == 'Female') ? rtrim($row['gender']) : null;
        $data['ssc_reg_num'] = ((rtrim($row['ssc_reg_num'])) == '' || (rtrim($row['ssc_reg_num'])) == 'NA' || (rtrim($row['ssc_reg_num'])) == '-' || (rtrim($row['ssc_reg_num'])) == ' ') ? null : rtrim($row['ssc_reg_num']);
        $data['pool_phone_number'] = ((rtrim($row['pool_phone'])) == '' || (rtrim($row['pool_phone'])) == 'NA' || (rtrim($row['pool_phone'])) == '-' || (rtrim($row['pool_phone'])) == 'Not Eligible') ? null : rtrim($row['pool_phone']);
        $data['contact_number'] = ((rtrim($row['personal_phone_number'])) == '' || (rtrim($row['personal_phone_number'])) == 'NA' || (rtrim($row['personal_phone_number'])) == '-' || (rtrim($row['personal_phone_number'])) == 'Not Eligible') ? null : rtrim($row['personal_phone_number']);
        $data['doj'] = ((rtrim($row['doj'])) == '' || (rtrim($row['doj'])) == 'NA' || (rtrim($row['doj'])) == '-' || (rtrim($row['doj'])) == ' ') ? null : Carbon::parse(rtrim($row['doj']))->format('Y-m-d');


        // if($data['last_name'] == '' || $data['last_name'] == ' '){
        //     dd($data);
        // }

        $data['designation_id'] = $designations->filter(function ($designation, $key) use ($row) {
            return $designation->name == rtrim($row['designation']);
        })->first()->id;

        $data['job_role_id'] = $jobRoles->filter(function ($jobRole, $key) use ($row) {
            return $jobRole->name == rtrim($row['job_role']);
        })->first()->id;
        $data['employment_type_id'] = $employmentTypes->filter(function ($employmentType, $key) use ($row) {
            return $employmentType->type == rtrim($row['employment_type']);
        })->first()->id;
        if($data['employment_type_id'] != EmploymentTypeStatus::PERMANENT && $data['employment_type_id'] != EmploymentTypeStatus::PROBATION){
            $data['contract_start_date'] = $data['doj'];
            $data['contract_end_date'] = (($row['contract_end_date']) == '' || ($row['contract_end_date']) == 'NA' || ($row['contract_end_date']) == '-' || ($row['contract_end_date']) == ' ') ? null : Carbon::parse($row['contract_end_date'])->format('Y-m-d');
        } elseif ($data['employment_type_id'] == EmploymentTypeStatus::PROBATION){
            $data['probation_start_date'] = $data['doj'];
        } elseif ($data['employment_type_id'] == EmploymentTypeStatus::PERMANENT){
            $data['permanent_doj'] = $data['doj'];
        }
        $data['employee_status_id'] = 1; //active
        $data['created_by'] = auth()->user()->employee_id;
        $data['updated_by'] = auth()->user()->employee_id;

        // dd(request()->get('center_id'));
        // dd($data);

        Validator::make($data, [
            'employer_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|in:Male,Female',
            'doj' => 'required|date_format:Y-m-d',
            'designation_id' => 'required',
            'job_role_id' => 'required',
            'employment_type_id' => 'required',
            'employee_status_id' => 'required',
            'probation_start_date' => 'nullable|date_format:Y-m-d',
            'permanent_doj' => 'nullable|date_format:Y-m-d',
            'contract_start_date' => 'nullable|date_format:Y-m-d',
            'contract_end_date' => 'nullable|date_format:Y-m-d',
        ])->validate();


        $employee = Employee::create($data);


        if($employee->id){
            // insert employee journey table
            $employee->employeeJourney()->save(new EmployeeJourney($data));
            // insert employee journey archive table
            $employee->employeeJourneyArchive()->save(new EmployeeJourneyArchive($data));

            // set center division of employee
            $employee->divisionCenters()->save(new EmployeeDivisionCenter([
                'division_id' => request()->get('division_id'),
                'center_id' => request()->get('center_id')
            ]));

            // create user login
            $user = new User();
            $user->employee_id = $employee->id;
            $user->email = (($data['email']) == ' ' || ($data['email']) == 'NA' || ($data['email']) == '-') ? null : $data['email'];
            $user->employer_id = $data['employer_id'];
            $user->password = bcrypt('Genex@123');
            $user->status =$data['employee_status_id'];

            if ($user->save()) {
                // assign role to the user
                $user->assignRole('User');

                // send welcome mail to new employee
                //$mailData['name'] = $user->employeeDetails->FullName;
                //$mailData['employer_id'] = $event->employee_id;
                //$mailData['email'] = $event->email;
                //$mailData['password'] = 'Genex@123';
                //if($event->email){
                //    Mail::to($event->email)->send(new WelcomeMail($mailData));
                //}

            } else {
                toastr()->error('An error has occurred. Please try with correct information.');
            }
        }

    }


    public function headingRow(): int
    {
        return 1;
    }


    // users first name and last name split
    function split_name($name)
    {
        $name = trim($name);
        $parts = explode(" ", $name);
        if (count($parts) > 1) {
            $lastname = array_pop($parts);
            $firstname = implode(" ", $parts);
        } else {
            $firstname = $name;
            $lastname = "-";
        }
        return array($firstname, $lastname);
    }
}
