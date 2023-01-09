<?php

namespace App\Http\Controllers\Admin\Report;

use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Division;
use App\Center;
use App\Designation;
use App\NearbyLocation;
use App\Institute;
use App\Process;
use App\ProcessSegment;
use App\JobRole;
use App\LevelOfEducation;
use App\Department;
use App\EmploymentType;
use App\EmployeeStatus;
use App\BloodGroup;
use App\EmployeeFixedOfficeTime;
use App\Roster;
use App\LeaveType;
use DB;
use App\Jobs\SendProfileCompletionEmailJob;
use App\Leave;
use App\Team;
use App\Utils\AttendanceStatus;
use App\Utils\LeaveStatus;
use Carbon\Carbon;
use Validator;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->baseURL = 'https://my.genexinfosys.com';
    }

    public function missingDataReport(Request $request){
        $active = 'employeeMissingReport';
        $all_employees = Employee::all();
        $emoloyees = Employee::query();
        $jobRoles  = JobRole::all();
        $paginate = 10;
        $employeeData = [];
        $missing = [];
        $required_fields = [];
        $employee = [];

        if($request->fields){
            if($request->employment_type){
                $emoloyees->whereHas('employeeJourney', function($q) use($request){
                    $q->where('employment_type_id', $request->employment_type);
                });
            }

            if($request->employee_role){
                $emoloyees->whereHas('employeeJourney', function($q) use($request){
                    $q->where('job_role_id', $request->employee_role);
                });
            }

            if(in_array('doj', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('doj');
                });
            }
            if(in_array('contractual_start_date', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('contract_start_date');
                });
            }
            if(in_array('contractual_end_date', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('contract_end_date');
                });
            }
            if(in_array('probation_start_date', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('probation_start_date');
                });
            }
            if(in_array('probation_period', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('probation_period');
                });
            }
            if(in_array('permanent_doj', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('permanent_doj');
                });
            }
            if(in_array('new_role_doj', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('new_role_doj');
                });
            }

            if(in_array('religion', $request->fields)){
                $emoloyees->whereNull('religion');
            }
            if(in_array('location', $request->fields)){
                $emoloyees->whereNull('nearby_location_id');
            }
            if(in_array('designation', $request->fields)){
                $emoloyees->whereHas('employeeJourney', function($q){
                    $q->whereNull('designation_id');
                });
            }
            if(in_array('personal_email', $request->fields)){
                $emoloyees->whereNull('personal_email');
            }
            if(in_array('company_email', $request->fields)){
                $emoloyees->whereNull('email');
            }
            if(in_array('pool_phone', $request->fields)){
                $emoloyees->whereNull('pool_phone_number');
            }
            if(in_array('personal_phone', $request->fields)){
                $emoloyees->whereNull('contact_number');
            }
            if(in_array('dob', $request->fields)){
                $emoloyees->whereNull('date_of_birth');
            }
            if(in_array('emergency_contact', $request->fields)){
                $emoloyees->whereNull('emergency_contact_person_number');
            }
            if(in_array('bood_group', $request->fields)){
                $emoloyees->whereNull('blood_group_id');
            }
            $emoloyees->whereHas('divisionCenters', function($q){
                $q->where('division_id', Division::where('name', session()->get('division'))->first()->id);
                $q->where('center_id', Center::where('center', session()->get('center'))->first()->id);
            });
            $employeeData = $emoloyees->paginate($paginate);
            // dd($employeeData);
        } else {
            if($request->employee_id){
                $missing = [];
                $employee = Employee::withoutGlobalScopes()->find($request->employee_id);
                if ($employee->blood_group_id == null) array_push($missing, 'Blood Group');
                array_push($required_fields, 'Blood Group');
                if ($employee->first_name == null) array_push($missing, 'First Name');
                array_push($required_fields, 'First Name');
                if ($employee->last_name == null) array_push($missing, 'Last Name');
                array_push($required_fields, 'Last Name');
                if ($employee->personal_email == null) array_push($missing, 'Personal Email');
                array_push($required_fields, 'Personal Email');
                if ($employee->gender == null) array_push($missing, 'Gender');
                array_push($required_fields, 'Gender');
                if ($employee->date_of_birth == null) array_push($missing, 'DOB');
                array_push($required_fields, 'DOB');
                if ($employee->religion == null) array_push($missing, 'Religion');
                array_push($required_fields, 'Religion');
                if ($employee->ssc_reg_num == null || $employee->nid == null || $employee->passport == null) array_push($missing, 'SSC Reg Number');
                array_push($required_fields, 'SSC Reg Number');
                if ($employee->father_name == null) array_push($missing, 'Father Name');
                array_push($required_fields, 'Father Name');
                if ($employee->mother_name == null) array_push($missing, 'Mother Name');
                array_push($required_fields, 'Mother Name');
                if ($employee->present_address == null) array_push($missing, 'Present Address');
                array_push($required_fields, 'Present Address');
                if ($employee->permanent_address == null) array_push($missing, 'Permanent Address');
                array_push($required_fields, 'Permanent Address');
                if ($employee->contact_number == null) array_push($missing, 'Contact Number');
                array_push($required_fields, 'Contact Number');
                if ($employee->marital_status == null) array_push($missing, 'Marital Status');
                array_push($required_fields, 'Marital Status');
                if ($employee->educations()->count()) array_push($missing, 'Education Data');
                array_push($required_fields, 'Education Data');





                // $emoloyees->where('id', $request->employee_id);
                // dd($missing);
                // dd($missing);
            }
        }
        return view('admin.report.missing-data-report', compact('active', 'employeeData', 'all_employees', 'missing', 'employee', 'required_fields', 'jobRoles'));
    }

    public function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    public function nowAtOffice(Request $request)
    {
        $report_data = [];
        $active = 'now-at-office';

        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $divisions = Division::all();
        $centers = Center::all();
        $departments = Department::all();
        $filters = [];
        if ($request->all()) {
            $filters = $request->all();
        }
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        $genders = array(
            'Male' => 'Male',
            'Female' => 'Female',
        );
        $bloodGroups = BloodGroup::all();
        $employee_religions = array_filter(Employee::groupBy('religion')->pluck('religion')->toArray());
        


        $departmentRequest = $request->input('department_id');
        $processRequest = $request->input('process_id');
        $processSegmentRequest = $request->input('process_segment');
        $employmentTypeRequest = $request->input('employment_type');
        $designationRequest = $request->input('designation');
        $employeeStatusesRequest = $request->input('employee_status');
        $divisionRequest = $request->input('division');
        $centerRequest = $request->input('center');
        $genderRequest = $request->input('gender');
        $bloodGroupRequest = $request->input('blood_group');
        $filter_type = $request->input('filter_type');
        $religionRequest = $request->input('religion');

        $shift = $request->input('shift');
        $employee_id = $request->input('employee_id');
        $employees = Employee::select('id', 'first_name', 'last_name', 'employer_id')
            ->when($employee_id, function ($query) use ($employee_id) {
                return $query->where('id', $employee_id);
            })
            ->when($departmentRequest, function ($query) use ($departmentRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($departmentRequest) {
                    return $query->where('department_id', $departmentRequest);
                });
            })
            ->when($processRequest, function ($query) use ($processRequest) {
                $query->whereHas('departmentProcess', function ($query) use ($processRequest) {
                    return $query->where('process_id', $processRequest);
                });
            })
            ->when($shift, function ($query) use ($shift) {
                $query->whereHas('attendances', function ($query) use ($shift) {
                    return $query->whereTime('roster_start', $shift);
                });
            })
            ->when($genderRequest, function ($query) use ($genderRequest) {
                return $query->where('gender', $genderRequest);
            })
            ->when($religionRequest, function ($query) use ($religionRequest) {
                return $query->where('religion', $religionRequest);
            })
            ->when($bloodGroupRequest, function ($query) use ($bloodGroupRequest) {
                return $query->where('blood_group_id', $bloodGroupRequest);
            })
            ->when($employmentTypeRequest, function ($query) use ($employmentTypeRequest) {
                $query->whereHas('employeeJourney', function ($query) use ($employmentTypeRequest) {
                    return $query->where('employment_type_id', $employmentTypeRequest);
                });
            })
            ->when($designationRequest, function ($query) use ($designationRequest) {
                $query->whereHas('employeeJourney', function ($query) use ($designationRequest) {
                    return $query->where('designation_id', $designationRequest);
                });
            })
            ->orderBy('first_name', 'asc')->pluck('id')->toArray();

        // dd($employees);


        $date = date('Y-m-d');   
        $day = date('l');
        $attendance = $this->callApi("GET", $this->baseURL."/api.php?dailyAttendanceLive=true&date=".$date, NULL);
        $attendance = json_decode($attendance);
        if(isset($attendance->data)){
            $attendance = $attendance->data;
        } else {
            $attendance = [];
        }
        $total_attended = [];

        if(isset($attendance)){    

            foreach($attendance as $attendance_data){

                if( in_array($attendance_data->employee_hrms_id, $employees) && ($attendance_data->checkCount % 2 == 1)){
                    $employee_id = $attendance_data->employee_hrms_id;
                    $employee = Employee::withoutGlobalScopes()->where('id', $attendance_data->employee_hrms_id)->first();
                    $punch_in = $attendance_data->punch_in;
                    $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();                
                    $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee_id)->first(); 
                    $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();
                    
                    if($fixedRoster) {                    
                        
                        $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                        $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));
                        if ($punch_in) {
                            if ($fixedRoster->is_offday == 1) {
                                $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                            } else {
                                $roster_entry_time = strtotime($startTime);
                                $punch_in_time = strtotime($punch_in);
                                $late = round(($punch_in_time - $roster_entry_time) / 60, 2);
                                
                                $status = AttendanceStatus::PRESENT;
                                if($leaveCheck && in_array($date, json_decode($leaveCheck->leave_days))){
                                    $status = $leaveCheck->leave_type_id;
                                } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 30){
                                    $status = AttendanceStatus::LATE;
                                } else if($late > 10) {
                                    $status = AttendanceStatus::LATE;
                                } else {
                                    $status = AttendanceStatus::PRESENT;
                                }
                            }
                        } else {                            
                            if($leaveCheck && in_array($date, json_decode($leaveCheck->leave_days))){
                                $status = $leaveCheck->leave_type_id;
                            } else if ($fixedRoster->is_offday == 1){
                                $status = AttendanceStatus::DAYOFF;
                            } else {
                                $status = AttendanceStatus::ABSENT;
                            }
                        }                        
                        $attendance_info = array(
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'punch_in' => $attendance_data->punch_in,
                            'first_checkin' => $attendance_data->first_checkin,
                            'employee_id' => $attendance_data->employee_hrms_id,
                            'employer_id' => $employee->employer_id,
                            'name' => $attendance_data->name,
                            'location' => $attendance_data->first_checkin,
                            'status' => $status,
                            'employee' => $employee
                        );
                        array_push($report_data, $attendance_info);
                    } else {
                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else {
                            $status = AttendanceStatus::PRESENT;
                        }
                        $startTime = 'No roster';
                        $bendTime = 'No roster';

                        $dataArray = array(
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'punch_in' => $attendance_data->punch_in,
                            'first_checkin' => '',
                            'employee_id' => $employee->id,
                            'employer_id' => $employee->employer_id,
                            'name' => $employee->first_name ." ". $employee->last_name,
                            'location' => $attendance_data->first_checkin,
                            'status' => $status,
                            'employee' => $employee
                        );
                        array_push($report_data, $dataArray);
                    }
                }
            }                       
        }
        
        // dd($report_data);
        
        $attendances = [];

        return view('admin.report.now-at-office', compact('active', 'attendances', 'report_data', 'processes', 'processSegments', 'divisions', 'centers', 'departments', 'filters', 'designations', 'jobRoles', 'educationLevels', 'employmentTypes', 'employeeStatuses', 'genders', 'bloodGroups', 'employee_religions'));
    }
    
    public function accountCompletion(Request $request){
        $active = 'account-completion-report';
        $employeeDataChart = [
            ['', ''],
        ];

        $employeeData = Employee::withoutGlobalScopes()->select(DB::raw('count(*) as completed, profile_completion'))->whereHas('employeeJourney', function($q) use ($request){
            $q->where('employee_status_id', 1);
        })->groupby('profile_completion')->orderby('profile_completion')->get();
        // dd($employeeData);
        foreach($employeeData as $row){
            $data = array(
                0 => $row->profile_completion,
                1 => $row->completed
            );
            array_push($employeeDataChart, $data);

        }
        // dd($employeeDataChart);
        return view('admin.report.account-completion-report', compact('active', 'employeeData', 'employeeDataChart'));
    }

    public function accountCompletionDetails(Request $request, $id){
        $active = 'account-completion-report';
        $all_employees = Employee::all();
        $designations = Designation::all();
        $employees = Employee::where('profile_completion', $id);
        // dd($employees->count());

        $employees->whereHas('employeeJourney', function($q) use ($request){
            $q->where('employee_status_id', 1);
        });

        // dd($request->fields);
        if($request->fields){
            $employees->whereHas('employeeJourney', function($q) use ($request){
                $q->whereIn('designation_id', $request->fields);
            });
        }

        if($request->employmentType){
            $employees->whereHas('employeeJourney', function($q) use ($request){
                $q->where('employment_type_id', $request->employmentType);
            });
        }

        if($request->employee_id){
            $employees->where('id', $request->employee_id);
        }
        $employees = $employees->paginate(10);
        $completion_rate = $id;
        return view('admin.report.account-completion-report-details', compact('employees', 'active', 'completion_rate', 'all_employees', 'designations', 'id'));
    }

    public function employeeDataReport(Request $request){
        $active = 'empoyee-data-report';
        $locations = NearbyLocation::orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $institutes = Institute::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $departments = Department::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        $employeeList = DB::table('employees')->select('id', 'first_name', 'last_name', 'religion')->get();
        $bloodGroups = BloodGroup::all();
        $divisions = Division::all();
        $centers = Center::all();
        $roster = Roster::all();
        $leaveTypes = LeaveType::all();
        $employee_religions = $employeeList->groupBy('religion');
        $all_employees = Employee::all();
        $employees = Employee::query();
        $genders = array(
            'Male' => 'Male',
            'Female' => 'Female',
        );
        // dd($request->fields);
        if($request->designations){
            $employees->whereHas('employeeJourney', function($q) use ($request){
                $q->whereIn('designation_id', $request->designations);
            });
        }
        if($request->employee_id){
            $employees->where('id', $request->employee_id);
        }
        $employees = $employees->whereHas('employeeJourney', function($q) use ($request){
            $q->where('employee_status_id', 1);
        });
        $employees = $employees->withoutGlobalScopes()->paginate(10);
        $completion_rate = 100;
        return view('admin.report.employee-data-report', compact('employees', 'active', 'completion_rate', 'all_employees', 'designations', 'locations', 'institutes', 'processes', 'processSegments', 'designations', 'jobRoles', 'educationLevels', 'departments', 'employmentTypes', 'employeeStatuses', 'employeeList', 'bloodGroups', 'divisions', 'centers', 'roster', 'leaveTypes', 'employee_religions', 'genders'));
    }


    public function accountCompletionEmail($id)
    {
        return view('admin.report.account-completion-report-email', compact('id'));
    }

    public function accountCompletionEmailSend(Request $request ,$id)
    {
        $employees = Employee::where('profile_completion', $id)->whereNotNull('email')->get();
        //$user = [];
        foreach ($employees as $employee){
            //$user[] = $employee;
            dispatch(new SendProfileCompletionEmailJob($employee->email, $request->body));
        }

        //dd($user);

        toastr()->success('Successfully Send');
        return redirect()->route('Admin.Report.account-completion');
    }

}
