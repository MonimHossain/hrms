<?php

namespace App\Http\Controllers\User\Appraisal;

use App\Adjustment;
use App\AdjustmentType;
use App\AppraisalEvaluationName;
use App\AppraisalFilterQuestionList;
use App\AppraisalQstMst;
use App\AppraisalQuestionFilter;
use App\Center;
use App\Division;
use App\Employee;
use App\EmployeeEvaluationListChd;
use App\EmployeeEvaluationListMst;
use App\EmployeeTeam;
use App\LeadEvaluationListChd;
use App\LeadEvaluationListMst;
use App\Notifications\EmployeeEvaluationNotification;
use App\TeamEvaluationStatus;
use App\Utils\TeamMemberType;
use App\YearlyAppraisalChd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAppraisal(Request $request)
    {
        $active = 'user-my-team-appraisal';
        $userId = auth()->user()->employee_id;

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $appraisals = YearlyAppraisalChd::where('employee_id', $userId)->get();
            return view('user.appraisal.appraisal.index', compact('active', 'appraisals'));
        }

        /*$query = Adjustment::query();
        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->adjustment_type){
            $query->where('adjustment_type', $request->adjustment_type);
        }

        if ($request->date_from){
            $query->whereYear('created_at', \Carbon\Carbon::parse($request->date_from)->format('Y'));
            $query->whereMonth('created_at', \Carbon\Carbon::parse($request->date_from)->format('m'));
        }

        $adjustments = $query->get();
        return view('user.appraisal.appraisal.index', compact('active', 'adjustments', 'adjustmentType', 'emoloyees'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAppraisal()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAppraisal(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAppraisal($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAppraisal($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAppraisal(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAppraisal($id)
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEvaluation(Request $request)
    {
        $active = 'user-my-team-evaluation';
        $ownUserId = $this->accessOwnUser();
        $runningEvaluation =  $this->getFilteredRunningEvaluation('employee', 'one');
        $alreadyExistEvaluation = EmployeeEvaluationListMst::where('employee_id', $ownUserId)->where('evaluation_id', ($runningEvaluation->id ?? 0))->first();
        $evaluationList = $this->getFilteredRunningEvaluation('employee', 'all');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluationList = EmployeeEvaluationListMst::where('employee_id', ($ownUserId ?? 0))->get();
            $finalData = $this->employeeEvaluationStatusPreparedData($employeeEvaluationList);
            return view('user.appraisal.evaluation.index', compact('active', 'evaluationList', 'finalData', 'runningEvaluation', 'alreadyExistEvaluation'));
        }

        $query = EmployeeEvaluationListMst::query()->where('employee_id', $ownUserId);
        if ($request->evaluation){
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName', function($q) use ($request){
                $q->whereYear('start_date', '<=', $request->year);
                $q->whereYear('end_date', '>=', $request->year);
            });
        }

        $employeeEvaluationList = $query->get();
        $finalData = $this->employeeEvaluationStatusPreparedData($employeeEvaluationList);
        return view('user.appraisal.evaluation.index', compact('active', 'evaluationList', 'finalData', 'runningEvaluation', 'alreadyExistEvaluation'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myEvaluationDashboard(Request $request)
    {
        $active = 'user-my-evaluation-dashboard';
        $ownUserId = $this->accessOwnUser();
        $runningEvaluation =  $this->getFilteredRunningEvaluation('employee', 'one');
        $alreadyExistEvaluation = EmployeeEvaluationListMst::where('employee_id', $ownUserId)->where('evaluation_id', ($runningEvaluation->id ?? 0))->first();
        $evaluationList = $this->getFilteredRunningEvaluation('employee', 'all');;
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluationList = EmployeeEvaluationListMst::where('employee_id', ($ownUserId ?? 0))->get();
            $finalData = $this->employeeEvaluationStatusDashboardPreparedData($employeeEvaluationList);
            return view('user.appraisal.evaluation.my-dashboard', compact('active', 'evaluationList', 'finalData', 'runningEvaluation', 'alreadyExistEvaluation'));
        }

        $query = EmployeeEvaluationListMst::query()->where('employee_id', $ownUserId);
        if ($request->evaluation){
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName', function($q) use ($request){
                $q->whereYear('start_date', '<=', $request->year);
                $q->whereYear('end_date', '>=', $request->year);
            });
        }

        $employeeEvaluationList = $query->get();

        $finalData = $this->employeeEvaluationStatusDashboardPreparedData($employeeEvaluationList);
        return view('user.appraisal.evaluation.my-dashboard', compact('active', 'evaluationList', 'finalData', 'runningEvaluation', 'alreadyExistEvaluation'));
    }


    /**
     * Create My Evaluation.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMyEvaluation($id)
    {
        $flag = 'employee';
        $userId = $this->accessOwnUser();
        $questionList = $this->getFilteredEvaluationQuestionList($userId, $flag);
        if(isset($id) && !empty($questionList)){
            return $view = view('user.appraisal.evaluation.create-evaluation', compact('id', 'questionList'));
        }else{
            return view('user.appraisal.evaluation.not-found-evaluation');
        }
    }


    /**
     * create Team Lead Evaluation.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLeadEvaluation($id)
    {
        $flag = 'lead';
        $userId = $this->accessOwnUser();
        $questionList = $this->getFilteredEvaluationQuestionList($userId, $flag);
        if(isset($id) && !empty($questionList)){
            return $view = view('user.appraisal.lead.create-evaluation', compact('id', 'questionList'));
        }else{
            return view('user.appraisal.evaluation.not-found-evaluation');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMyEvaluation(Request $request, $id)
    {
        $teamLeadId = $this->getMyTeamLeadId(TeamMemberType::MEMBER);
        $userId  = $this->accessOwnUser();

        $teamLead = Employee::find($teamLeadId);
        $employee = Employee::find($userId);

        $team = auth()->user()->employeeDetails->employeeTeam()->where('member_type', [TeamMemberType::MEMBER])->first();
        if(!empty($team)) {
            $mstData = [
                'team_id' => $team->team_id,
                'employee_id' => auth()->user()->employee_id,
                'approved_by_employee' => 'p',
                'evaluation_id' => $id,
                'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            ];

            $evaluationListMst = EmployeeEvaluationListMst::create($mstData);

            if (!empty($evaluationListMst)) {
                $data = [];
                for ($key = 1; $key < ($request->arrayCount + 1); $key++) {
                    $data[] = [
                        'evaluation_mst' => $evaluationListMst->id,
                        'qst_type' => $request->has('qstType' . $key) ? $request->{'qstType' . $key} : '',
                        'qst_no' => $request->has('qstNo' . $key) ? $request->{'qstNo' . $key} : '',
                        'qst_mark' => $request->has('qstMark' . $key) ? $request->{'qstMark' . $key} : '',
                        'qst_name' => $request->has('qstName' . $key) ? $request->{'qstName' . $key} : '',
                        'ans_value' => $request->has('ansValue'. $key) ? $request->{'ansValue'.$key} : '',
                        'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                    ];
                }
                EmployeeEvaluationListChd::insert($data);
                Notification::send($teamLead->userDetails, new EmployeeEvaluationNotification($evaluationListMst, $employee->FullName, ' Submitted evaluation.', 'user.lead.evaluation.list'));

            }
            toastr()->success('Saved Successfully !');
        }else{
            toastr()->success('Team not found!');
        }
        return redirect()->route('user.my.evaluation.list');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLeadEvaluation(Request $request, $id)
    {

        $team = auth()->user()->employeeDetails->employeeTeam()->where('member_type', [TeamMemberType::MEMBER])->first();
        if(!empty($team)) {
            $mstData = [
                'team_id' => $team->team_id,
                'lead_id' => $team->team->team_lead_id,
                'employee_id' => auth()->user()->employee_id,
                'evaluation_id' => $id,
                'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
            ];

            $evaluationListMst = LeadEvaluationListMst::create($mstData);

            if (!empty($evaluationListMst)) {
                $data = [];
                for ($key = 1; $key < ($request->arrayCount + 1); $key++) {
                    $data[] = [
                        'evaluation_mst' => $evaluationListMst->id,
                        'qst_type' => $request->has('qstType' . $key) ? $request->{'qstType' . $key} : '',
                        'qst_no' => $request->has('qstNo' . $key) ? $request->{'qstNo' . $key} : '',
                        'qst_mark' => $request->has('qstMark' . $key) ? $request->{'qstMark' . $key} : '',
                        'qst_name' => $request->has('qstName' . $key) ? $request->{'qstName' . $key} : '',
                        'ans_value' => $request->has('ansValue'. $key) ? $request->{'ansValue'.$key} : '',
                        'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                    ];
                }
                $status =  LeadEvaluationListChd::insert($data);
                if($status){
                    $myTeams = $this->getMyTeamIdByUser(TeamMemberType::MEMBER);
                    $teamMembers = count($this->getTeamMemberListByUser(TeamMemberType::MEMBER)) - 1;
                    $acceptEvaluationMember = LeadEvaluationListMst::where('team_id', $myTeams)->where('evaluation_id', $id)->get()->count();
                    $checkResult = $teamMembers <=> $acceptEvaluationMember;
                    if($checkResult === 0){
                        TeamEvaluationStatus::where('team_id', $myTeams)->update(array('lead_status' => '1'));
                    }
                }
            }
            toastr()->success('Saved Successfully !');
        }else{
            toastr()->success('Team not found!');
        }
        return redirect()->route('evaluation.list.for.lead.by.user');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $evaluationId
     * @return \Illuminate\Http\Response
     */
    public function showMyEvaluation($id, $evaluationId)
    {
        $active = 'user-team-member-evaluation';
        $evaluations = EmployeeEvaluationListMst::where('employee_id', $id)->where('evaluation_id', $evaluationId)->get();
        return view('user.appraisal.evaluation.evaluation-view', compact('active', 'evaluations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  int  $evaluationId
     * @return \Illuminate\Http\Response
     */
    public function showLeadEvaluation($id, $evaluationId)
    {
        $active = 'user-team-member-evaluation';
        $evaluations = LeadEvaluationListMst::where('employee_id', $id)->where('evaluation_id', $evaluationId)->get();
        return view('user.appraisal.teamLeadEvaluation.evaluation-view', compact('active', 'evaluations'));
    }

    public function acceptOrRejectEvaluation($id, $evaluationId, $flag)
    {
        $evaluationListMst = EmployeeEvaluationListMst::where('employee_id', $id)->where('evaluation_id', $evaluationId)->first();
        $employee = Employee::find($id);
        $teamLead = Employee::find($evaluationListMst->lead_id);

        $data = ['approved_by_employee' => $flag];
        EmployeeEvaluationListMst::where('employee_id', $id)->where('evaluation_id', $evaluationId)->update($data);
        if($flag == 'a'){
            $myTeams = $this->getMyTeamIdByUser(TeamMemberType::MEMBER);
            $teamMembers = count($this->getTeamMemberListByUser(TeamMemberType::MEMBER)) - 1;
            $acceptEvaluationMember = EmployeeEvaluationListMst::where('team_id', $myTeams)->where('evaluation_id', $evaluationId)->where('approved_by_employee', 'a')->get()->count();
            $checkResult = $teamMembers <=> $acceptEvaluationMember;
            if($checkResult === 0){
                TeamEvaluationStatus::where('team_id', $myTeams)->update(array('status' => '1'));
            }
        }
        Notification::send($teamLead->userDetails, new EmployeeEvaluationNotification($evaluationListMst, $employee->FullName, " accepted or rejected evaluation", 'user.lead.evaluation.list'));
        toastr()->success('Updated Successfully !');
        return redirect()->route('user.my.evaluation.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editEvaluation($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEvaluation(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvaluation($id)
    {
        //
    }


    public function getFilteredEvaluationQuestionList($id, $flag)
    {
        $user_id = $id;
        $division = Division::where('name', session()->get('division'))->first()->id ?? 0;
        $center = Center::where('center', session()->get('center'))->first()->id ?? 0;
        $department = (!in_array(null,Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id')->toArray())) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!in_array(null,Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id')->toArray())) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!in_array(null,Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id')->toArray())) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $data = AppraisalQuestionFilter::whereHas('evaluationName', function ($q){
            $q->whereDate('start_date', '<=', Carbon::today()->toDateString());
            $q->whereDate('end_date', '>=', Carbon::today()->toDateString());
        })->orderBy('id', 'desc')
          ->where('question_type', $flag)
          ->where('center_id', $center)
          ->where('division_id', $division)
          ->whereIn('department_id', $department)
          ->whereIn('process_id', $process)
          ->whereIn('process_segment_id', $processSegment)
          ->take(1)
          ->with('filterQuestionList')->get();


        $result = [];
        foreach ($data as $value)
        {
            $result[] = $value->filterQuestionList->pluck('appraisal_qst_mst_id');
        }

        // $data3->join('appraisal_evaluation_names',function($p) {
        //     $p->on('appraisal_evaluation_names.id', '=', 'appraisal_filter_question_lists.appraisal_filter_id');
        //     $p->whereDate('start_date', '<=', Carbon::today()->toDateString());
        //     $p->whereDate('end_date', '>=', Carbon::today()->toDateString());
        // });



        // $result3 = $data3->join('appraisal_qst_msts',function($p) {
        //     $p->on('appraisal_qst_msts.id', '=', 'appraisal_filter_question_lists.appraisal_qst_mst_id');
        //     $p->where('type_id', '=', 'employee');
        // })->get();

        // if(!$result3->isEmpty()){
        //     return $result3;
        // }




        $finalQuestionList = AppraisalQstMst::with('labels')->get()->whereIn('id', $result[0] ?? []);


        if(!$finalQuestionList->isEmpty()){
            return $finalQuestionList;
        }

        return [];
    }

    public function getFilteredRunningEvaluation($flag, $limit)
    {
        $limit = ($limit == 'all') ? 'get':'first';
        $ownUserId = $this->accessOwnUser();
        $center = Center::where('center', session()->get('center'))->first()->id ?? 0;
        $division = Division::where('name', session()->get('division'))->first()->id ?? 0;
        $department = (!in_array(null,Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id')->toArray())) ? Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!in_array(null,Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id')->toArray())) ? Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!in_array(null,Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id')->toArray())) ? Employee::find($ownUserId)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];


        return AppraisalEvaluationName::whereHas('evaluationFilter', function ($p) use ($flag, $center, $division, $department, $process, $processSegment){
            $p->where('question_type', $flag);
            $p->where('center_id', $center);
            $p->where('division_id', $division);
            $p->whereIn('department_id', $department);
            $p->whereIn('process_id', $process);
            $p->whereIn('process_segment_id', $processSegment);
        })->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())->orderBy('id', 'DESC')
            ->{$limit}();
    }


    /*private function employeeEvaluationDataGenerate($data)
    {
        $mark = DB::table('employee_evaluation_list_chds')->selectRaw("COUNT(*) AS countNumber, SUM(ans_value) AS getMark, SUM(qst_mark) AS totalMark")
        ->get();
        $totalMark = $mark[0]->totalMark ?? 0;
        $getMark = $mark[0]->getMark ?? 0;
        $count = $mark[0]->countNumber ?? 0;
        $calculateMark = ($getMark * 100) / $totalMark;
        $grade = $this->caculateGrade($calculateMark);

        $result = [];
        if(!empty($data)){
            $result['employeeName'] = $data->employee->FullName ?? '';
            $result['employeeCreatedAt'] = Carbon::parse($data->created_at)->format('d M, Y') ?? '';
            $result['leadName'] = $data->lead->FullName ?? '';
            $result['leadCreatedAt'] = Carbon::parse($data->lead_created_at)->format('d M, Y') ?? '';
            $result['evaluationName'] = $data->evaluation->name ?? '';
            $result['startDate'] = Carbon::parse($data->evaluation->start_date)->format('d M, Y');
            $result['endDate'] = Carbon::parse($data->evaluation->end_date)->format('d M, Y');
            $result['result'] = [
                'totalMark' => $totalMark,
                'getMark' => number_format($getMark, 2, '.', ''),
                'grade' => $grade,
                'count' => $count
            ];
        }
        return $result;
    }

    private function caculateGrade($calculate)
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

    }*/


    public function leadEvaluationList(Request $request)
    {
        $active = 'team-lead-evaluation';
        $ownUserId = $this->accessOwnUser();
        $runningEvaluation =  $this->getFilteredRunningEvaluation('lead', 'one');
        $alreadyExistEvaluation = LeadEvaluationListMst::where('employee_id', $ownUserId)->where('evaluation_id', ($runningEvaluation->id ?? 0))->first();
        $evaluationList = $this->getFilteredRunningEvaluation('lead', 'all');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $employeeEvaluationList = LeadEvaluationListMst::where('employee_id', ($ownUserId ?? 0))
                ->paginate(10);
            return view('user.appraisal.teamLeadEvaluation.appraisal-list', compact('active', 'evaluationList', 'employeeEvaluationList', 'runningEvaluation', 'alreadyExistEvaluation'));
        }

        $query = LeadEvaluationListMst::query()->where('employee_id', $ownUserId);
        if ($request->evaluation){
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName', function($q) use ($request){
                $q->whereYear('start_date', '<=', $request->year);
                $q->whereYear('end_date', '>=', $request->year);
            });
        }

        $employeeEvaluationList = $query->paginate(10);
        return view('user.appraisal.teamLeadEvaluation.appraisal-list', compact('active', 'evaluationList', 'employeeEvaluationList', 'showAddNewButton', 'alreadyExistEvaluation'));
    }

    private function accessOwnUser()
    {
        return auth()->user()->employee_id;
    }


    public function ownLeadingEvaluationList(Request $request)
    {
        $active = 'own-leading-evaluation';
        $teamId = $this->getMyTeamIdByUser(TeamMemberType::TEAMLEADER);
        $evaluationList = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'lead');
        })->get();

        $requestCheck = $request->all();
        if (!$requestCheck) {
           $teamEvaluationStatus = TeamEvaluationStatus::with('LeadEvaluationListMaster')->where('team_id',$teamId)->where('lead_status','1')->get();
           $finalData = $this->ownLeadingEvaluationStatusPreparedData($teamEvaluationStatus);
           return view('user.appraisal.teamLeadEvaluation.own-leading-evaluation-list', compact('active', 'evaluationList', 'finalData'));
        }

        $query = TeamEvaluationStatus::with('LeadEvaluationListMaster')->where('team_id',$teamId)->where('lead_status','1');
        if ($request->evaluation){
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName', function($q) use ($request){
                $q->whereYear('start_date', '<=', $request->year);
                $q->whereYear('end_date', '>=', $request->year);
            });
        }

        $teamEvaluationStatus = $query->get();
        $finalData = $this->ownLeadingEvaluationStatusPreparedData($teamEvaluationStatus);
        if(empty($finalData)) {
            toastr()->warning('Data Not Found!');
        }
        return view('user.appraisal.teamLeadEvaluation.own-leading-evaluation-list', compact('active', 'evaluationList', 'finalData'));
    }


    public function ownLeadingEvaluationDashboard(Request $request)
    {
        $active = 'own-leading-evaluation-dashboard';
        $teamId = $this->getMyTeamIdByUser(TeamMemberType::TEAMLEADER);
        $evaluationList = AppraisalEvaluationName::whereHas('evaluationFilter', function ($p){
            $p->where('question_type', 'lead');
        })->get();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $teamEvaluationStatus = TeamEvaluationStatus::with('LeadEvaluationListMaster')->where('team_id',$teamId)->get();
            $finalData = $this->ownLeadingEvaluationStatusDashboardPreparedData($teamEvaluationStatus);
            return view('user.appraisal.teamLeadEvaluation.own-leading-evaluation-dashboard', compact('active', 'evaluationList', 'finalData'));
        }

        $query = TeamEvaluationStatus::with('LeadEvaluationListMaster')->where('team_id',$teamId)->where('lead_status','1');
        if ($request->evaluation){
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->year){
            $query->whereHas('evaluationName', function($q) use ($request){
                $q->whereYear('start_date', '<=', $request->year);
                $q->whereYear('end_date', '>=', $request->year);
            });
        }

        $teamEvaluationStatus = $query->get();
        $finalData = $this->ownLeadingEvaluationStatusDashboardPreparedData($teamEvaluationStatus);
        if(empty($finalData)) {
            toastr()->warning('Data Not Found!');
        }
        return view('user.appraisal.teamLeadEvaluation.own-leading-evaluation-dashboard', compact('active', 'evaluationList', 'finalData'));
    }


    private function getTeamMemberListByUser($memberType)
    {
        $teamId = $this->getMyTeamIdByUser($memberType);
        return EmployeeTeam::where('team_id', $teamId)->get()->pluck('employee_id')->toArray();
    }

    private function getMyTeamIdByUser($memberType)
    {
        $teams = auth()->user()->employeeDetails->employeeTeam()->where('member_type', [$memberType])->first();
        return $teams->team_id ?? 0;
    }

    private function ownLeadingEvaluationStatusDashboardPreparedData($teamEvaluationStatus)
    {
        $sum = 0;
        $count = 0;
        $finalData = [];
        foreach ($teamEvaluationStatus as $status){
            if(!($status->LeadEvaluationListMaster)->isEmpty()) {
                foreach ($status->LeadEvaluationListMaster as $list) {
                    $count++;
                    $result = 0;
                    $gndTotal = 0;
                    $resultData['year'] = Carbon::parse($list->evaluationName->created_at)->format('Y');
                    foreach ($list->evaluationList as $value) {
                        $array = json_decode($value->ans_value, true);
                        $result += array_keys($array)[0];
                        $gndTotal += $value->qst_mark;
                    }
                    $sum += $result;
                    $resultData['total'] = $gndTotal;
                    $resultData['sum'] = number_format($sum / $count, 2);
                }
                $finalData[] = $resultData;
            }
        }

        return $this->dashBordSummaryEvaluationData($finalData);
    }




    private function ownLeadingEvaluationStatusPreparedData($teamEvaluationStatus)
    {
        $sum = 0;
        $count = 0;
        $finalData = [];
        foreach ($teamEvaluationStatus as $status){
            if(!($status->LeadEvaluationListMaster)->isEmpty()) {
                foreach ($status->LeadEvaluationListMaster as $list) {
                    $count++;
                    $result = 0;
                    $gndTotal = 0;
                    $resultData['name'] = $list->evaluationName->name;
                    $resultData['start'] = \Carbon\Carbon::parse($list->evaluationName->start_date)->format('d M, Y');
                    $resultData['end'] = \Carbon\Carbon::parse($list->evaluationName->end_date)->format('d M, Y');
                    foreach ($list->evaluationList as $value) {
                        $array = json_decode($value->ans_value, true);
                        $result += array_keys($array)[0];
                        $gndTotal += $value->qst_mark;
                    }
                    $sum += $result;
                    $resultData['total'] = $gndTotal;
                    $resultData['sum'] = number_format($sum / $count, 2);
                }
                $finalData[] = $resultData;
            }
        }

        return $finalData;
    }

    public function employeeEvaluationStatusPreparedData($teamEvaluationStatus)
    {
        $sum = 0;
        $count = 0;
        $finalData = [];
        $resultData = [];
            if(!empty($teamEvaluationStatus)) {
                foreach ($teamEvaluationStatus as $list) {
                    $count++;
                    $result = 0;
                    $gndTotal = 0;
                    $resultData['evaluationId'] = $list->evaluationName->id;
                    $resultData['employeeId'] = $list->createdBy->id;
                    $resultData['name'] = $list->evaluationName->name;
                    $resultData['start'] = \Carbon\Carbon::parse($list->evaluationName->start_date)->format('d M, Y');
                    $resultData['end'] = \Carbon\Carbon::parse($list->evaluationName->end_date)->format('d M, Y');
                    $resultData['status'] = $list->approved_by_employee;
                    $resultData['lead_id'] = $list->lead_id;
                    $resultData['created_by'] = $list->createdBy->Fullname;
                    $resultData['created_at'] = $list->created_at;
                    $resultData['updated_by'] = $list->updatedBy->Fullname ?? '';
                    $resultData['updated_at'] = $list->lead_created_at ?? '';
                    foreach ($list->evaluationList as $value) {
                        $array = json_decode($value->ans_value, true);
                        $result += array_keys($array)[0];
                        $gndTotal += $value->qst_mark;
                    }
                    $sum += $result;
                    $resultData['total'] = $gndTotal;
                    $resultData['sum'] = number_format($sum / $count, 2);
                }
                $finalData[] = $resultData;
            }

        return $finalData;
    }

    private function employeeEvaluationStatusDashboardPreparedData($teamEvaluationStatus)
    {
        $sum = 0;
        $count = 0;
        $resultData = [];
        $finalData = [];
        if(!empty($teamEvaluationStatus)) {
            foreach ($teamEvaluationStatus as $list) {
                $count++;
                $result = 0;
                $gndTotal = 0;
                $resultData['year'] = Carbon::parse($list->evaluationName->created_at)->format('Y');
                $resultData['evaluationId'] = $list->evaluationName->id;
                $resultData['employeeId'] = $list->createdBy->id;
                $resultData['status'] = $list->approved_by_employee;
                foreach ($list->evaluationList as $value) {
                    $array = json_decode($value->ans_value, true);
                    $result += array_keys($array)[0];
                    $gndTotal += $value->qst_mark;
                }
                $sum += $result;
                $resultData['total'] = $gndTotal;
                $resultData['sum'] = number_format($sum / $count, 2);
            }
            $finalData[] = $resultData;
        }

        return $this->employeeDashBordSummaryEvaluationData($finalData);
    }

    private function dashBordSummaryEvaluationData($data)
    {
        $groups = array();
        foreach ($data as $item) {
            $key = $item['year'];
            if (!array_key_exists($key, $groups)) {
                $groups[$key] = array(
                    'id' => $item['year'],
                    'total' => $item['total'],
                    'sum' => $item['sum'],
                );
            } else {
                $groups[$key]['total'] = $groups[$key]['total'] + $item['total'];
                $groups[$key]['sum'] = $groups[$key]['sum'] + $item['sum'];
            }
        }
        return $groups;
    }

    private function employeeDashBordSummaryEvaluationData($data)
    {
        $groups = array();
        if(!in_array(null,$data)){
            foreach ($data as $item) {
                $key = $item['year'];
                if (!array_key_exists($key, $groups)) {
                    $groups[$key] = array(
                        'id' => $item['year'],
                        'evaluationId' => $item['evaluationId'],
                        'employeeId' => $item['employeeId'],
                        'status' => $item['status'],
                        'total' => $item['total'],
                        'sum' => $item['sum'],
                    );
                } else {
                    $groups[$key]['total'] = $groups[$key]['total'] + $item['total'];
                    $groups[$key]['sum'] = $groups[$key]['sum'] + $item['sum'];
                }
            }
            return $groups;
        }

    }

    private function getMyTeamLeadId($memberType)
    {
        $teams = auth()->user()->employeeDetails->employeeTeam()->where('member_type', [$memberType])->first();
        $teamId = $teams->team_id ?? 0;
        return EmployeeTeam::where('team_id', $teamId)->where('member_type', TeamMemberType::TEAMLEADER)->first()->employee_id;

    }


}
