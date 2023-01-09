<?php

namespace App\Http\Controllers\User;

use App\Center;
use App\Division;
use App\EmployeeDivisionCenter;
use App\LeaveBalanceSetting;
use App\Rules\MatchOldPassword;
use App\Services\EarnLeaveService;
use App\Services\LeaveService;
use App\Services\ProfileCompletionService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Image;
use Storage;
use File;
use Validator;
use App\Employee;
use App\NearbyLocation;
use App\Institute;
use App\BloodGroup;
use App\Process;
use App\ProcessSegment;
use App\Designation;
use App\JobRole;
use App\LevelOfEducation;
use App\Department;
use App\EmploymentType;
use App\EmployeeStatus;
use Illuminate\Support\Facades\DB;
use App\Education;
use App\Training;
use App\EmployeeJourney;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Charts\AdminChart;
use App\Utils\NoticeAndEvent;
use App\EventNotice;
use App\LeaveBalance;
use App\Utils\AttendanceStatus;
use App\Attendance;
use App\EarnLeave;
use App\EmployeeFixedOfficeTime;
use App\Leave;
use App\Utils\EmploymentTypeStatus;
use App\Utils\LeaveStatus;
use App\Utils\Payroll;

class UserHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseURL = "https://my.genexinfosys.com";
        $this->middleware('auth');
    }

    public function AuthRouteAPI(Request $request){
        return $request->user();
    }

    // login as admin or login as user
    public function loginAsAdmin(Request $request){

        $validateRole = $request->session()->get('validateRole');
        if(Auth::user()->hasAnyRole(['Super Admin|Admin']) && $validateRole == 'User'){
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
            ]);

            if ($validator->fails()) {
                toastr()->error('An error has occurred. Password must be Minimum 8 charecters.');
                return redirect()->back();
            }

            if (Hash::check($request->input('password'), Auth::user()->password)){
                $request->session()->put('validateRole', 'Admin');
                if (auth()->user()->default_division_id && auth()->user()->default_center_id){
                    $division = Division::whereId(auth()->user()->default_division_id)->first();
                    $center = Center::whereId(auth()->user()->default_center_id)->first();
                    if($division && $center){
                        $request->session()->put('division', $division->name);
                        $request->session()->put('center', $center->center);
                    }
                    toastr()->success('Welcome to admin panel!');
                }
                return redirect()->route('dashboard');
            }else{
                toastr()->error('Password does not match');
                return redirect()->back();
            }
        }
        elseif(Auth::user()->hasRole('User') && $validateRole == 'Admin'){

            $request->session()->put('validateRole', 'User');
            //dd(request()->session()->get('validateRole'));
            $request->session()->forget(['division', 'center']);
            $center_division = EmployeeDivisionCenter::where('employee_id', auth()->user()->employee_id)->first();
            $division = Division::whereId($center_division->division_id)->first();
            $center = Center::whereId($center_division->center_id)->first();
            if($division && $center){
                $request->session()->put('division', $division->name);
                $request->session()->put('center', $center->center);
            }
            toastr()->success('Welcome to user panel!');
            return redirect()->route('user.dashboard');
        }else{
            toastr()->error('Something is wrong. Your credentials might be incorrect.');
            return redirect()->back();
        }
    }

    public function index(){
        $active = 'user';

        // for reset earn leaves
        // $earnLeaves = EarnLeave::all();
        // foreach($earnLeaves as $earnLeave){
        //     if($earnLeave->forwarded_balance > 16){
        //         $earnLeave->forwarded_balance = 16;
        //         $earnLeave->total_balance = $earnLeave->forwarded_balance + $earnLeave->earn_balance;
        //         $earnLeave->save();
        //     }else{
        //         $earnLeave->save();
        //     }
        // }
        // dd($earnLeaves);


        $employee = Auth::user()->employeeDetails;
        return view('user.dashboard', compact('active', 'employee'));
    }

    public function profile_progress($employee_id){
        $complete = 0;
        $total = 15;
        $employee = Employee::find($employee_id);
        if ($employee->blood_group_id != null) $complete += 1;
        if ($employee->first_name != null) $complete += 1;
        if ($employee->last_name != null) $complete += 1;
        if ($employee->personal_email != null) $complete += 1;
        if ($employee->gender != null) $complete += 1;
        if ($employee->date_of_birth != null) $complete += 1;
        if ($employee->religion != null) $complete += 1;
        if ($employee->ssc_reg_num != null || $employee->nid != null || $employee->passport != null) $complete += 1;
        if ($employee->father_name != null) $complete += 1;
        if ($employee->mother_name != null) $complete += 1;
        if ($employee->present_address != null) $complete += 1;
        if ($employee->permanent_address != null) $complete += 1;
        if ($employee->contact_number != null) $complete += 1;
        if ($employee->marital_status != null) $complete += 1;
        if ($employee->educations()->count()) $complete += 1;

         return ($complete / $total) * 100;
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
        // if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    private function getIp(){
        $externalContent = file_get_contents('http://checkip.dyndns.com/');
        preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
        $externalIp = $m[1];
        return $externalIp;
    }

    public function attendanceCheckinOut(Request $request){
        $ip = $this->getIp();
        // die($this->baseURL."/api.php?inOut=true&employee_id=". auth()->user()->employer_id ."&ip=". $ip ."&details=&lat=". $request->lat ."&lon=" . $request->lon);
        if($request->lat != null && $request->lon != null){
            $attendance = $this->callApi("GET", $this->baseURL."/api.php?inOut=true&employee_id=". auth()->user()->employer_id ."&ip=". $ip ."&details=&lat=". $request->lat ."&lon=" . $request->lon, "");
            $attendance = json_decode($attendance);
            if(isset($attendance->success) && $attendance->success == true){
                toastr()->success('Attendance status updated successfully.');
            } else {
                toastr()->success('Something went wrong. please try again');
            }
        } else {
            toastr()->warning('Your location access is blocked, please enable browser location access and try again');
        }
        return redirect()->route('user.dashboard');
    }

    public function dashboard()
    {
        //$callback = function($query)
        //{
        //    $query->where('short_code', 'CL');
        //};
        //$leaveBalanceSettings = LeaveBalanceSetting::whereHas('leaveType', $callback)->with(['leaveType' => $callback])->get();
        //$leaveService = new LeaveService(auth()->user()->employeeDetails);
        //dd($leaveService->leaveBalanceCalculate(16));
        //dd($leaveService->getEligibleDate());

        $employee               =   auth()->user()->employeeDetails;
        $total_early_leave      =   0;

        $notices =  (new NoticeEventControllers)->getUpcomingFilterDataForNoticeEvent()->filter(function ($item){
            return $item->status === NoticeAndEvent::SHOWSTATUS['PUBLISH'] && $item->is_event === 0;
        })->sortByDesc('id')->take(5);

        $events =  (new NoticeEventControllers)->getUpcomingFilterDataForNoticeEvent()->filter(function ($item){
            return $item->status === NoticeAndEvent::SHOWSTATUS['PUBLISH'] && $item->is_event === 1;
        })->sortByDesc('id')->take(5);

        $total_office = 0;
        $total_present = 0;
        $total_absent = 0;
        $total_late_entry = 0;
        $total_early_leave = 0;
        $missing_exit = 0;
        $half_day = 0;

        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $rosters = Attendance::where('employee_id', auth()->user()->employee_id)->whereYear('date', $year)->whereMonth('date', $month)->where('date' , '<', Carbon::now()->format('Y-m-d 00:00:00'))->get();

        if ($rosters->isNotEmpty()){
        foreach ($rosters as $item){
            $total_office++;
            if ($item->status == \App\Utils\AttendanceStatus::PRESENT){
                if (!($item->punch_in && $item->punch_out)) {
                $missing_exit++;
                }
                $total_present++;
            } elseif($item->status == \App\Utils\AttendanceStatus::LATE) {
                $total_late_entry++;
                if (!($item->punch_in && $item->punch_out)) {
                    $missing_exit++;
                }
            }else {
                    if ($item->status == \App\Utils\AttendanceStatus::ABSENT) {
                    $total_absent++;
                    }
                    else if ($item->status == \App\Utils\AttendanceStatus::DAYOFF) {
                    //
                    }
                    elseif ((strtotime($item->work_hours) < strtotime('7:30:00')) && (strtotime($item->work_hours) >
                        strtotime('4:30:00'))) {
                        $half_day++;
                        }
                    else{
                    //
                    }
            }
            }
        }
        $total_present = $total_present + $total_late_entry;

        // dd($total_late_entry);


        $leave_raw              =   LeaveBalance::where('employee_id', auth()->user()->employee_id)->where('year', date("Y"))->where('employment_type_id', $employee->employeeJourney->employment_type_id);
        $leave                  =   $leave_raw->get();
        //$earned_leave         =   $leave_raw->where('leave_type_id', AttendanceStatus::EARNED_LEAVE)->first();
        $earned_leave           =   (new EarnLeaveService($employee))->calculateEarnLeaveBalance();
        $leave_balance          =   0;

        $pf_balance             =   0;
        $emi_amount             =   0;
        $percentage = $employee->profile_completion;
        // dd(Payroll::SALARYDETAILS['PF']);

        $missing_data = [];
        //$employee = Employee::find(auth()->user()->employee_id);
        // dd($employee);
        if ($employee->blood_group_id == null) array_push($missing_data, 'Blood Group');
        if ($employee->first_name == null) array_push($missing_data, 'First Name');
        if ($employee->last_name == null) array_push($missing_data, 'Last Name');
        if ($employee->personal_email == null) array_push($missing_data, 'Personal Email');
        if ($employee->gender == null) array_push($missing_data, 'Gender');
        if ($employee->date_of_birth == null) array_push($missing_data, 'DOB');
        if ($employee->religion == null) array_push($missing_data, 'Religion');
        if ($employee->ssc_reg_num == null || $employee->nid == null || $employee->passport == null) array_push($missing_data, 'SSC Reg. No');
        if ($employee->father_name == null) array_push($missing_data, 'Father Name');
        if ($employee->mother_name == null) array_push($missing_data, 'Mother Name');
        if ($employee->present_address == null) array_push($missing_data, 'Present Address');
        if ($employee->permanent_address == null) array_push($missing_data, 'Permanent Address');
        if ($employee->contact_number == null) array_push($missing_data, 'Contact Number');
        if ($employee->marital_status == null) array_push($missing_data, 'Marital Status');
        if ($employee->educations()->count()) array_push($missing_data, 'Education Info');
        // dd($missing_data);

        $attendance_status = $this->callApi("GET", $this->baseURL."/api.php?status=true&employee_id=". auth()->user()->employer_id, "");
        $attendance_status = json_decode($attendance_status);

        $attendance_data    =   $this->callApi("GET", $this->baseURL."/api.php?inOutReport=true&employee_id=". auth()->user()->employer_id, "");
        $attendance_data    =   json_decode($attendance_data);
        $date               =   '"'.date('Y-m-d').'"';
        if($attendance_data && isset($attendance_data->data)){
            $attendance_data    =   (array) $attendance_data->data;
        } else {
            $attendance_data    =   [];
        }
        $inTime             =   isset(array_values($attendance_data)[0]) ? array_values($attendance_data)[0][0]->start : null;
        if( isset($attendance_status) && ($attendance_status->count % 2) == 0){
            $outTime        =   isset(array_values($attendance_data)[0]) ? array_values($attendance_data)[0][0]->end : null;
        } else {
            $outTime        =   null;
        }

        return view('user.user-dashboard', compact('attendance_status','inTime', 'outTime', 'total_present', 'total_absent', 'half_day', 'events', 'notices', 'pf_balance', 'emi_amount', 'earned_leave','leave', 'total_absent', 'total_late_entry', 'total_early_leave', 'percentage', 'missing_data'));
    }

    public function userDetails(){
        $active = 'user';
        $employee = Auth::user()->employeeDetails;
        //session(['user-profile-active' => 'profile-details']);
        request()->session()->flash('user-profile-active', 'profile-details');
        return view('user.user-profile.user-details', compact('active', 'employee'));
    }
    public function changePasswordView(){
        $active = 'user';
        $employee = Auth::user()->employeeDetails;
        //session(['user-profile-active' => 'change-password']);
        request()->session()->flash('user-profile-active', 'change-password');
        return view('user.user-profile.user-change-password', compact('active', 'employee'));
    }

    public function changePassword(Request $request){
        //$request->validate([
        //    'current_password' => ['required', new MatchOldPassword()],
        //    'new_password' => ['required'],
        //    'new_confirm_password' => ['same:new_password'],
        //]);
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            request()->session()->flash('user-profile-active', 'change-password');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        toastr()->success('Password updated successfully.');
        return redirect()->route('user.home');
    }

    // user profile picture upload
    public function propicUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return false;
        }

        if($request->hasFile('profile_pic')) {

            $employee = Employee::find(Auth::user()->employeeDetails->id);

            if($employee->profile_image && file_exists(storage_path('app/public/employee/img/'.$employee->profile_image)) && file_exists(storage_path('app/public/employee/img/thumbnail/'.$employee->profile_image))){
                unlink(storage_path('app/public/employee/img/'.$employee->profile_image));
                unlink(storage_path('app/public/employee/img/thumbnail/'.$employee->profile_image));
            }

            //get filename with extension
            $filenamewithextension = $request->file('profile_pic')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('profile_pic')->getClientOriginalExtension();

            //filename to store
            $filenametostore = Auth::user()->employeeDetails->employer_id.'_'.time().'.'.$extension;


            //Upload File
            // $request->file('profile_pic')->storeAs('public/employee/img/', $filenametostore);
            // $request->file('profile_pic')->storeAs('public/employee/img/thumbnail', $filenametostore);

            // create folder
            $mainPath = public_path('storage/employee/img');
            $thumbPath = public_path('storage/employee/img/thumbnail');
            File::isDirectory($mainPath) or File::makeDirectory($mainPath, 0777, true, true);
            File::isDirectory($thumbPath) or File::makeDirectory($thumbPath, 0777, true, true);

            $originalImage= $request->file('profile_pic');
            //Resize image here
            $imagepath = public_path('storage/employee/img/'.$filenametostore);
            $thumbnailpath = public_path('storage/employee/img/thumbnail/'.$filenametostore);
            $image = Image::make($originalImage);
            $image->resize(900, 900, function($constraint) {
                $constraint->aspectRatio();
            });
            $image->fit(800);
            $image->save($imagepath);
            $imageThumb = Image::make($originalImage);
            $imageThumb->resize(100, 100, function($constraint) {
                $constraint->aspectRatio();
            });
            $imageThumb->fit(100);
            $imageThumb->save($thumbnailpath);

            $employee->profile_image = $filenametostore;
            $employee->save();

            return $filenametostore;
        }
        return 'Image not uploaded.';
    }


    // user profile update view
    public function updateProfileView(){
        $active = 'updateEmp';
        $centers = Center::all();
        $institutes = Institute::all();
        $bloodGroups = BloodGroup::all();
        $processes = Process::all();
        $processSegments = ProcessSegment::all();
        $designations = Designation::all();
        $jobRoles = JobRole::all();
        $educationLevels = LevelOfEducation::all();
        $departments = Department::all();
        $employmentTypes = EmploymentType::all();
        $employeeStatuses = EmployeeStatus::all();
        $employeeList = DB::table('employees')->select('id', 'first_name', 'last_name')->get();

        $employee = Employee::find(auth()->user()->employeeDetails->id);
        $locations = NearbyLocation::where('center_id', $employee->divisionCenters()->where('is_main', 1)->first()->center_id)->orderBy('nearby', 'asc')->get()->groupBy('center_id');
        $educations = Education::where('employee_id', $employee->id)->get();
        $trainings = Training::where('employee_id', $employee->id)->get();
        $employeeJourney = EmployeeJourney::where('employee_id', $employee->id)->first();

        return view('user/user-profile-update', compact(
            'employee',
            'educations',
            'trainings',
            'locations',
            'centers',
            'educationLevels',
            'institutes',
            'bloodGroups',
            'active',
            'processes',
            'processSegments',
            'designations',
            'jobRoles',
            'departments',
            'employmentTypes',
            'employeeStatuses',
            'employeeList',
            'employeeJourney'
        ));
    }


    public function updateProfileSubmit(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'personal_email' => 'required|email',
            'academic.*.edu_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
            'training.*.training_file' => 'mimes:doc,docx,pdf,jpeg,jpg,png|max:2048',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back();
        }
        // Update data to employee table
        $employees_table = $request->all();
        $employee = Employee::findOrFail($request->input('employee_id'));
        $employee->update($employees_table);
        $employee_id = $employee->id;
        // dd($request->all());
        if($employee_id){
            // // update data to employeeJourney table
            // $employeeJourney_table = EmployeeJourney::whereEmployeeId($request->input('employee_id'))->first();
            // if(!$employeeJourney_table){
            //     $employeeJourney_table = new EmployeeJourney();
            // }
            // // update data to employeeJourneyArchive table
            // if($employeeJourney_table){
            //     // EmployeeJourneyArchive::create($employeeJourney_table->toArray());
            //     // $updatEmployeeJourney = $employeeJourney_table->update($request->all());
            //     $employeeJourney_table->fill($request->all());
            //     $changes = $employeeJourney_table->getDirty();
            //     // $employeeJourney_table->save();
            //     if($changes){
            //         $changes['employee_id'] = $employee_id;
            //         // dd($changes);
            //         EmployeeJourneyArchive::create($changes);
            //     }
            // }

            // update data to education table
            // $academics = [];

            $educations = Education::where('employee_id', $request->input('employee_id'))->get();
            foreach($educations as $item){
                if($item->edu_file){
                    Storage::delete('public/employee/documents/'.$item->edu_file);
                }
                $item->delete();
            }


            if(request('academic')){
                foreach(request('academic') as $academic){
                    if(!is_null($academic['exam_degree_title'])){
                        $educations = new Education();
                        $educations->employee_id = $employee_id;
                        $educations->level_of_education_id = $academic['level_of_education_id'];
                        $educations->institute =  $academic['institute'];
                        $educations->exam_degree_title = $academic['exam_degree_title'];
                        $educations->major = $academic['major'];
                        $educations->result = $academic['result'];
                        $educations->passing_year = $academic['passing_year'];
                        if(isset($academic['edu_file']) && $academic['edu_file']) {
                            //get filename with extension
                            $filenamewithextension = $academic['edu_file']->getClientOriginalName();

                            //get filename without extension
                            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                            //get file extension
                            $extension = $academic['edu_file']->getClientOriginalExtension();

                            //filename to store
                            // $filenametostore = Auth::user()->employeeDetails->employer_id.'_'.time().'.'.$extension;
                            $fileName = Auth::user()->employeeDetails->employer_id.'_'.preg_replace('/\s+/', '_', $educations['exam_degree_title']).'_'.time().'.'.$extension;

                            $upload = $academic['edu_file']->storeAs(
                                'public/employee/documents/', $fileName
                            );
                            if($upload){
                                $educations->edu_file = $fileName;
                            }
                        }
                        if($educations->save()){
                            $check_institute = Institute::where('name', $academic['institute'])->first();
                            if(!$check_institute){
                                Institute::create(['name' => $academic['institute']]);
                            }
                        }
                    }
                }
            }




            // update data to training table
            $trainings = Training::where('employee_id', $request->input('employee_id'))->get();
            foreach($trainings as $item){
                if($item->training_file){
                    Storage::delete('public/employee/documents/'.$item->training_file);
                }
                $item->delete();
            }

            if(request('training')){
                foreach(request('training') as  $training){
                    if(!is_null($training['training_title'])){
                        $trainings = new Training();
                        $trainings->employee_id = $employee_id;
                        $trainings->training_title = $training['training_title'];
                        $trainings->country = $training['country'];
                        $trainings->topics_covered = $training['topics_covered'];
                        $trainings->training_year = $training['training_year'];
                        $trainings->institute = $training['institute'];
                        $trainings->duration = $training['duration'];
                        $trainings->location = $training['location'];

                        if(isset($training['training_file']) && $training['training_file']) {
                            //get filename with extension
                            $filenamewithextension = $training['training_file']->getClientOriginalName();

                            //get filename without extension
                            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                            //get file extension
                            $extension = $training['training_file']->getClientOriginalExtension();

                            //filename to store
                            // $filenametostore = Auth::user()->employeeDetails->employer_id.'_'.time().'.'.$extension;
                            $fileName = Auth::user()->employeeDetails->employer_id.'_'.preg_replace('/\s+/', '_', $training['training_title']).'_'.time().'.'.$extension;

                            $upload = $training['training_file']->storeAs(
                                'public/employee/documents/', $fileName
                            );
                            if($upload){
                                $trainings->training_file = $fileName;
                            }
                        }
                        $trainings->save();
                    }
                }
            }


        }

        toastr()->success('Information successfully updated.');

        // return redirect()->route('employee.profile', $employee_id);
        return redirect()->back();
    }

    public function attendanceTest(){
        $date = date('Y-m-d', strtotime('-1 day'));
        $day = date('l', strtotime('-1 day'));
        $employees = EmployeeFixedOfficeTime::distinct()->pluck('employee_id');

        foreach($employees as $employee_id){
            $employee = Employee::withoutGlobalScopes()->where('id', $employee_id)->first();
            if($employee->employeeJourney->employee_status_id == 1){

                $fixedRoster = EmployeeFixedOfficeTime::where('employee_id', $employee_id)->where('day', $day)->first();
                $existAttendance = Attendance::where('date', $date)->where('employee_id', $employee->id)->first();
                $leaveCheck = Leave::where('employee_id', $employee_id)->where('start_date', '<=', $date)->where('end_date', '>=', $date)->where('leave_status', LeaveStatus::APPROVED)->first();

                if($fixedRoster) {

                    $startTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_start));
                    $bendTime = date('Y-m-d H:i:s', strtotime($date . " " . $fixedRoster->roster_end));

                    if (!empty($existAttendance)) {
                        if ($existAttendance->punch_in) {
                            if ($fixedRoster->is_offday == 1) {
                                $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id : AttendanceStatus::DAYOFF;
                            } else {
                                $roster_entry_time = strtotime($startTime);
                                $punch_in_time = strtotime($existAttendance->punch_in);
                                $late = round(($punch_in_time - $roster_entry_time) / 60, 2);

                                // $status = ($leaveCheck && in_array($date, $leaveCheck->leave_days)) ? $leaveCheck->leave_type_id :
                                //     ((Carbon::parse($startTime)->format('H:i:s') && $late > 30) ? AttendanceStatus::LATE :
                                //         (($late > 10) ? AttendanceStatus::LATE :
                                //             AttendanceStatus::PRESENT));
                                //dd(Carbon::parse($existAttendance->work_hours)->format('H.i'));
                                $status = AttendanceStatus::PRESENT;
                                if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                    $status = $leaveCheck->leave_type_id;
                                } else if(Carbon::parse($startTime)->format('H:i:s') && $late > 30){
                                    $status = AttendanceStatus::LATE;
                                } else if($late > 10) {
                                    $status = AttendanceStatus::LATE;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 4.5){
                                    $status = AttendanceStatus::ABSENT;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') < 7.5){
                                    $status = AttendanceStatus::HALF_DAY;
                                }  else if(Carbon::parse($existAttendance->work_hours)->format('H.i') && Carbon::parse($existAttendance->work_hours)->format('H.i') > 7.5){
                                    $status = AttendanceStatus::PRESENT;
                                } else {
                                    $status = AttendanceStatus::PRESENT;
                                }
                            }
                        } else {
                            if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                                $status = $leaveCheck->leave_type_id;
                            } else if ($fixedRoster->is_offday == 1){
                                $status = AttendanceStatus::DAYOFF;
                            } else {
                                $status = AttendanceStatus::ABSENT;
                            }
                        }
                        DB::table('attendances')->where('date', $date)->where('employee_id', $employee->id)->update([
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'status' => $status
                        ]);
                    } else {

                        if($leaveCheck && in_array($date, $leaveCheck->leave_days)){
                            $status = $leaveCheck->leave_type_id;
                        } else if ($fixedRoster->is_offday == 1){
                            $status = AttendanceStatus::DAYOFF;
                        } else {
                            $status = AttendanceStatus::ABSENT;
                        }

                        $dataArray = array(
                            'employee_id' =>  $employee->id,
                            'date' => $date,
                            'roster_start' => $startTime,
                            'roster_end' => $bendTime,
                            'status' => $status
                        );
                        DB::table('attendances')->insert($dataArray);
                    }
                }
            }
        }
    }

    public function leaveTest(){
        // $employees = Employee::whereHas('employeeJourney', function($q){
        //     $q->where(function ($q){
        //         $q->where('probation_start_date', '<=', Carbon::now()->subYear(1)->format('Y-m-d'))
        //             ->orWhere('permanent_doj', '<=', Carbon::now()->subYear(1)->format('Y-m-d'));
        //     })
        //     ->where(function ($q){
        //         $q->where('employment_type_id', EmploymentTypeStatus::PROBATION)
        //             ->orWhere('employment_type_id', EmploymentTypeStatus::PERMANENT);
        //     });
        // })
        // ->withoutGlobalScope(DivisionCenterScope::class)
        // ->with(['employeeJourney', 'leaveBalances', 'earnLeaves'])
        // ->get();

        $employees = Employee::whereHas('employeeJourney', function($q){
            $q->where(function ($q){
                $q->where('employee_status_id', '=', 1);
            });
        })
        ->withoutGlobalScopes()
        ->with(['employeeJourney', 'leaveBalances', 'earnLeaves'])
        ->get();

       // dd($employees);

        foreach ($employees as $employee){
            $annualLeave = $employee->leaveBalances->where('leave_type_id', LeaveStatus::EARNED)->where('year', date("Y"));
            $eligible_date = $this->getEligibleDate($employee);
            $present_year = Carbon::now()->format('Y');
            $jobTenure = $this->getJobTenure($employee, $present_year);
            //dd($jobTenure);
            if(!$annualLeave->count() && $jobTenure >= 1 && $jobTenure < 2){
                $employee->earnLeaves()->create([
                    'eligible_date' => $eligible_date,
                    'year' => $present_year,
                    'earn_balance' => 16,
                    'forwarded_balance' => 0,
                    'total_balance' => 16,
                    'is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0,
                ]);
            }elseif($annualLeave->count()){
                $al = $employee->leaveBalances->where('leave_type_id', LeaveStatus::EARNED)->where('year', date("Y"))->first();
                if($al){
                    $al->update(['is_usable' => ($employee->employeeJourney->employment_type_id == EmploymentTypeStatus::PERMANENT) ? 1 : 0]);
                }
            }
        }
    }

}
