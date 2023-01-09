<?php

namespace App\Helpers;

use App\Department;
use App\Employee;
use App\EmployeeTeam;
use App\Team;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Validator;

class Helper{

    public static function getCurrentUser()
    {
        $id = auth()->user()->employee_id ?? 0;
        return Employee::find($id) ?? [];
    }

    public static function getCurrentTeamLead()
    {
        $id = auth()->user()->employee_id;
        $employeeTeam = EmployeeTeam::where('employee_id', $id)->where('member_type', TeamMemberType::MEMBER)->first()->team_id ?? 0;
        $leadId = Team::where('is_functional', 1)->where('id', $employeeTeam)->first()->team_lead_id ?? 0;
        return Employee::find($leadId) ?? [];
    }

    public static function getCurrentOwnDepartment($user)
    {
        $departmentId = Employee::find($user)->employeeDepartmentProcess[0]->department_id ?? 0;
        return Department::find($departmentId)->own_in_charge_id ?? 0;

    }

    
    /**********************************/ 
    /** CSV Validation start here.... */
    /**********************************/

    // CSV load for header check
    public static function fetchCSVHeader(object $file) : array{
        $path = $file->getRealPath();
        $fileDataLoadArray = file($path); //File Data Load into array
        $headerFatch = trim(array_slice($fileDataLoadArray, 0)[0]); // Fetch header row
        $headerNameSanitize  = strtolower(str_replace(' ', '_', $headerFatch)); // Header row sanitize
        $headerColumnArray = explode(",", $headerNameSanitize);  // Header Column Array
        return $headerColumnArray;
    }

    // CSV Header validation
    public static function validateHeaderRow(array $headerRow, array $givenHeader) : bool
    {
        $validate = false;
        if(count($headerRow) == count($givenHeader) && array_diff($headerRow, $givenHeader) === array_diff($givenHeader, $headerRow))
        {
            $validate = true;
        } 
        if($validate === false){
            toastr()->error('Please correct CSV column! Column\' should be '.strtoupper(implode(", ",str_replace('_', ' ', $givenHeader))));
        }
        return $validate;
    }

    // CSV load for data check
    public static function fetchCSVData(object $file) : array{
        $array = array();
        $path = $file->getRealPath();
        $fileDataLoadArray = file($path); //File Data Load into array
        $dataFatch = array_slice($fileDataLoadArray, 1); // Fetch data rows
        foreach ($dataFatch as $line) {
            $array[] = str_getcsv($line);
        }
        return $array;
    }

    // CSV data validation
    public static function validateDataRow(array $dataRow, array $givenDataType, array $mgs) : bool
    {
        foreach($dataRow as $array){
            $validator = Validator::make($array, $givenDataType, $mgs);
            if ($validator->fails())
            {
                $error = $validator->errors()->first();
                toastr()->error($error);
                return false;
            }
        }
        return true;
    }

    /********************************/
    /** CSV Validation end here.... */
    /********************************/

}
