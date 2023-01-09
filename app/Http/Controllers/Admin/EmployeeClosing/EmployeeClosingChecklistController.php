<?php

namespace App\Http\Controllers\Admin\EmployeeClosing;

use App\Charts\AdminChart;
use App\ClosingApplication;
use App\ClosingClearanceSetting;
use App\ClosingClearanceStatus;
use App\Department;
use App\Employee;
use App\EmployeeJourney;
use App\EmploymentType;
use App\ExitInterviewEvaluation;
use App\FnfHistory;
use App\Http\Controllers\User\NoticeEventControllers;
use App\Leave;
use App\LeaveReason;
use App\Process;
use App\Scopes\DivisionCenterScope;
use App\User;
use App\Utils\EmployeeClosing;
use App\Utils\EmployeeClosing as EmpClosing;
use App\Utils\LeaveStatus;
use App\Utils\NoticeAndEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class EmployeeClosingChecklistController extends Controller
{

    public function dashboard(Request $request)
    {
        $active = 'admin-closing-dashboard';
        $month = $request->has('month') ? $request->input('month') : Carbon::now()->format('m');
        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
        // $employee = Employee::select('id', 'first_name', 'last_name', 'gender')->get();

        $borderColors = [
            "rgba(120, 43, 144, 0.5)",
            "rgba(45, 189, 182, 0.5)",
            "rgba(255, 205, 86, 0.5)",
            "rgba(51,105,232, 0.5)",
            "rgba(244,67,54, 0.5)",
            "rgba(66,66,66, 0.5)",
            "rgba(34,198,246, 0.5)",
            "rgba(46,125,50, 0.5)",
            "rgba(153, 102, 255, 0.5)",
            "rgba(255, 159, 64, 0.5)",
            "rgba(191,54,12, 0.5)",
            "rgba(233,30,99, 0.5)",
            "rgba(205,220,57, 0.5)",
            "rgba(49,27,146, 0.5)"
        ];

        $fillColors = [
            "rgba(120, 43, 144, 0.7)",
            "rgba(45, 189, 182, 0.7)",
            "rgba(255, 205, 86, 0.7)",
            "rgba(51,105,232, 0.7)",
            "rgba(244,67,54, 0.7)",
            "rgba(66,66,66, 0.7)",
            "rgba(34,198,246, 0.7)",
            "rgba(46,125,50, 0.7)",
            "rgba(153, 102, 255, 0.7)",
            "rgba(255, 159, 64, 0.7)",
            "rgba(191,54,12, 0.7)",
            "rgba(233,30,99, 0.7)",
            "rgba(205,220,57, 0.7)",
            "rgba(49,27,146, 0.7)"

        ];




        /*Gender ration*/
        $maleClose = ClosingApplication::select(['id', 'employee_id', 'applied_at', 'final_closing', 'status', 'termination_status', 'lwd', 'separation_type'])
            //->whereMonth('applied_at', $month)
            ->whereYear('applied_at', $year)
            ->where('final_closing', 1)
            ->whereHas('employee', function ($q) {
                $q->where('gender', 'Male');
            })
            ->with('employee')
            ->get()
            ->reduce(function ($data, $item) {
                return $item->id;
            });



        $femaleClose = ClosingApplication::select(['id', 'employee_id', 'applied_at', 'final_closing', 'status', 'termination_status', 'lwd', 'separation_type'])
            //->whereMonth('applied_at', $month)
            ->whereYear('applied_at', $year)
            ->where('final_closing', 1)
            ->whereHas('employee', function ($q) {
                $q->where('gender', 'Female');
            })
            ->with('employee')
            ->get()
            ->reduce(function ($data, $item) {
                return $item->id;
            });

        $totalClose = ClosingApplication::select(['id', 'employee_id', 'applied_at', 'final_closing', 'status', 'termination_status', 'lwd', 'separation_type'])
            //->whereMonth('applied_at', $month)
            ->whereYear('applied_at', $year)
            ->where('final_closing', 1)
            ->with('employee')
            ->get()
            ->reduce(function ($data, $item) {
                return $item->id;
            });


        $genderRatioData = [
            'Male' => ($totalClose) ? number_format((($maleClose ?? 0) / $totalClose) * 100, 2) : 0,
            'Female' => ($totalClose) ? number_format((($femaleClose ?? 0) / $totalClose) * 100, 2) : 0
        ];

        $genderRatio = new AdminChart();
        $genderRatio->displayAxes(false);
        $genderRatio->options([
            'showAllTooltips' => true
        ]);
        $genderRatio->labels(['Male', 'Female']);
        $genderRatio->dataset('Gender', 'pie', [$genderRatioData['Male'], $genderRatioData['Female']])->color($borderColors)->backgroundcolor($fillColors);


        /* Separation reason wise report*/
        $separationReasonWiseData = [];
        $separationReasons = EmployeeClosing::SeparationReason;
        foreach($separationReasons as $reason){
            $separation = ClosingApplication::select(['id', 'employee_id', 'applied_at', 'final_closing', 'status', 'termination_status', 'lwd', 'separation_type'])->where('final_closing', 1)->where('separation_type', $reason)->whereYear('applied_at', Carbon::parse(Carbon::now())->format('Y'))->get();
            $separationReasonWiseData[] = [
                'reason' => _lang('employee-closing.separationReason.'.$reason),
                'count' => ($separation) ? $separation->reduce(function ($data, $item) {
                       return $data + 1;
                    }) ?? 0 : 0
            ];
        }
        $separationReason = new AdminChart();
        $separationReason->displayAxes(true);
        $separationReason->labels(array_column($separationReasonWiseData, 'reason'));
        $separationReason->dataset('Separation Reason', 'bar', array_column($separationReasonWiseData, 'count'))->color($borderColors)->backgroundcolor($fillColors);


        /*Separation Type*/
        $separationTypeWiseData = [];
        $separationTypes = ClosingApplication::orWhere('final_closing', 1)->orWhere('termination_status', 1)->whereYear('applied_at', Carbon::parse(Carbon::now())->format('Y'))->select(DB::raw('termination_status'))->groupBy('termination_status')->get();
        foreach($separationTypes as $type){
            $final_closing = ($type->sum('final_closing') == 0) ? 1 : $type->sum('final_closing');
            $separationTypeWiseData[] = [
                'label' => ($type->termination_status === null) ? 'Resign' : 'Terminate',
                'resign' => number_format((($type->sum('final_closing') - $type->sum('termination_status')) * 100)/$final_closing, 2),
                'terminate' => number_format(($type->sum('termination_status') * 100 ) / $final_closing, 2)
            ];
        }
        $separationType = new AdminChart();
        $separationType->displayAxes(false);
        $separationType->options([
            'showAllTooltips' => false
        ]);
        $separationType->labels(array_column($separationTypeWiseData, 'label'));
        $separationType->dataset('Separation Type', 'pie', [$separationTypeWiseData[0]['resign'] ?? 0, $separationTypeWiseData[0]['terminate'] ?? 0])->color($borderColors)->backgroundcolor($fillColors);


        /*Exit Interview*/
        $exitInterviewData = [];
        $query = ExitInterviewEvaluation::query();
        $exitInterviewQuestionWithAnswer = $query->leftJoin('interview_qst_msts', 'interview_qst_msts.id', '=', 'exit_interview_evaluations.qst_no');
        $exitInterviewEvaluationData = $exitInterviewQuestionWithAnswer->groupBy('exit_interview_evaluations.created_at')->select('exit_interview_evaluations.created_at', DB::raw('sum(ans_value) as value, sum(marks) as total'))->get();
        foreach($exitInterviewEvaluationData as $row){
            $exitInterviewData[] = [
                'label' => ($row->created_at) ? Carbon::parse($row->created_at)->format('M') : 'Unknown',
                'value' => ($row->value + $row->total) % 100
            ];
        }

        $exitInterview = new AdminChart();
        $exitInterview->displayAxes(true);
        $exitInterview->labels(array_column($exitInterviewData, 'label'));
        $exitInterview->dataset('Exit Interview', 'bar', array_column($exitInterviewData, 'value'))->color($borderColors)->backgroundcolor($fillColors);


        /*Highest question mark*/
        $queryOne = ExitInterviewEvaluation::query();
        $queryTwo = ExitInterviewEvaluation::query();
        $highestExitInterviewQuestion = $queryOne->leftJoin('interview_qst_msts', 'interview_qst_msts.id', '=', 'exit_interview_evaluations.qst_no')->orderBy('ans_value','desc')->orderBy('marks','desc')->take(5)->get();
        $lowestExitInterviewQuestion = $queryTwo->leftJoin('interview_qst_msts', 'interview_qst_msts.id', '=', 'exit_interview_evaluations.qst_no')->orderBy('ans_value','asc')->orderBy('marks','asc')->take(5)->get();

        return view('admin.employeeClosing.dashboard',
            compact('active',
            /*'month',
            'year',
            'totalSl',
            'totalCl',
            'totalEl',*/
            'highestExitInterviewQuestion',
            'lowestExitInterviewQuestion',
            'exitInterview',
            'genderRatio',
            'separationType',
            'separationReason'));
    }

    /*Start Employee Termination*/
    public function employeeTermination(Request $request)
    {
        $active = 'employee-termination';

        $pagination = 10;
        $employees = Employee::all();

        $requestCheck = $request->all();

        if (!$requestCheck) {
            //$closingApplication = ClosingApplication::where('termination_status', 1)->get();
            $closingApplication = [];
            return view('admin.employeeClosing.termination.index', compact('active', 'closingApplication', 'employees'));
        }


        $query = ClosingApplication::query();

        if ($request->get('month')){
            $query
                ->whereYear('applied_at', Carbon::parse($request->month)->format('Y'))
                ->whereMonth('applied_at', Carbon::parse($request->month)->format('m'))
                ->where('termination_status', 1);
        }

        if ($request->get('employee_id')){
            $query->where('employee_id', $request->employee_id)->where('termination_status', 1);
        }

        if ($request->has('separation_type')){
            $query->where('separation_type', $request->separation_type)->where('termination_status', 1);
        }

        $closingApplication = $query->paginate($pagination);
        return view('admin.employeeClosing.termination.index', compact('active', 'closingApplication', 'employees'));

    }

    public function employeeTerminationView($id)
    {
        $closingApplication = ClosingApplication::with('exitInterviewEvaluation', 'closingClearanceStatus')->where('employee_id', $id)->where('termination_status', 1)->get();
        return view('admin.employeeClosing.termination.view', compact('closingApplication'));
    }

    public function employeeTerminationCreate()
    {
        $employees = Employee::all();
        return view('admin.employeeClosing.termination.create', compact( 'employees'));
    }

    public function employeeTerminationStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'lwd' => 'required',
            'separation_type' => 'required',
            'clearance_mode' => 'required',
            'remarks' => 'required'
        ]);

        if($validator->fails()) {
            toastr()->warning('All Fields is required !');
            return redirect()
                ->route('admin.employee.termination');
        }

        $data = [
            'employee_id' => $request->has('employee_id') ? $request->employee_id : "",
            'termination_remarks' => $request->has('remarks') ? $request->remarks : "",
            'termination_status' => 1,
            'lwd' => $request->has('lwd') ? $request->lwd : "",
            'separation_type' => $request->has('separation_type') ? $request->separation_type : null,
            'clearance_mode' => $request->has('clearance_mode') ? $request->clearance_mode : 0,
            'status' => EmpClosing::ApprovedFrom['teamLeadSupervisor']['hr_approved'],
            'termination_by' => auth()->user()->employee_id ?? 0,
            'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            'updated_at' => Carbon::parse(Carbon::now())->format('Y-m-d')
        ];

        $employeeJourneyData = [
            'separation_type' => $request->separation_type,
            'lwd' => $request->lwd,
            //'employee_status_id'=> 2 // temporary solution for emergency closing
        ];

        $userAccess = [
            'status' => 2 //temporary solution for emergency closing
        ];


        $closingApplication = ClosingApplication::insertGetId($data);
        EmployeeJourney::where('employee_id', $request->employee_id)->update($employeeJourneyData);
        //User::where('employee_id', $request->employee_id)->update($userAccess);

        ClosingClearanceStatus::insert(['closing_applications_id' => $closingApplication]);


        toastr()->success('Checklist successfully Created');

        return redirect()->route('admin.employee.termination');
    }
    /*End Employee Termination*/


    public function index($id)
    {
        $active = 'admin-clearance-checklist';

        $query = ClosingClearanceSetting::query();

        $clearanceCheckList = $query->get();

        $employees = Employee::all();

        $rows = ClosingClearanceSetting::find($id) ?? [];

        return view('admin.employeeClosing.setting.index', compact('active', 'clearanceCheckList', 'employees', 'rows'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            /*'admin_hod_id' => 'required|unique:ClosingClearanceSetting',
            'admin_in_charge_id' => 'required|unique:ClosingClearanceSetting',

            'accounts_hod_id' => 'required|unique:ClosingClearanceSetting',
            'accounts_in_charge_id' => 'required|unique:ClosingClearanceSetting',

            'it_hod_id' => 'required|unique:ClosingClearanceSetting',
            'it_in_charge_id' => 'required|unique:ClosingClearanceSetting',

            'hr_hod_id' => 'required|unique:ClosingClearanceSetting',
            'hr_in_charge_id' => 'required|unique:ClosingClearanceSetting',*/
        ]);

        if ($validator->fails()) {
            toastr()->success('All Field are unique !');
            return redirect()->route('admin.clearance.checklist', ['id'=>$id]);
        }



        $clearanceCheckList['admin_hod_id'] = $request->admin_hod;
        $clearanceCheckList['admin_in_charge_id'] = $request->admin_in_charge;
        $clearanceCheckList['admin_clearance_template'] = $request->admin_clearance_template;
        $clearanceCheckList['accounts_hod_id'] = $request->accounts_hod;
        $clearanceCheckList['accounts_in_charge_id'] = $request->accounts_in_charge;
        $clearanceCheckList['accounts_clearance_template'] = $request->accounts_clearance_template;
        $clearanceCheckList['it_hod_id'] = $request->it_hod;
        $clearanceCheckList['it_in_charge_id'] = $request->it_in_charge;
        $clearanceCheckList['it_clearance_template'] = $request->it_clearance_template;
        $clearanceCheckList['hr_hod_id'] = $request->hr_hod;
        $clearanceCheckList['hr_in_charge_id'] = $request->hr_in_charge;
        $clearanceCheckList['hr_clearance_template'] = $request->hr_clearance_template;
        $clearanceCheckList['default_clearance_template'] = $request->default_clearance_template;
        $clearanceCheckList['clearance_application_template'] = $request->application_clearance_template;
        $clearanceCheckList['created_by'] = auth()->user()->employee_id;
        $clearanceCheckList['updated_by'] = auth()->user()->employee_id;


        ClosingClearanceSetting::updateOrCreate(['id'=>$id], $clearanceCheckList);

        toastr()->success('Checklist successfully Updated');

        return redirect()->route('admin.clearance.checklist', ['id'=>$id]);
    }

    public function list(Request $request, $flag = null)
    {
        $active = 'request-to-clearance-list';

        $employees = Employee::all();
        $pagination = 10;

        $requestCheck = $request->all();

        if (!$requestCheck) {
            //$list = ClosingApplication::all();
            $list = [];
            return view('admin.employeeClosing.reports.list', compact('active',  'list', 'employees'));
        }

        $query = ClosingApplication::query();

        if ($request->get('employee_id')){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->input('status') !== null){
            $query->where('status' , $request->status);
        }

        $list = $query->paginate($pagination);
        return view('admin.employeeClosing.reports.list', compact('active', 'list', 'employees'));
    }

    public function exportCsv()
    {

        (new FastExcel(ClosingApplication::all()))->export('users-' . time() . '.xlsx', function ($pass) {
            $department = [];
            foreach($pass->employee->departmentProcess as $item){
                $department[] = $item->department->name;
            }
            return [
                'Employee' => $pass->employee->employer_id . ' : ' . $pass->employee->FullName,
                'Designation' => $pass->employee->employeeJourney->designation->name,
                'Department'  => $department,
                'Created at'   => Carbon::parse($pass->created_at)->format('d M, Y'),
                'Final status'   => $pass->final_closing,
                'Application status'   => $pass->status,
            ];
        });
        return redirect()->route('admin.clearance.checklist.list');

    }


    public function attritionReport(Request $request, $flag = null)
    {
        $active = 'closing-attrition-report';

        $processes = Process::all();

        $requestCheck = $request->all();

        if (!$requestCheck) {
            $result = DB::select( DB::raw("SELECT
                m.name,
                COUNT(CASE WHEN m.final_closing = 1 then 1 ELSE NULL END) as 'final_closing',
                COUNT(CASE WHEN m.termination_status = 1 then 1 ELSE NULL END) as 'termination_status' ,
                SUM(IFNULL(final_closing, 0) + IFNULL(termination_status, 0)) as 'total'
            FROM
                (SELECT DISTINCT
                    cp.final_closing,
                        cp.termination_status,
                        (SELECT
                                p.name
                            FROM
                                processes p
                            WHERE
                                p.id = edp.process_id) AS name
                FROM
                    employee_department_processes edp
                RIGHT JOIN closing_applications cp ON cp.employee_id = edp.employee_id) m group by m.name"));

            return view('admin.employeeClosing.reports.attrition-report', compact('active',  'result', 'processes'));
        }
        $filter['process_id'] = null;
        $filter['employee'] = null;
        $filter['dateYear'] = null;
        $filter['dateMonth'] = null;
        if($request->process){
            $filter['process_id'] = $request->process;
        }
        if($request->employee){
            $filter['employee'] = $request->employee;
        }

        if($request->month){
            $filter['dateYear'] = Carbon::parse($request->month)->format('Y');
            $filter['dateMonth'] = Carbon::parse($request->month)->format('m');
        }





        $result = DB::select( DB::raw("SELECT
                m.name,
                COUNT(CASE WHEN m.final_closing = 1 then 1 ELSE NULL END) as 'final_closing',
                COUNT(CASE WHEN m.termination_status = 1 then 1 ELSE NULL END) as 'termination_status' ,
                SUM(IFNULL(final_closing, 0) + IFNULL(termination_status, 0)) as 'total'
            FROM
                (SELECT DISTINCT
                    cp.final_closing,
                        cp.termination_status,
                        (SELECT
                                p.name
                            FROM
                                processes p
                            WHERE
                                p.id = edp.process_id) AS name
                FROM
                    employee_department_processes edp
                RIGHT JOIN closing_applications cp ON cp.employee_id = edp.employee_id where edp.process_id = :process_id OR edp.employee_id = :employee OR year(cp.applied_at) = :dateYear AND month(cp.applied_at) = :dateMonth) m group by m.name"), $filter);

        return view('admin.employeeClosing.reports.attrition-report', compact('active', 'result', 'processes'));
    }


    public function clearanceStatus(Request $request, $flag = null)
    {
        $active = 'clearance-status-report';

        $processes = Process::all();
        $pagination = 1;

        /*Status*/
        $checkPending = '<i class="text-warning" aria-hidden="true">Pending</i>';
        $checkYes = '<i class="text-primary fa fa-check"></i>';
        $checkNo = '<i class="text-danger fa fa-times"></i>';
        $selectStatusArray = [$checkPending, $checkYes, $checkNo];
        /*Status*/

        $requestCheck = $request->all();

        if (!$requestCheck) {
            //$list = ClosingClearanceStatus::with('employeeByApplication')->get();
            $result = [];
            /*foreach ($list as $row)
            {
                $result[] = [
                    'employee'=> $row->employeeByApplication->employee->employer_id.'-'.$row->employeeByApplication->employee->FullName,
                    'final'=> $selectStatusArray[$row->employeeByApplication->final_closing],
                    'lwd'=> (!empty($row->employeeByApplication->lwd))?Carbon::parse($row->employeeByApplication->lwd)->format('d M, Y') : '',
                    'admin'=> $selectStatusArray[$row->admin_status],
                    'it'=> $selectStatusArray[$row->it_status],
                    'accounts'=> $selectStatusArray[$row->accounts_status],
                    'hr'=> $selectStatusArray[$row->hr_status],
                    'own_dept'=> $selectStatusArray[$row->own_dept_status],
                ];
            }*/

            return view('admin.employeeClosing.reports.clearance-status', compact('active',  'result', 'processes'));
        }

        $query = ClosingClearanceStatus::with('employeeByApplication');


        if ($request->get('month')){
            $query->whereHas('employeeByApplication', function ($q) use($request){
                $q->whereYear('applied_at', Carbon::parse($request->month)->format('Y'));
                $q->whereMonth('applied_at', Carbon::parse($request->month)->format('m'));
            });
        }

        if ($request->get('employee')){
            $query->whereHas('employeeByApplication', function ($q) use($request){
                $q->where('employee_id', $request->employee);
            });
        }

        if ($request->get('process')){
            $query->whereHas('employeeByApplication', function ($q) use($request){
                $q->whereHas('departmentProcess', function ($p) use($request){
                    $p->where('process_id', $request->process);
                });
            });
        }


        $list = $query->get();
        $result = [];
        foreach ($list as $row)
        {
            $result[] = [
                'employee'=> $row->employeeByApplication->employee->employer_id.'-'.$row->employeeByApplication->employee->FullName,
                'final'=> $selectStatusArray[$row->employeeByApplication->final_closing],
                'lwd'=> (!empty($row->employeeByApplication->lwd))?Carbon::parse($row->employeeByApplication->lwd)->format('d M, Y') : '',
                'admin'=> $selectStatusArray[$row->admin_status],
                'it'=> $selectStatusArray[$row->it_status],
                'accounts'=> $selectStatusArray[$row->accounts_status],
                'hr'=> $selectStatusArray[$row->hr_status],
                'own_dept'=> $selectStatusArray[$row->own_dept_status],
            ];
        }
        return view('admin.employeeClosing.reports.clearance-status', compact('active', 'result', 'processes'));
    }


    public function adminFnfReport(Request $request)
    {
        $active = 'fnf-report';

        $employees = Employee::all();
        $paginate = 10;

        $requestCheck = $request->all();

        if (!$requestCheck) {
            // $list = FnfHistory::all();
            $list = [];
            return view('user.closing.fnf-report', compact('active',  'list', 'employees'));
        }

        $query = FnfHistory::query();

        if ($request->start_date || $request->end_date){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->get('employee_id')){
            $query->where('employee_id', $request->employee_id);
        }

        $list = $query->paginate($paginate);
        return view('user.closing.fnf-report', compact('active', 'list', 'employees'));
    }


    public function adminFnfExport()
    {
        (new FastExcel(FnfHistory::all()))->export('fnf-report-' . time() . '.xlsx', function ($pass) {
            $department = [];
            foreach($pass->employee->departmentProcess as $item){
                $department[] = $item->department->name;
            }
            dd($department);
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
        return redirect()->route('admin.fnf.report');
    }




}
