<?php

namespace App\Http\Controllers\User;

use App\ClosingApplication;
use App\ClosingClearanceSetting;
use App\ClosingClearanceStatus;
use App\Employee;
use App\EmployeeClosing;
use App\EmployeeJourney;
use App\FnfHistory;
use App\FnfHostory;
use App\Helpers\Helper;
use App\LeaveBalance;
use App\Notifications\EmployeeClosingNotification;
use App\ProvidentFundSetting;
use App\ProvidentHistory;
use App\Team;
use App\User;
use App\Utils\AttendanceStatus;
use App\Utils\EmploymentTypeStatus;
use App\Utils\TeamMemberType;
use App\Utils\EmployeeClosing as EmpClosing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use DB;

class ClosingController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->employee_id;
        $active = 'user-closing-list';
        $closingApplication = ClosingApplication::with('exitInterviewEvaluation', 'closingClearanceStatus')->where('employee_id', $userId)->get();
        return view('user.closing.index', compact('active', 'closingApplication'));
    }

    public function create()
    {
        $rows = ClosingClearanceSetting::findOrFail(1);
        return view('user.closing.create', compact('rows'));
    }

    public function store(Request $request)
    {
        $userDetail = Helper::getCurrentTeamLead();
        $receiver = [];
        if(!empty($userDetail)){
            $receiver = $userDetail->userDetails;
        }else{
            toastr()->error('You are not belong to team as a member!');
            return redirect()->route('user.closing.list');
        }

        $sender = Helper::getCurrentUser();


        $validator = Validator::make($request->all(), [
            'textarea' => 'required',
        ]);

        if($validator->fails()) {
            toastr()->success('Field is required !');
            return redirect()
                ->route('user.closing.list');
        }

        $data = [
            'employee_id' => auth()->user()->employee_id,
            'application' => $request->has('textarea') ? $request->textarea : "",
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'updated_at' => Carbon::parse(Carbon::now())->format('Y-m-d')
        ];


        $application = ClosingApplication::insert($data);

        Notification::send($receiver, new EmployeeClosingNotification($application, $sender->FullName, ' send a employee closing request.', 'user.closing.request'));

        toastr()->success('Checklist successfully Created');

        return redirect()->route('user.closing.list');
    }


    public function closingRequestList()
    {
        $active = 'team-closing-request';
        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();
        $supervisedTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::SUPERVISOR])->get();
        $teamLeadEmployee = $this->getTeamMembersId($leadingTeams);
        $teamSupervisorEmployee = $this->getTeamMembersId($supervisedTeams);

        /*$allEmployee = array_merge($teamLeadEmployee, $teamSupervisorEmployee); // Merge team lead's member employee and super visor's member employee
        $filterEmployeeList =  collect($allEmployee)->unique()->values()->all();*/

        $closingApplicationForLead = ClosingApplication::whereIn('employee_id', $teamLeadEmployee)->whereIn('status', [
            EmpClosing::ApprovedFrom['teamLeadSupervisor']['new'],
            EmpClosing::ApprovedFrom['teamLeadSupervisor']['supervisor_approved']
        ])->get();
        $closingApplicationForSupervisor = ClosingApplication::whereIn('employee_id', $teamSupervisorEmployee)->whereIn('status', [EmpClosing::ApprovedFrom['teamLeadSupervisor']['new']])->get();

        return view('user.closing.request-list', compact('active', 'closingApplicationForLead', 'closingApplicationForSupervisor'));
    }

    public function getTeamMembersId($teams)
    {
        $teamMembers = [];

        foreach ($teams as $team) {
            $teamMembers[] = $team->employees()->select('employees.id')->wherePivot('member_type', TeamMemberType::MEMBER)->get();
        }
        $employeeIds = [];
        foreach ($teamMembers as $items) {
            foreach ($items as $item) {
                $employeeIds[] = ($item->id) ? $item->id : null;
            }
        }
        return $employeeIds;
    }


    public function closingRequestApproval($id, $flag)
    {
        $closingApplication = ClosingApplication::find($id);
        return view('user.closing.approval-closing', compact('active', 'closingApplication', 'id', 'flag'));
    }

    public function closingRequestApprovalStatusChange(Request $request, $id, $flag)
    {
        $sender = Helper::getCurrentUser();
        $receiverFromHrId = ClosingClearanceSetting::find(1)->hr_hod_id;
        $receiverFromHr = Employee::findOrFail($receiverFromHrId);
        $receiverFromUserId = ClosingApplication::findOrFail($id)->employee_id;
        $receiverFromUser = Employee::findOrFail($receiverFromUserId);


        $status = ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
            ($flag === "tl") ?
                [
                    'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved'],
                    'team_lead_by' => auth()->user()->employee_id
                ] :
                    [
                        'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['supervisor_approved'],
                        'supervisor_by' => auth()->user()->employee_id
                    ] :
                        [
                            'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['rejected'],
                            'rejected_by' => auth()->user()->employee_id
                        ];

        $application = ClosingApplication::where('id', $id)->update($status);
        Notification::send($receiverFromHr->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' send a employee closing request.', 'user.request.clearance.hr'));
        Notification::send($receiverFromUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' Team lead accepted closing request.', 'user.closing.list'));
        return redirect()->route('user.closing.request');
    }




    /**
     * Clearance.
     *
     * @param $request Object from Request Class
     *
     * @return @blade @View
     */

    public function clearance(Request $request)
    {
        $active = 'request-to-clearance';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeClosing = ClosingClearanceStatus::whereHas('employeeByApplication', function ($q){
                $q->where('clearance_mode', 0);
            })->get();
            // dd($employeeClosing);
            return view('admin.employeeClosing.clearance', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = ClosingClearanceStatus::query();
        if ($request->has('employee_id')){
            $query->whereHas('employeeByApplication', function ($q) use ($request){
                $q->where('employee_id', $request->employee_id);
                $q->where('clearance_mode', 0);
            });
        }

        $employeeClosing = $query->get();
        // dd($employeeClosing);

        return view('admin.employeeClosing.clearance', compact('active',  'emoloyees', 'employeeClosing'));
    }

    public function clearanceShow($id, $appId)
    {

        $application = ClosingApplication::find($appId);
        $setting = ClosingClearanceSetting::find(1);
        $applicationStatus = ClosingClearanceStatus::find($id);
        $userType = $this->selectUserInChargeOrHod();


        return view('admin.employeeClosing.clearance-show', compact('id', 'appId', 'application', 'setting', 'userType', 'applicationStatus'));
    }

    public function clearanceApproved(Request $request, $id)
    {
        $userSelect = $this->selectUserInChargeOrHod();

        $data = [];

        if($userSelect[1] === 'hod'){
            $data = [
                $userSelect[0].'_'.$userSelect[1].'_by' => auth()->user()->employee_id,
                $userSelect[0].'_status' => ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
                    EmpClosing::ApprovedFrom['approval']['approved'] : EmpClosing::ApprovedFrom['approval']['rejected']
            ];
        }


        if($userSelect[1] === 'in'){
            $data = [
                $userSelect[0].'_'.$userSelect[1].'_charge_by' => auth()->user()->employee_id,
                $userSelect[0].'_clearance' => $request->remarks,
                $userSelect[0].'_checklist' => json_encode($request->checklist)
            ];
        }


        ClosingClearanceStatus::where('id', $id)->update($data);

        toastr()->success('Successfully Updated');

        return redirect()->route('request.clearance.clearance');
    }


    /* ... closing approval from HR start... */
    public function userRequestToHr(Request $request)
    {
        $active = 'user-request-to-hr';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeClosing = ClosingApplication::where('status', EmpClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved'])->get();

            return view('admin.employeeClosing.hr-approval', compact('active',  'emoloyees', 'employeeClosing'));
        }

        $query = ClosingApplication::query();
        if ($request->has('employee_id')){
            $query->where('status', EmpClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved'])
                ->where('employee_id', $request->employee_id)
                ->get();

        }

        $employeeClosing = $query->get();

        return view('admin.employeeClosing.hr-approval', compact('active',  'emoloyees', 'employeeClosing'));
    }


    public function userRequestFinalClosingToHr(Request $request)
    {
        $active = 'user-final-closing-request-to-hr';

        $emoloyees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $resignEmployee = ClosingApplication::doesntHave('closingApplication')->whereHas('closingClearanceStatus', function($p){
                $p->where('hr_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $p->where('it_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $p->where('admin_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $p->where('accounts_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $p->where('own_dept_status', EmpClosing::ApprovedFrom['approval']['approved']);
            })->get();

            /*It will be open after emergency employee closing*/
            /*$separationEmployee = ClosingApplication::doesntHave('closingApplication')->where('termination_status', 1)->where('clearance_mode', 1)->get();
            $allClearanceApproval = $resignEmployee->merge($separationEmployee);*/
            $allClearanceApproval = $resignEmployee;

            return view('admin.employeeClosing.final-closing', compact('active',  'emoloyees', 'allClearanceApproval'));
        }

        $allQuery = ClosingApplication::query();
        if ($request->has('employee_id')){
            $allQuery->whereHas('closingClearanceStatus', function ($q){
                $q->where('hr_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $q->where('it_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $q->where('admin_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $q->where('accounts_status', EmpClosing::ApprovedFrom['approval']['approved']);
                $q->where('own_dept_status', EmpClosing::ApprovedFrom['approval']['approved']);
            })->where('employee_id', $request->employee_id);
        }

        $allClearanceApproval = $allQuery->get();

        return view('admin.employeeClosing.final-closing', compact('active',  'emoloyees', 'allClearanceApproval'));
    }



    public function userRequestToHrShow($id)
    {
        $closingApplication = ClosingApplication::find($id);
        return view('admin.employeeClosing.hr-approval-show', compact('closingApplication', 'id'));
    }

    public function userRequestToHrFinalApprovalShow($id)
    {
        $closingApplication = ClosingApplication::find($id);
        $providentFund = 0;
        $gratuity = 0;
        $leaveEncashment = 0;
        $tenure = 0;
        $viewPage = '';
        $dataValues = [];


        /*If Check Permanent employee*/
        if($closingApplication->employee->employeeJourney->employment_type_id === EmploymentTypeStatus::PERMANENT){
            if(empty($closingApplication->employee->employeeJourney->permanent_doj)){
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            /*Calculate Tenure */
            if(!empty($closingApplication->employee->employeeJourney->permanent_doj)){
                $tenure = Carbon::create($closingApplication->employee->employeeJourney->permanent_doj, config('app.timezone'))->diffInDays(Carbon::today())/365; // logic
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            /*Earn Leaves*/
            if(!empty($closingApplication->employee->leaveBalances)){
                $earnleaves = $closingApplication->employee->leaveBalances->filter(function ($value, $key) {
                    if($value->leave_type_id == AttendanceStatus::EARNED_LEAVE)
                        return $value;
                })->first();
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            /*Get Maturity and Gratuity Year*/
            if(!empty(ProvidentFundSetting::first())){
                $maturityGratuityYear = ProvidentFundSetting::first();
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            /*Get Gross Salary*/
            if(!empty($closingApplication->employee->individualSalary->gross_salary)){
                $grossSalary = $closingApplication->employee->individualSalary->gross_salary;
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage)->with($dataValues);
            }

            /*Calculate Basic Salary*/
            if(!empty($grossSalary) && !empty($closingApplication->employee->individualSalaryBreakdown)){
                $basic = $closingApplication->employee->individualSalaryBreakdown->filter(function ($value, $key){
                    if($value->is_basic == 1)
                        return $value;
                })->first();



                if(!empty($basic->percentage)){
                    $basicSalary = $grossSalary * ($basic->percentage/100);
                    $dataValues['percentage'] = $basic->percentage;
                }else{
                    $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                    return view($viewPage);
                }

            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }


            /*Per Day Salary*/
            if(!empty($grossSalary)){
                $perDaySalary = $grossSalary / 30;
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            /*Get Provident Fund*/
            if(!empty($closingApplication->employee->providentFund)){
                $pf = $closingApplication->employee->providentFund->map(function ($value){
                    if($value->status == 'payed')
                    return $value->amount;
                })->all();
            }else{
                $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
                return view($viewPage);
            }

            $sumPf = array_sum($pf);

            $dataValues['totalProvidentFund'] = ($tenure > $maturityGratuityYear->pf_year) ? $sumPf * 2 : 0; // pf * 2
            $dataValues['providentFund'] = $sumPf;
            $dataValues['gratuity'] = ($tenure > $maturityGratuityYear->gratuity_year) ? $basicSalary * $tenure: 0; //basic * tenure
            $dataValues['leaveEncashment'] = $earnleaves->remain * $perDaySalary; // remain leave * per day current salary
            $dataValues['leaves'] = $earnleaves->remain;
            $dataValues['closingApplication'] = $closingApplication;
            $dataValues['id'] = $id;

            $viewPage = 'admin.employeeClosing.final-closing-show-for-permanent-employee';
        }else{
            /* not permanent employee*/ /*Logic Change for Riad*/
            /*$viewPage = 'admin.employeeClosing.final-closing-show-for-employee';
            $dataValues['closingApplication'] = $closingApplication;
            $dataValues['id'] = $id;*/

            $viewPage = 'admin.employeeClosing.final-closing-show-for-error';
        }

        return view($viewPage)->with($dataValues);
    }

    public function userRequestToHrChangeStatus(Request $request,$id)
    {
        $sender = Helper::getCurrentUser();

        $applicationSetting = ClosingClearanceSetting::find(1);
        $receiverAsAdminId = $applicationSetting->admin_in_charge_id;
        $receiverAsAdminUser = Employee::findOrFail($receiverAsAdminId);


        $receiverAsHrId = $applicationSetting->hr_in_charge_id;
        $receiverAsHrUser = Employee::findOrFail($receiverAsHrId);


        $receiverAsItId = $applicationSetting->it_in_charge_id;
        $receiverAsItUser = Employee::findOrFail($receiverAsItId);


        $receiverAsAccountsId = $applicationSetting->accounts_in_charge_id;
        $receiverAsAccountsUser = Employee::findOrFail($receiverAsAccountsId);


        $receiverAsUserId = ClosingApplication::findOrFail($id)->employee_id;
        $receiverAsUser = Employee::findOrFail($receiverAsUserId);

        $receiverAsOwnDeptId = Helper::getCurrentOwnDepartment($receiverAsUserId);
        /*own department set default 1 on closing_clearance_status*/
        /*$receiverAsOwnDeptUser = Employee::findOrFail($receiverAsOwnDeptId);*/

        $status = ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
            [
                'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['hr_approved'],
                'lwd' => $request->has('lwd') ? $request->lwd : "",
                'hr_by' => auth()->user()->employee_id,
            ] :  [
                'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['rejected'],
                'rejected_by' => auth()->user()->employee_id
            ];

        $application = ClosingApplication::where('id', $id)->update($status);

        Notification::send($receiverAsAdminUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' wants to know it\'s clearance.', 'request.clearance.clearance'));
        Notification::send($receiverAsHrUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' wants to know it\'s clearance.', 'request.clearance.clearance'));
        Notification::send($receiverAsItUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' wants to know it\'s clearance.', 'request.clearance.clearance'));
        Notification::send($receiverAsAccountsUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' wants to know it\'s clearance.', 'request.clearance.clearance'));
        /*Notification::send($receiverAsOwnDeptUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' wants to know it\'s clearance.', 'request.clearance.clearance'));*/
        Notification::send($receiverAsUser->userDetails, new EmployeeClosingNotification($application, $sender->FullName, ' Approved by HR.', 'user.closing.list'));

        if($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']){
            $this->addUserApplicationForClearance($id);
        }

        return redirect()->route('user.request.clearance.hr');
    }



    public function userRequestToHrFinalApprovalChangeStatus(Request $request,$id)
    {
        $employeeId = ClosingApplication::find($id)->employee->id;

        if(ClosingApplication::find($id)->employee->employeeJourney->employment_type_id === EmploymentTypeStatus::PERMANENT){
            $data = [
                'employee_id' => $employeeId,
                'application_id' => $id,
                'pf' => $request->has('pf') ? $request->pf : null,
                'gratuity' => $request->has('gratuity') ? $request->gratuity : null,
                'leave' => $request->has('leave') ? $request->leave : null,
                'encashment' => $request->has('encashment') ? $request->encashment : null,
                'payment_date' => $request->has('payment_date') ? $request->payment_date : null,
                'payment_status' => $request->has('payment_status') ? $request->payment_status : null,
                'created_by' => auth()->user()->employee_id,
            ];

            FnfHistory::create($data);
        }

        $status = [
                'final_closing' => EmpClosing::ApprovedFrom['final']['true'],
                'hr_by' => auth()->user()->employee_id
            ];

        ClosingApplication::where('id', $id)->update($status);

        $employeeJourney = [
            'employee_status_id' => 2,
            'lwd' => Carbon::parse(Carbon::now())->format('Y-m-d')
        ];

        /*add for emergency employee closing*/
        $userStatus = [
            'status' => 2
        ];
        /*add for emergency employee closing*/

        EmployeeJourney::where('employee_id', $employeeId)->update($employeeJourney);

        User::where('employee_id', $employeeId)->update($userStatus);

        return redirect()->route('user.final.closing.request.clearance.hr');
    }

    /* ... closing approval from HR end... */
    private function addUserApplicationForClearance($id)
    {
        $data = [
            'closing_applications_id' => $id
        ];

        ClosingClearanceStatus::insert($data);
        return redirect()->route('user.request.clearance.hr');
    }

    private function selectUserInChargeOrHod()
    {
        $user = auth()->user()->employee_id;

        $selectUser = ClosingClearanceSetting::select('hr_hod_id', 'hr_in_charge_id', 'it_hod_id', 'it_in_charge_id', 'admin_hod_id', 'admin_in_charge_id', 'accounts_hod_id', 'accounts_in_charge_id')
            ->first()
            ->toArray();
        $allUser = (array) $selectUser;

        $selectUser = array_search($user, $allUser);
        if($selectUser){
            $arr = explode("_",$selectUser);
            foreach ($arr as $key=> $value){
                if($key <= 1){
                    $stringName[] = $value;
                }
            }
        }

        return $stringName ?? false;

    }


    /*Own Department Clearance HOD or In Charge*/
    public function ownDepartmentToClearance(Request $request)
    {
        $active = 'own-department-to-clearance';

        $emoloyees = Employee::all();
        $employeeClosing = ClosingClearanceStatus::where('own_dept_status', EmpClosing::ApprovedFrom['approval']['pending'])->get();

        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();
        $supervisingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::SUPERVISOR])->get();

        $ownDepartmentClearanceHod = $this->getTeamMembersId($leadingTeams);
        $ownDepartmentClearanceInCharge = $this->getTeamMembersId($supervisingTeams);

        $closingEmployeeIds = [];
        foreach ($employeeClosing as $item){
            $closingEmployeeIds[]=$item->employeeByApplication->employee_id;
        }

        $hodsEmployees = array_intersect($ownDepartmentClearanceHod,$closingEmployeeIds);;
        $InChargesEmployees = array_intersect($ownDepartmentClearanceInCharge,$closingEmployeeIds);;


        $requestCheck = $request->all();
        if (!$requestCheck) {
            $rowHods = ClosingClearanceStatus::where('own_dept_status', \App\Utils\EmployeeClosing::ApprovedFrom['approval']['pending'])->where('own_dept_hod_by', null)->whereHas('employeeByApplication', function ($q) use($hodsEmployees){
                $q->whereIn('employee_id', $hodsEmployees);
            })->get();

            $rowInCharges = ClosingClearanceStatus::where('own_dept_status', \App\Utils\EmployeeClosing::ApprovedFrom['approval']['pending'])->where('own_dept_in_charge_by', null)->whereHas('employeeByApplication', function ($q) use($InChargesEmployees){
                $q->whereIn('employee_id', $InChargesEmployees);
            })->get();

            return view('admin.employeeClosing.own-clearance', compact('active',  'emoloyees', 'rowHods', 'rowInCharges'));
        }


        $queryHod = ClosingClearanceStatus::query();
        $queryInCharge = ClosingClearanceStatus::query();
        if ($request->has('employee_id')){
            $queryHod->whereHas('employeeByApplication', function ($q) use ($request, $hodsEmployees){
                $q->where('employee_id', $request->employee_id);
                $q->orWhereIn('employee_id', $hodsEmployees);
            });

            $queryInCharge->whereHas('employeeByApplication', function ($q) use ($request, $InChargesEmployees){
                $q->where('employee_id', $request->employee_id);
                $q->orWhereIn('employee_id', $InChargesEmployees);
            });
        }

        $rowHods = $queryHod->where('own_dept_hod_by', '!=', null)->get();
        $rowInCharges = $queryInCharge->where('own_dept_in_charge_by', '!=', null)->get();

        return view('admin.employeeClosing.own-clearance', compact('active',  'emoloyees', 'employeeClosing', 'rowHods', 'rowInCharges'));
    }

    public function ownDepartmentToClearanceShow($id, $appId, $flag)
    {
        $application = ClosingApplication::find($appId);
        $applicationStatus = ClosingClearanceStatus::find($id);
        $setting = ClosingClearanceSetting::find(1);
        return view('admin.employeeClosing.own-clearance-show', compact('id', 'appId', 'flag', 'application', 'applicationStatus', 'setting'));
    }

    public function ownDepartmentToClearanceApproved(Request $request, $id, $flag)
    {
        if($flag === 'hod'){
            $data = [
                'own_dept_hod_by' => auth()->user()->employee_id,
                'own_dept_status' => ($request->approval_status == EmpClosing::ApprovedFrom['approval']['approved']) ?
                    EmpClosing::ApprovedFrom['approval']['approved'] : EmpClosing::ApprovedFrom['approval']['rejected'],
                'own_dept_clearance' => $request->remarks,
                'own_dept_checklist' => json_encode($request->checklist)

            ];
        }


        if($flag === 'in'){
            $data = [
                'own_dept_in_charge_by' => auth()->user()->employee_id,
                'own_dept_clearance' => $request->remarks,
                'own_dept_checklist' => json_encode($request->checklist)
            ];
        }


//        dd($data);

        ClosingClearanceStatus::where('id', $id)->update($data);

        toastr()->success('Successfully Updated');

        return redirect()->route('own.department.to.clearance');
    }


    public function fnfReport(Request $request)
    {
        $active = 'fnf-report';

        $employees = Employee::all();

        $requestCheck = $request->all();

        if (!$requestCheck) {
            $list = FnfHistory::all();
            return view('user.closing.fnf-report', compact('active',  'list', 'employees'));
        }

        $query = FnfHistory::query();

        if ($request->start_date || $request->end_date){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->get('employee_id')){
            $query->where('employee_id', $request->employee_id);
        }

        $list = $query->get();
        return view('user.closing.fnf-report', compact('active', 'list', 'employees'));
    }

    public function fnfExport()
    {
        (new FastExcel(FnfHistory::all()))->export('fnf-report-' . time() . '.xlsx', function ($pass) {
            $department = [];
            foreach($pass->employee->departmentProcess as $item){
                $department[] = $item->department->name;
            }
            return [
                'Employee' => $pass->employee->employer_id . ' : ' . $pass->employee->FullName,
                'Designation' => $pass->employee->employeeJourney->designation->name,
                'Department'  => $department,
                'Created at'   => Carbon::parse($pass->created_at)->format('d M, Y'),
                'PF'   => $pass->pf,
                'Leave'   => $pass->leave,
                'Leave Encashment'   => $pass->encashment,
                'Gratuity'   => $pass->gratuity,
            ];
        });
        return redirect()->route('fnf.report');
    }




}
