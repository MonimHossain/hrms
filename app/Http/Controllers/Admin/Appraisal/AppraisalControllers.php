<?php

namespace App\Http\Controllers\Admin\Appraisal;

use App\Adjustment;
use App\AdjustmentType;
use App\AppraisalEvaluationName;
use App\AppraisalFilterQuestionList;
use App\AppraisalKpiPercentage;
use App\AppraisalQstChd;
use App\AppraisalQstMst;
use App\AppraisalQuestionFilter;
use App\AppraisalQuestionSetList;
use App\Center;
use App\CenterDepartment;
use App\Department;
use App\DepartmentProcess;
use App\Division;
use App\Employee;
use App\EmployeeDepartmentProcess;
use App\EmployeeEvaluationListChd;
use App\EmployeeEvaluationListMst;
use App\Kpi;
use App\Process;
use App\ProcessSegment;
use App\Team;
use App\TeamEvaluationStatus;
use App\Utils\EmployeeClosing;
use App\Utils\EmploymentTypeStatus;
use App\Utils\RecommendationFor;
use App\Utils\TeamMemberType;
use App\YearlyAppraisalChd;
use App\YearlyAppraisalMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function React\Promise\Stream\first;

class AppraisalControllers extends Controller
{

    public function questionSetupNew(Request $request)
    {
        $active = 'appraisal-question-setup-new';
        $divisions = Division::all();
        $questions =  AppraisalQstMst::all();
        $evaluationNames = AppraisalEvaluationName::all();
        return view('admin.appraisal.setup.new', compact('active', 'divisions', 'questions', 'evaluationNames'));
    }

    public function questionFilterList(Request $request)
    {
        $data = '';
        if($request->has('id')){
            $id = $request->id;
            $data = AppraisalQstMst::where('type_id', $id)->get();
        }
        return $data;
    }

    public function questionSetupList(Request $request)
    {
        $active = 'appraisal-question-setup-list';
        $setList = AppraisalEvaluationName::all();
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $setNames = AppraisalQuestionFilter::all();
            return view('admin.appraisal.setup.index', compact('active', 'setNames', 'setList'));
        }

        $query = AppraisalQuestionFilter::query();
        if ($request->name){
            $query->where('name', $request->name);
        }

        $setNames = $query->get();
        return view('admin.appraisal.setup.index', compact('active', 'setNames', 'setList'));
    }

    public function questionSetupSave(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'division' => 'required',
            'center' => 'required',
            'department' => 'required',
            'process' => '',
            'processSegment' => '',
            'name' => 'required',
            'qst_id' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->warning('All Field are required !');
            return redirect()
                ->route('appraisal.question.setup.list')
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->name as $field) {
            $appraisalFilter = new AppraisalQuestionFilter;
            $appraisalFilter->question_type = $request->has('type_id') ? $request->type_id : 0;
            $appraisalFilter->division_id = $request->has('division') ? $request->division : 0;
            $appraisalFilter->center_id = $request->has('center') ? $request->center : 0;
            $appraisalFilter->department_id = !empty($request->department) ? $request->department : 0;
            $appraisalFilter->process_id = !empty($request->process) ? $request->process : 0;
            $appraisalFilter->process_segment_id = !empty($request->processSegment) ? $request->processSegment : 0;
            $appraisalFilter->name = $field;
            $appraisalFilter->save();

            foreach ($request->qst_id as $row) {
                $appraisalQuestionFilter = new AppraisalFilterQuestionList;
                $appraisalQuestionFilter->appraisal_filter_id = $appraisalFilter->id;
                $appraisalQuestionFilter->appraisal_qst_mst_id = $row;
                $appraisalQuestionFilter->save();
            }
        }

        toastr()->success('Successfully saved !');
        return redirect()->route('appraisal.question.setup.list');
    }

    public function questionSetupEdit($id)
    {

        $active = 'appraisal-question-setup-list';
        $divisions = Division::all();
        $questions =  AppraisalQstMst::all();
        $rows = AppraisalQuestionFilter::findOrFail($id);
        $evaluationNames = AppraisalEvaluationName::all();

        $questionsFilterList = AppraisalQuestionFilter::with('filterQuestionList')->where('id', $id)->get();
        $checkedQuestionList = [];

        foreach($questionsFilterList as $row) {
            foreach ($row->filterQuestionList as $list) {
                $checkedQuestionList[] = $list->appraisal_qst_mst_id;
            }
        }

        return view('admin.appraisal.setup.edit', compact('active', 'id', 'divisions',  'questions', 'rows', 'checkedQuestionList', 'evaluationNames'));
    }

    public function questionSetupUpdate($id, Request $request)
    {

//        dd($request->all());

        if(!empty($request->name)) {
            $existData = AppraisalFilterQuestionList::where('appraisal_filter_id', $id);
            $existData->delete();


            foreach ($request->name as $field) {
                $appraisalFilter = AppraisalQuestionFilter::where('id', $id)->first();

                $appraisalFilter->division_id = $request->filled('division') ? $request->division : null;
                $appraisalFilter->center_id = $request->filled('center') ? $request->center : null;
                $appraisalFilter->department_id = $request->filled('department') ? $request->department : null;
                $appraisalFilter->process_id = $request->filled('process') ? $request->process : null;
                $appraisalFilter->process_segment_id = $request->filled('processSegment') ? $request->processSegment : null;
                $appraisalFilter->name = $field;
                $appraisalFilter->save();

                foreach ($request->qst_id as $row) {
                    $appraisalQuestionFilter = new AppraisalFilterQuestionList;
                    $appraisalQuestionFilter->appraisal_filter_id = $id;
                    $appraisalQuestionFilter->appraisal_qst_mst_id = $row;
                    $appraisalQuestionFilter->save();
                }
            }
            toastr()->success('Successfully saved !');
        }else{
            toastr()->warning('Evaluation name is required !');
        }

        return redirect()->route('appraisal.question.setup.list');
    }


    public function appraisalHistoryList(Request $request)
    {


        $active = 'appraisal-history-list';

        $newDepartments = CenterDepartment::where('center_id', $this->getCenter('id'))->get();

        $existingDepartment = YearlyAppraisalMst::where('year', Carbon::parse(Carbon::now())->format('Y'))->pluck('dept_id')->toArray();

        /*for check which department not yet completed their evaluations*/
        $departmentList = Department::all()->pluck('name', 'id');

        $currentEvaluation =  AppraisalEvaluationName::whereDate('start_date', '<=', Carbon::now())->whereDate('end_date', '>=', Carbon::now())->orderBy('id', 'DESC')->first();
//        $employeeEvaluationList = EmployeeEvaluationListMst::where('evaluation_id', $currentEvaluation->id ?? 0)->where('approved_by_employee', 'a')->get()->pluck('employee_id')->toArray();
//
//        $edp = EmployeeDepartmentProcess::all();
//        $EmployeeDepartmentProcessData = $edp->groupBy('department_id', true);
//        $departmentStatus = [];*/
//
//        foreach ($EmployeeDepartmentProcessData as $departmentKey => $value)
//        {
//            /*Get Team Lead ID*/
//            $teamLead = [];
//            foreach ($value as $val)
//            {
//                if(isset($val->employee_team->member_type)){
//                    if($val->employee_team->member_type === TeamMemberType::TEAMLEADER) {
//                        $teamLead[] = $val->employee_id;
//                    }
//                }else{
//                    $teamLead[] = [];
//                }
//            }
//
//            $employeeListFromEdp = $value->pluck('employee_id');
//
//            /*Remove Team Lead ID*/
//            foreach ($employeeListFromEdp as $key => $id)
//            {
//                if(in_array($id, $teamLead)){
//                    unset($employeeListFromEdp[$key]);
//                }
//            }
//
//
//
//
//            foreach ($employeeListFromEdp as $empId){
//                if(in_array($empId, $employeeEvaluationList)){
//                    if(isset($departmentStatus[$departmentList[$departmentKey]]) != 'incomplete'){
//                        $departmentStatus[$departmentList[$departmentKey]] = 'complete';
//                    }
//                }else{
//                    $departmentStatus[$departmentList[$departmentKey]] = 'incomplete';
//                }
//            }
//
//        }




        $requestCheck = $request->all();
        if (!$requestCheck) {
            $historyDepartment = YearlyAppraisalMst::all();
            return view('admin.appraisal.appraisal.index-history', compact('active', 'newDepartments', 'historyDepartment', 'existingDepartment', 'departmentStatus', 'currentEvaluation'));
        }

        $query = YearlyAppraisalMst::query();
        if ($request->year){
            $query->where('year', $request->year);
        }

        $historyDepartment = $query->get();

        return view('admin.appraisal.appraisal.index-history', compact('active','newDepartments', 'historyDepartment', 'existingDepartment', 'currentEvaluation'));
    }

    public function appraisalLogList(Request $request)
    {
        $active = 'appraisal-log-list';

        $employees = Employee::all();
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $appraisalList = YearlyAppraisalChd::simplePaginate(15);
            return view('admin.appraisal.appraisal.index', compact('active', 'appraisalList', 'employees'));
        }

        $query = YearlyAppraisalChd::query();



        if ($request->employee){
            $query->whereHas('parent', function ($p) use($request){
                $p->where('employee_id', $request->employee);
            });
        }
        if ($request->year){
            $query->whereHas('parent', function ($p) use($request){
                $p->whereYear('created_at', $request->year);
            });
        }

        $appraisalList = $query->get();
        return view('admin.appraisal.appraisal.index', compact('active', 'appraisalList', 'employees'));
    }

    public function appraisalLogNew()
    {
        $active = 'appraisal-log-new';

        $divisions = Division::all();
        return view('admin.appraisal.appraisal.new', compact('active', 'divisions'));

    }

    public function evaluationHistoryList(Request $request)
    {
        $active = 'evaluation-history-list';
        $evaluationList = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        })->get();
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $evaluationHistory = AppraisalEvaluationName::with('teamEvaluationStatus')->whereHas('evaluationFilter', function ($p){
                $p->where('question_type', 'employee');
            })->get();
            return view('admin.appraisal.evaluation.index-history', compact('active', 'evaluationList', 'evaluationHistory'));
        }

        $query = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        });

        $evaluationId = $request->evaluation;
        $yearId = $request->year;
        if ($request->evaluation){
            $query->whereHas('evaluationList', function ($q) use ($evaluationId){
                $q->where('evaluation_id', '=', $evaluationId);
            });
        }

        if ($request->year){
            $query->whereHas('evaluationList', function($q) use ($yearId){
                $q->whereYear('start_date', '<=', $yearId);
                $q->whereYear('end_date', '>=', $yearId);
            });
        }

        $evaluationHistory = $query->get();
        return view('admin.appraisal.evaluation.index-history', compact('active', 'evaluationList', 'evaluationHistory'));
    }


    public function evaluationHistoryEmployeeView($id)
    {
        $active = 'evaluation-history-list';
        $teams = Team::all();
        $data = [];
        foreach ($teams as $team){
            $data[] = [
               'name' => $team->name,
               'status' => TeamEvaluationStatus::where('team_id', $team->id)->where('evaluation_id', $id)->first()->status ?? null
            ];
        }
        return view('admin.appraisal.evaluation.evaluation-employee-view', compact('active', 'data'));
    }

    public function evaluationHistoryLeadView($id)
    {
        $active = 'admin-lead-evaluation-status';
        $teams = Team::all();
        $data = [];
        foreach ($teams as $team){
            $data[] = [
                'name' => $team->name,
                'status' => TeamEvaluationStatus::where('team_id', $team->id)->where('evaluation_id', $id)->first()->lead_status ?? null
            ];
        }
        return view('admin.appraisal.lead.evaluation-lead-view', compact('active', 'data'));
    }

    public function employeeEvaluationNameEdit($id)
    {
        $evaluationNames = AppraisalEvaluationName::find($id);
        return view('admin.appraisal.evaluation.evaluation-edit', compact( 'evaluationNames', 'id'));
    }

    public function leadEvaluationNameEdit($id)
    {
        $evaluationNames = AppraisalEvaluationName::find($id);
        return view('admin.appraisal.lead.evaluation-edit', compact( 'evaluationNames', 'id'));
    }

    public function employeeEvaluationNameUpdate($id, Request $request)
    {
           $data = [
               'name' => $request->name,
               'start_date' => $request->start_date,
               'end_date' => $request->end_date,
           ];
           AppraisalEvaluationName::where('id', $id)->update($data);

           return redirect()->route('evaluation.history.list');
    }

    public function leadEvaluationNameUpdate($id, Request $request)
    {
        $data = [
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        AppraisalEvaluationName::where('id', $id)->update($data);

        return redirect()->route('admin.lead.evaluation.status');
    }


    public function evaluationLogList(Request $request)
    {
        $active = 'evaluation-log-list';

        $evaluations = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        })->get();

        $teams = Team::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluations = EmployeeEvaluationListMst::with('evaluationList')->get();
            return view('admin.appraisal.evaluation.index', compact('active', 'evaluations', 'teams', 'employeeEvaluations'));
        }

        $query = EmployeeEvaluationListMst::with('evaluationList');

        if ($request->evaluationName){
            $query->where('evaluation_id', $request->evaluationName);
        }

        if ($request->year){
            $selectYear = $request->year;
            $query->whereHas('evaluationName' , function ($q) use ($selectYear){
                $q->whereYear('start_date',  $selectYear);
                $q->whereYear('end_date', $selectYear);
            });
        }
        if ($request->team){
            $query->whereHas('team' , function ($q) use ($request){
                $q->where('id',  $request->team);
            });
        }

        $employeeEvaluations = $query->get();
        return view('admin.appraisal.evaluation.index', compact('active', 'evaluations', 'teams', 'employeeEvaluations'));
    }

    public function evaluationLogNew()
    {
        $active = 'evaluation-log-new';
        $divisions = Division::all();
        $questionFilterList = AppraisalQuestionFilter::all();
        return view('admin.appraisal.evaluation.new', compact('active', 'divisions', 'questionFilterList'));
    }

    public function evaluationLogSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evaluationName' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'remarks' => '',
        ]);

        if ($validator->fails()) {
            toastr()->warning('All Field Are  !');
            return redirect()->route('evaluation.log.list');
        }

        $appraisalEvaluationName = new AppraisalEvaluationName;
        $appraisalEvaluationName->name = $request->has('evaluationName') ? $request->evaluationName : 0;
        $appraisalEvaluationName->start_date = $request->has('startDate') ? $request->startDate : 0;
        $appraisalEvaluationName->end_date = $request->has('endDate') ? $request->endDate : 0;
        $appraisalEvaluationName->created_by = auth()->user()->employee_id ?? 1;
        $appraisalEvaluationName->remarks = $request->has('remarks') ? $request->remarks : 0;
        $appraisalEvaluationName->save();

        if($appraisalEvaluationName){
            $teams = Team::all();
            foreach ($teams as $value)
            {
                $teamEvaluation  = new TeamEvaluationStatus;
                $teamEvaluation->team_id = $value->id;
                $teamEvaluation->evaluation_id = $appraisalEvaluationName->id;
                $teamEvaluation->completed_at = Carbon::parse(Carbon::now())->format('Y-m-d');
                $teamEvaluation->save();
            }
        }

        toastr()->success('Successfully saved !');
        return redirect()->route('evaluation.log.list');
    }

    public static function calculateGrade($calculate)
    {
        if ($calculate < 33) {
            return "F";
        } else if ($calculate <= 40 && $calculate >= 33) {
            return "D";
        } else if ($calculate <= 50 && $calculate >= 40) {
            return "C";
        } else if ($calculate <= 60 && $calculate >= 50) {
            echo "B";
        } else if ($calculate <= 70 && $calculate >= 60) {
            return "A";
        } else if ($calculate <= 100 && $calculate >= 80) {
            return "A+";
        }

    }

    public function kpiPercentageList()
    {
        $active = 'kpi-percentage-list';
        $appraisalKpi = AppraisalKpiPercentage::find(1);
        return view('admin.appraisal.setting.kpi.setting', compact('active','appraisalKpi'));
    }

    public function kpiPercentageUpdate(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'permanent_percentage' => 'required|numeric',
            'hourly_percentage' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return redirect()
                ->route('kpi.percentage.list');
        }

        AppraisalKpiPercentage::updateOrCreate(
            ['id' => $id],
            [
                'permanent_percentage' => $request->permanent_percentage,
                'hourly_percentage' => $request->hourly_percentage,
            ]
        );

        toastr()->success('successfully Updated');
        return redirect()->route('kpi.percentage.list');
    }

    public function getDivision($key)
    {
        $division = Session::get('division');
        return Division::where('name', $division)->first()->{$key} ?? null;
    }

    public function getCenter($key)
    {
        $center = Session::get('center');
        $division = Session::get('division');
        $myDivisionId = Division::where('name', $division)->first()->id ?? null;
        return Center::where('center', $center)->where('division_id', $myDivisionId)->first()->{$key} ?? null;
    }

    public function appraisalGenerate($id)
    {
           $currentYear = Carbon::now()->format('Y');
           $departmentId = $id;

           $divisionId = $this->getDivision('id');
           $centerId = $this->getDivision('id');


            $employeeList = Employee::whereHas('departmentProcess', function ($q) use ($departmentId){
             $q->where('department_id', $departmentId);
            })->whereHas('divisionCenters', function ($q) use ($divisionId, $centerId){
                $q->where('division_id', $divisionId)->where('center_id', $centerId);
            })->whereHas('employeeTeam', function ($q){
                $q->where('member_type', TeamMemberType::MEMBER);
            })->get();


           $yearlyAppraisal = new YearlyAppraisalMst;
           $yearlyAppraisal->dept_id = $departmentId;
           $yearlyAppraisal->year = $currentYear;
           $yearlyAppraisal->status = 'generate';
           $yearlyAppraisal->created_by = auth()->user()->employee_id ?? 1;
           $yearlyAppraisal->save();

           $yearlyAppraisalMstId = $yearlyAppraisal->id;

           $data = [];
           $yearlyAppraisalChd = new YearlyAppraisalChd;
           if($yearlyAppraisal){
               foreach ($employeeList as $employee)
               {
                   $score = $this->getScore($employee->id, $currentYear)[1];
                   $data[] = [
                       'y_a_mst_id' => $yearlyAppraisalMstId,
                       'employee_id' => $employee->id,
                       'score' => $score,
                   ];
               }
               $yearlyAppraisalChd->insert($data);
           }

           return redirect()->route('appraisal.history.list');
    }


    public function appraisalReGenerate($id, $year)
    {
        $currentYear = $year;
        $departmentId = $id;

        $divisionId = $this->getDivision('id');
        $centerId = $this->getDivision('id');


        $employeeList = Employee::whereHas('departmentProcess', function ($q) use ($departmentId){
            $q->where('department_id', $departmentId);
        })->whereHas('divisionCenters', function ($q) use ($divisionId, $centerId){
            $q->where('division_id', $divisionId)->where('center_id', $centerId);
        })->whereHas('employeeTeam', function ($q){
            $q->where('member_type', TeamMemberType::MEMBER);
        })->get();



        $yearlyAppraisal = YearlyAppraisalMst::where('dept_id',$departmentId)->where('year', $currentYear)->first();
        $yearlyAppraisal->status = 'regenerate';
        $yearlyAppraisal->created_by = auth()->user()->employee_id ?? 1;
        $yearlyAppraisal->save();

        $yearlyAppraisalMstId = $yearlyAppraisal->id;


        YearlyAppraisalChd::where('y_a_mst_id', $yearlyAppraisalMstId)->delete();

        $data = [];
        $yearlyAppraisalChd = new YearlyAppraisalChd;
        if($yearlyAppraisal){
            foreach ($employeeList as $employee)
            {
                $score = $this->getScore($employee->id, $currentYear);
                $data[] = [
                    'y_a_mst_id' => $yearlyAppraisalMstId,
                    'employee_id' => $employee->id,
                    'score' => $score,
                ];
            }
            $yearlyAppraisalChd->insert($data);
        }

        return redirect()->route('appraisal.history.list');
    }



    private function getScore($id, string $currentYear)
    {
        $employeeTypeId = Employee::find($id)->employeeJourney->employmentType->id;
        $evaluationMst = EmployeeEvaluationListMst::query();



        /*$evaluationData = $evaluationMst->leftJoin('employee_evaluation_list_chds', function ($q) use ($id, $currentYear, $employeeTypeId){
            $q->on('employee_evaluation_list_msts.id','=','employee_evaluation_list_chds.evaluation_mst');
            $q->where('employee_id', $id);
            $q->whereYear('employee_evaluation_list_msts.created_at', $currentYear);
        })->get()->groupBy('employee_mst')->map(function ($row) use ($id, $employeeTypeId){
            if($employeeTypeId == EmploymentTypeStatus::PERMANENT){
                dd($row->sum('employee_evaluation_list_chds.qst_mark'));
                return $this->scoreCalculateForPermanent($row->sum('qst_mark'), $row->sum('ans_value'), $id);
            }elseif ($employeeTypeId == EmploymentTypeStatus::HOURLY){
                return $this->scoreCalculateForHourly($row->sum('qst_mark'), $row->sum('ans_value'), $id);
            }
        });*/

        $evaluationMstArray = $evaluationMst->with('evaluationList')
            ->where('employee_id', $id)
            ->whereYear('created_at', $currentYear)
            ->get();

        $evaluationData = 0;
        foreach ($evaluationMstArray as $value)
        {
            $evaluationData = $value->evaluationList->groupBy('employee_mst')->map(function ($row) use ($id, $employeeTypeId){
               $ans_value = $this->sumAnsValue($row);
               if($employeeTypeId == EmploymentTypeStatus::PERMANENT){
                    return $this->scoreCalculateForPermanent($row->sum('qst_mark'), $ans_value, $id);
                }elseif ($employeeTypeId == EmploymentTypeStatus::HOURLY){
                    return $this->scoreCalculateForHourly($row->sum('qst_mark'), $ans_value, $id);
                }
            })->first();
        }

        return $evaluationData ?? 0;




        /*Make group by data (By evaluation_id)*/
        /*$scoreArr = [];
        if(!empty($evaluationMst)){
            foreach ($evaluationMst as $mst)
            {
                $scoreArr[] = $mst->evaluationList->groupBy('evaluation_id')->map(function ($row) use ($mst){
                    return [
                        'id' => $mst->employee_id,
                        'total' => $row->sum('qst_mark'),
                        'get' => $row->sum('ans_value')
                    ];
                });
            }
        }



        $employeeTypeId = Employee::find($id)->employeeJourney->employmentType->id;

        if(!empty($scoreArr)){
            foreach ($scoreArr as $valueArr){
                if(!empty($valueArr)){
                    foreach ($valueArr as $value){
                        dump($value);
                        if($employeeTypeId == EmploymentTypeStatus::PERMANENT){
                            $this->scoreCalculateForPermanent($value, $id);
                        }elseif ($employeeTypeId == EmploymentTypeStatus::HOURLY){
                            $this->scoreCalculateForHourly($value, $id);
                        }
                    }
                }
            }
        }*/


    }


    private function scoreCalculateForPermanent($total, $get, $id)
    {
        $kpiPercentage = AppraisalKpiPercentage::findOrFail(1)->permanent_percentage ?? 0;
        $evaluationScore = ($get > 0) ? ($get * (100 - $kpiPercentage)) / $total : 0;

        $Kpi = Kpi::where('employee_id', $id)->get()->groupBy('employee_id', 'created_at')->map(function ($row){
            return  [$row->count('id') ?? 0 => $row->sum('score') ?? 0];
        });

        $kpiScore = 0;
        if(!empty($kpi)) {
            foreach ($Kpi as $valueArr) {
                foreach ($valueArr as $key => $value) {
                    $kpiScore = (($value / $key) * $kpiPercentage) / 100;
                }
            }
        }

        $total_score = $kpiScore + $evaluationScore;
        return number_format($total_score, 2, '.', '');
    }


    private function scoreCalculateForHourly($total, $get, $id)
    {

        $kpiPercentage = AppraisalKpiPercentage::findOrFail(1) ? AppraisalKpiPercentage::findOrFail(1)->hourly_percentage:0;
        $evaluationScore = ($get > 0) ? ($total * (100 - $kpiPercentage)) / $get : 0;

        $Kpi = Kpi::where('employee_id', $id)->get()->groupBy('employee_id', 'created_at')->map(function ($row){
            return  [$row->count('id') => $row->sum('score')];
        });

        $kpiScore = 0;
        if(!empty($kpi)) {
            foreach ($Kpi as $valueArr) {
                foreach ($valueArr as $key => $value) {
                    $kpiScore = (($value / $key) * $kpiPercentage) / 100;
                }
            }
        }

        $total_score = $kpiScore + $evaluationScore;
        return number_format($total_score, 2, '.', '');
    }


    public function detailLog($id)
    {
        $active = 'appraisal-history-list';
        $yearlyAppraisalChd = YearlyAppraisalChd::where('y_a_mst_id',$id)->get();
        return view('admin.appraisal.appraisal.detail-log', compact('active','yearlyAppraisalChd'));
    }

    public function answerListDetails($id)
    {
        $appraisalQstChd = AppraisalQstChd::where('mst_id',$id)->get();
        return view('admin.appraisal.appraisal.answer-view-details', compact('appraisalQstChd'));
    }

    public function adminLeadEvaluationStatus(Request $request)
    {
        $active = 'admin-lead-evaluation-status';
        $evaluationList = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'lead');
        })->get();
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $evaluationHistory = AppraisalEvaluationName::with('teamEvaluationStatus')->whereHas('evaluationFilter', function ($p){
                $p->where('question_type', 'lead');
            })->get();
            return view('admin.appraisal.lead.index-history', compact('active', 'evaluationList', 'evaluationHistory'));
        }

        $query = AppraisalEvaluationName::with('teamEvaluationStatus')->whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'lead');
        });


        if ($request->evaluation){
            $query->where('id', '=', $request->evaluation);
        }

        if ($request->year){
            $query->whereYear('start_date', '<=', $request->year);
            $query->whereYear('end_date', '>=', $request->year);
        }

        $evaluationHistory = $query->get();
        return view('admin.appraisal.lead.index-history', compact('active', 'evaluationList', 'evaluationHistory'));
    }

    /*
     * Analytical Report
     * */
    public function evaluationAnalyticalReport(Request $request)
    {
        $active = 'user-evaluation-analytical-report';
        $evaluationList = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        })->get();

        $departments = Department::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {

            $evaluationHistory = EmployeeDepartmentProcess::with([
                'department'=> function($department){
                    $department->select(['id', 'name']);
                },
                'process'=> function($process){
                    $process->select(['id', 'name']);
                },
                'processSegment'=>function($processSegment){
                    $processSegment->select(['id', 'name']);
                },
                'teams'=> function($team){
                    $team->select(['id', 'name']);
                },
                'employee'=> function($employee){
                    $employee->select(['id', 'employer_id', 'first_name', 'last_name']);
                }

            ])->whereHas('employeeEvaluationList',function ($q){
                $q->where('approved_by_employee', 'a');
            })->get();

            $finalData = $this->employeeEvaluationAnalyticalPreparedData($evaluationHistory);
            return view('admin.appraisal.evaluation.department-wise-analytic', compact('active', 'finalData', 'departments', 'evaluationList', 'evaluationHistory'));
        }

        $query = EmployeeDepartmentProcess::with([
            'department'=> function($department){
                $department->select(['id', 'name']);
            },
            'process'=> function($process){
                $process->select(['id', 'name']);
            },
            'processSegment'=>function($processSegment){
                $processSegment->select(['id', 'name']);
            },
            'teams'=> function($team){
                $team->select(['id', 'name']);
            },
            'employee'=> function($employee){
                $employee->select(['id', 'employer_id', 'first_name', 'last_name']);
            }

        ])->whereHas('employeeEvaluationList',function ($q){
            $q->where('approved_by_employee', 'a');
        });

        $evaluationId = $request->evaluation;
        $yearId = $request->year;
        $departmentId = $request->department;
        if ($request->evaluation){
            $query->whereHas('employee.evaluationList', function ($q) use ($evaluationId){
                $q->where('evaluation_id', '=', $evaluationId);
            });
        }

        if ($request->year){
            $query->whereHas('employee.evaluationList.evaluationName', function($q) use ($yearId){
                $q->whereYear('start_date', '<=', $yearId);
                $q->whereYear('end_date', '>=', $yearId);
            });
        }

        if($request->department){
            $query->where('department_id', $departmentId);
        }



        $evaluationHistory = $query->get();
        $finalData = $this->employeeEvaluationAnalyticalPreparedData($evaluationHistory);
        return view('admin.appraisal.evaluation.department-wise-analytic', compact('active', 'finalData', 'departments', 'departmentId', 'evaluationList', 'evaluationHistory'));
    }


    private function employeeEvaluationAnalyticalPreparedData($teamEvaluationStatus)
    {

        $resultData = [];
        $finalData = [];
        foreach ($teamEvaluationStatus as $value){
            $employeeEvaluationMst = EmployeeEvaluationListMst::where('employee_id', $value->employee->id ?? 0)->select('recommendation_for')->get();

            if(!$employeeEvaluationMst->isEmpty()) {
                $recommend = [];
                foreach ($employeeEvaluationMst as $recommendationRow) {
                    $getRecommendationArray = json_decode($recommendationRow->recommendation_for, true);
                    if (!empty($getRecommendationArray)) {
                        foreach ($getRecommendationArray as $recommendationName) {
                            $recommend[$recommendationName] = _lang('recommendation-for.status.' . $recommendationName);
                        }
                    }
                }
                $resultData[$value->department->id] = $recommend;
                $finalData[] = $resultData;


                /*$firstName = $value->employee->first_name ?? '';
                $lastName = $value->employee->last_name ?? '';
                $resultData['processName'] = $edp->process[0]->name ?? 'All';
                $resultData['processSegmentName'] = $edp->processSegment[0]->name ?? 'All';
                $resultData['teamName'] = $value->teams[0]->name ?? 'All';
                $resultData['employeeName'] = $firstName.' '.$lastName;*/

            }else{
                $finalData[] = [];
            }

        }

        return $this->analyticEvaluationData($finalData);
    }

    private function analyticEvaluationData($finalData)
    {
        $groups = [];
        $departmentKey = [];
        $mstKey = [];
        foreach($finalData as $key=>$mst){
            foreach($mst as $department=>$rows){
                if (!array_key_exists($department, $departmentKey)) {
                    foreach ($rows as $k => $value) {
                        if (!array_key_exists($k, $mstKey)) {
                            $mstKey[$k] = 1;
                        } else {
                            $mstKey[$k] = $mstKey[$k] + 1;
                        }
                    }
                    $groups[$department] = $mstKey;
                }
            }

        }
        return $groups;
    }

    public function evaluationAnalyticalReportForEmployeeView($year, $evaluation, $department, $recommend)
    {
        $query = Employee::query();
        if ($year){
            $query->whereHas('evaluationList.evaluationName', function($q) use ($year){
                $q->whereYear('start_date', '<=', $year);
                $q->whereYear('end_date', '>=', $year);
            });
        }

        if ($evaluation){
            $query->whereHas('evaluationList', function ($q) use ($evaluation){
                $q->where('evaluation_id', '=', $evaluation);
            });
        }

        if($department != 0){
            $query->whereHas('employeeDepartmentProcess', function ($p) use ($department){
               $p->where('department_id', $department);
            });
        }

        if($recommend != 0){
            $query->whereHas('evaluationList', function ($p) use ($recommend){
               $p->whereJsonContains('recommendation_for', $recommend);
            });
        }
        $result = $query->get();
        return view('admin.appraisal.evaluation.analytic-profile', compact('result'));
    }

    public function evaluationAnalyticalReportForEmployeeViewDetails($id)
    {
        $active = '';
        $result = EmployeeEvaluationListMst::where('employee_id', $id)->where('approved_by_employee', 'a')->get();
        $finalData =  App('App\Http\Controllers\User\Appraisal\AppraisalController')->employeeEvaluationStatusPreparedData($result);
        return view('admin.appraisal.evaluation.employee-details', compact('active','finalData'));
    }

    public function evaluationAnalyticalReportTeam(Request $request)
    {
        $active = 'user-evaluation-analytical-report-team';
        $evaluations = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        })->get();

        $teams = Team::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluations = EmployeeEvaluationListMst::with('evaluationList')->get();
            return view('admin.appraisal.evaluation.team-wise-analytic', compact('active', 'evaluations', 'teams', 'employeeEvaluations'));
        }

        $query = EmployeeEvaluationListMst::with('evaluationList');

        $selectEvaluation = $request->evaluationName;
        $selectYear = $request->year;
        if(!isset($selectYear)){
            toastWarning('Year Select required');
        }
        $selectTeam = $request->team;
        if(!isset($selectTeam)){
            toastWarning('Team Select required');
        }

        if ($request->evaluationName){
            $query->where('evaluation_id', $selectEvaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName' , function ($q) use ($selectYear){
                $q->whereYear('start_date',  $selectYear);
                $q->whereYear('end_date', $selectYear);
            });
        }
        if ($request->team){
            $query->whereHas('team' , function ($q) use ($selectTeam){
                $q->where('id',  $selectTeam);
            });
        }

        $employeeEvaluations = $query->get();
        return view('admin.appraisal.evaluation.team-wise-analytic', compact('active', 'evaluations', 'teams', 'employeeEvaluations', 'selectYear', 'selectTeam', 'selectEvaluation'));
    }

    public function evaluationAnalyticalReportEmployee(Request $request)
    {
        $active = 'user-evaluation-analytical-report-employee';
        $evaluations = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'employee');
        })->get();

        $employees = Employee::all();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluations = EmployeeEvaluationListMst::with('evaluationList')->get();
            return view('admin.appraisal.evaluation.employee-wise-analytic', compact('active', 'evaluations', 'employees', 'employeeEvaluations'));
        }

        $query = EmployeeEvaluationListMst::with('evaluationList');

        /*$selectEvaluation = $request->evaluationName;*/
        $selectYear = $request->year;
        if(!isset($selectYear)){
            toastWarning('Year Select required');
        }
        $selectEmployee = $request->employee;
        if(!isset($selectEmployee)){
            toastWarning('Employee Select required');
        }

        /*if ($request->evaluationName){
            $query->where('evaluation_id', $selectEvaluation);
        }*/

        if ($request->year){
            $query->whereHas('evaluationName' , function ($q) use ($selectYear){
                $q->whereYear('start_date',  $selectYear);
                $q->whereYear('end_date', $selectYear);
            });
        }
        if ($request->employee){
            $query->where('employee_id', $selectEmployee);
        }

        $employeeEvaluations = $query->get();
        return view('admin.appraisal.evaluation.employee-wise-analytic', compact('active', 'evaluations', 'employees', 'selectEmployee', 'employeeEvaluations'));
    }

    private function sumAnsValue($row)
    {
        $value = 0;
        foreach ($row as $column)
        {
            $jsonDecode = array_keys((array) json_decode($column->ans_value));
            $value += $jsonDecode[0] ?? 0;

        }
        return $value;
    }
}
