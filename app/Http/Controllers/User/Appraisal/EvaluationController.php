<?php

namespace App\Http\Controllers\User\Appraisal;

use App\Adjustment;
use App\AdjustmentType;
use App\Employee;
use App\EmployeeEvaluationList;
use App\EmployeeEvaluationListChd;
use App\EmployeeEvaluationListMst;
use App\Notifications\EmployeeEvaluationNotification;
use App\Utils\TeamMemberType;
use App\YearlyAppraisalChd;
use App\YearlyAppraisalMst;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = 'user-team-evaluation';
        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $listItem = [];
            foreach ($leadingTeams as $list) // Team
            {
                $checkArr = []; //Check for duplicate
                foreach ($list->evaluations as $value) // evaluation mst
                {
                    $listItem['id'] = $list->id;
                    $listItem['teamName'] = $list->name;
                    if(!in_array($value->evaluationName->id, $checkArr)){
                        array_push($checkArr, $value->evaluationName->id);
                        $listItem['evaluation'][] = [
                            'mstId' => $value->id,
                            'id' => $value->evaluationName->id,
                            'name' => $value->evaluationName->name,
                            'total' => count($list->evaluations)
                        ];
                    }
                }
            }
//            dd($listItem);

            return view('user.appraisal.lead.index', compact('active', 'listItem'));
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
        $adjustments = $query->get();*/

        return view('user.appraisal.lead.index', compact('active'));
    }

    public function appraisalListByHr(Request $request)
    {
        $active = 'user-appraisal-hr';
        $employees = YearlyAppraisalChd::with('employee')->get();
        $requestCheck = $request->all();
        if(!$requestCheck){
            $appraisalList = YearlyAppraisalChd::all();
            return view('user.appraisal.hr.appraisal-list', compact('active', 'appraisalList', 'employees'));
        }

        $query = YearlyAppraisalChd::query();


        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->year){
            $query->wherehas('parent', function ($q) use ($request){
                $q->where('year', $request->year);
            });
        }

        $appraisalList = $query->get();

        return view('user.appraisal.hr.appraisal-list', compact('active', 'appraisalList', 'employees'));
    }

    public function leadEvaluationList(Request $request)
    {
        $active = 'team-lead-evaluation';
        $employees = YearlyAppraisalChd::with('employee')->get();
        $requestCheck = $request->all();
        if(!$requestCheck){
            $appraisalList = YearlyAppraisalChd::all();
            return view('user.appraisal.teamLeadEvaluation.appraisal-list', compact('active', 'evaluationList', 'employeeEvaluationList', 'showAddNewButton', 'alreadyExistEvaluation'));
        }

        $query = YearlyAppraisalChd::query();


        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->year){
            $query->wherehas('parent', function ($q) use ($request){
                $q->where('year', $request->year);
            });
        }

        $appraisalList = $query->get();

        return view('user.appraisal.teamLeadEvaluation.appraisal-list', compact('active', 'evaluationList', 'employeeEvaluationList', 'showAddNewButton', 'alreadyExistEvaluation'));
    }

    public function appraisalRecommendShowByHr($id)
    {
        $userData = YearlyAppraisalChd::find($id);
        return view('user.appraisal.hr.appraisal-recommend', compact('id','userData'));
    }

    public function appraisalApprovedByHr($id, Request $request)
    {
        $data = [
            'approved_by' => auth()->user()->employee_id,
            'approved_status' => Str::lower($request->submit),
            'approval_comments' => $request->hr_comments,
        ];

        YearlyAppraisalChd::find($id)->update($data);
        toastr()->success('Updated Successfully !');
        return redirect()->route('user.hr.appraisal.list');
    }


    public function appraisalListByLead(Request $request)
    {
        $active = 'user-team-appraisal';
        $leadingTeams = auth()->user()->employeeDetails->teamMember()->wherePivotIn('member_type', [TeamMemberType::TEAMLEADER])->get();

        $employeeList = [];
        foreach ($leadingTeams as $value) // Team
        {
            $departmentId = $value->department_id;
            $divisionId = app(\App\Http\Controllers\Admin\Appraisal\AppraisalControllers::class)->getDivision('id');
            $centerId = app(\App\Http\Controllers\Admin\Appraisal\AppraisalControllers::class)->getDivision('id');

            $employeeList = Employee::whereHas('departmentProcess', function ($q) use ($departmentId){
                $q->where('department_id', $departmentId);
            })->whereHas('divisionCenters', function ($q) use ($divisionId, $centerId){
                $q->where('division_id', $divisionId)->where('center_id', $centerId);
            })->whereHas('employeeTeam', function ($q){
                $q->where('member_type', TeamMemberType::MEMBER);
            })->pluck('id')->toArray();
        }

        $employees = YearlyAppraisalChd::with('employee')->get();
        $requestCheck = $request->all();
        if(!$requestCheck){
            $appraisalList = YearlyAppraisalChd::whereIn('employee_id', $employeeList)->with('parent')->get();
            return view('user.appraisal.lead.appraisal-list', compact('active', 'appraisalList', 'employees'));
        }

        $query = YearlyAppraisalChd::whereIn('employee_id', $employeeList)->with('parent');


        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->year){
            $query->wherehas('parent', function ($q) use ($request){
                $q->where('year', $request->year);
            });
        }

        $appraisalList = $query->get();

        return view('user.appraisal.lead.appraisal-list', compact('active', 'appraisalList', 'employees'));
    }

    public function appraisalRecommendByLead($id)
    {
        $userData = YearlyAppraisalChd::find($id);
        return view('user.appraisal.lead.appraisal-recommend', compact('id','userData'));
    }

    public function appraisalRecommendByLeadStore(Request $request, $id)
    {
        $data = [
            'recommendation_by' => auth()->user()->employee_id,
            'recommendation_for' => json_encode($request->recommend, JSON_FORCE_OBJECT),
            'comments'=> $request->remarks
        ];

        YearlyAppraisalChd::where('id',$id)->update($data);
        toastr()->success('Updated Successfully !');
        return redirect()->route('user.lead.appraisal.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function indexMember($team, $evaluation)
    {
        $active = 'user-team-evaluation';
        $members = EmployeeEvaluationListMst::where('team_id', $team)->where('evaluation_id', $evaluation)->get();
        return view('user.appraisal.lead.index-member', compact('active', 'members', 'evaluation'));
    }

    public function memberEvaluationReview($mstId)
    {
        $active = 'user-team-member-evaluation';
        $evaluations = EmployeeEvaluationListMst::where('id', $mstId)->first();
        return view('user.appraisal.lead.evaluation-review', compact('active', 'evaluations', 'mstId'));
    }


    public function storeMemberEvaluationReview(Request $request, $id)
    {
        $teamLead = Employee::find(auth()->user()->employee_id);
        $employee = Employee::find(EmployeeEvaluationListMst::find($id)->employee_id);
        $mstData = [
            'lead_id' => auth()->user()->employee_id,
            'lead_remarks' => $request->lead_remarks,
            'recommendation_for' => json_encode($request->recommend),
            'lead_created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
        ];

        $evaluationListMst = EmployeeEvaluationListMst::find($id)->update($mstData);

        EmployeeEvaluationListChd::where('evaluation_mst',$id)->delete();

        if($evaluationListMst) {
            $data = [];
            for ($key = 1; $key < ($request->arrayCount + 1); $key++) {
                $data[] = [
                    'evaluation_mst' => $id,
                    'qst_type' => $request->has('qstType' . $key) ? $request->{'qstType' . $key} : '',
                    'qst_no' => $request->has('qstNo' . $key) ? $request->{'qstNo' . $key} : '',
                    'qst_mark' => $request->has('qstMark' . $key) ? $request->{'qstMark' . $key} : '',
                    'qst_name' => $request->has('qstName' . $key) ? $request->{'qstName' . $key} : '',
                    'ans_value' => $request->has('ansValue'. $key) ? $request->{'ansValue'.$key} : '',
                    'created_at' => Carbon::parse(Carbon::now())->format('Y-m-d'),
                ];
            }
            EmployeeEvaluationListChd::insert($data);
        }

        Notification::send($employee->userDetails, new EmployeeEvaluationNotification($evaluationListMst, $teamLead->FullName, ' Review your evaluation.', 'user.my.evaluation.list'));

        toastr()->success('Updated Successfully !');
        return redirect()->route('user.lead.evaluation.list');
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


}
