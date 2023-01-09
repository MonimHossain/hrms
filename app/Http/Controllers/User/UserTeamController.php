<?php

namespace App\Http\Controllers\User;

use App\Utils\Permissions;
use App\Utils\TeamMemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Roster;
use Validator;
use Carbon\Carbon;
use App\RosterRequest;
use App\EmployeeTeam;
use App\Process;
use App\Department;
use App\Employee;
use Illuminate\Support\Facades\DB;

class UserTeamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function teamListView()
    {
        $active = 'my-team-list';
        //        $teamLeadLists = Team::join('employee_team', function ($q) {
        //            $q->on('employee_team.team_id', 'teams.id');
        //            $q->where('employee_team.employee_id', auth()->user()->employee_id);
        //            $q->where('employee_team.member_type', TeamMemberType::TEAMLEADER);
        //        })->select([
        //            'teams.*', 'employee_team.member_type',
        //        ])->get();

        $employee = Employee::whereId(\auth()->user()->employee_id)->first();
        $leadingTeam = $employee->teamMember()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->withoutGlobalScopes()->get();
        $teamLeadLists = $employee->teamMember()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->withoutGlobalScopes()->get();
        // dd($teamLeadLists);
        $teamIds = [];
        foreach ($teamLeadLists as $teamId) {
            $teamIds[] = $teamId->id;
        }
        $teamLeadListsHasNotChild = $employee->teamMember()->doesntHave('children')->whereNotIn('parent_id', $teamIds)->wherePivot('member_type', \App\Utils\TeamMemberType::TEAMLEADER)->get();
        $teamSuperviseLists = $employee->teamMember()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get();
        $teamBelongLists = $employee->teamMember()->wherePivotIn('member_type', [TeamMemberType::MEMBER, TeamMemberType::ASSTMEMBER])->get();


        $teamTree = $teamLeadLists->reduce(function ($teams, $team) {
            //$view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? "<a href='".route('employee.setting.team.list', ['id' => $team->id])."' class='editor_edit'><i class='flaticon-eye'></i></a>" : null;
            //$edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? "<a target='_blank' href='".route('employee.setting.team.edit', ['id'=> $team->id])."' class='editor_edit'><i class='flaticon-edit'></i></a>" : null;
            //$delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? "<a href='#' id='".$team->id."' class='team_remove'><i class='flaticon-delete'></i></a>" : null;
            // dd($team);
            $is_functional = ($team->is_functional) ? 'Functional' : "Non-functional";
            $teamName = $team->name . " <span class='kt-badge " . (($team->is_functional) ? 'kt-badge--unified-info' : 'kt-badge--unified-warning') . " kt-badge--inline kt-badge--pill'>" . $is_functional . "</span>";
            $teams[] = [
                'text' => $teamName,
                'nodes' => $this->teamChild($team->children),
                //'tags' => [
                //    $view.
                //    (($view && $edit) ? ( ' / '.$edit) : $edit).' '.
                //    (($view && $edit && $delete || $view && $delete || $edit && $delete ) ? ( ' / '.$delete) : $delete)
                //],
                'href' => route('user.team.member.list.view', ['id' => $team->id])
            ];
            return $teams;
        });

        // dd($teamTree);

        return view('user.team.team-list', compact(
            'active',
            'leadingTeam',
            'teamLeadLists',
            'teamLeadListsHasNotChild',
            'teamSuperviseLists',
            'teamBelongLists',
            'teamTree'
        ));
    }

    // get child team recursive
    public function teamChild($team)
    {
        $data = $team->reduce(function ($team, $item) {
            //$view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? "<a href='".route('employee.setting.team.list', ['id' => $item->id])."' class='editor_edit'><i class='flaticon-eye'></i></a>" : null;
            //$edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? "<a target='_blank' href='".route('employee.setting.team.edit', ['id'=> $item->id])."' class='editor_edit'><i class='flaticon-edit'></i></a>" : null;
            //$delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? "<a href='".route('employee.setting.team.delete', ['id'=> $item->id])."' id='".$item->id."' class='employee_remove'><i class='flaticon-delete'></i></a>" : null;


            $is_functional = ($item->is_functional) ? 'Functional' : "Non-functional";
            $teamName = $item->name . " <span class='kt-badge " . (($item->is_functional) ? 'kt-badge--unified-info' : 'kt-badge--unified-warning') . " kt-badge--inline kt-badge--pill'>" . $is_functional . "</span>";
            $team[] = [
                'text' => $teamName,
                'nodes' => ($item->children) ? $this->teamChild($item->children) : null,
                //'tags' => [
                //    $view.
                //    (($view && $edit) ? ( ' / '.$edit) : $edit).' '.
                //    (($view && $edit && $delete || $view && $delete || $edit && $delete ) ? ( ' / '.$delete) : $delete)
                //],
                'href' => route('user.team.member.list.view', ['id' => $item->id])
            ];
            return $team;
        });
        return $data;
    }

    public function teamMemberListView($id)
    {
        $active = 'my-team-list';
        $user_id = $id;
        $team = Team::withoutGlobalScopes()->where('id', $id)->first();
        $teamMemberLists = $team->employees()->select('employees.id', 'first_name', 'last_name', 'email', 'employer_id', 'gender', 'contact_number', 'profile_image')->with(['employeeJourney', 'employeeJourney.designation'])->get();
        return view('user.team.team-member-list', compact(
            'active',
            'user_id',
            'team',
            'teamMemberLists'
        ));
    }


    public function addTeamMemberByUser($id)
    {
        $active = 'employee-team';
        $employees = Employee::doesntHave('employeeTeam')->doesntHave('teamCheck')->get();
        return view('user.team.create-team-member', compact('active', 'employees', 'id'));
    }


    public function saveTeamMemberByUser(Request $request)
    {
        $employee = $request->input('employee_id');
        $team = $request->input('team_id');
        $data = [
            'employee_id' => $employee,
            'team_id' => $team,
        ];
        $status = EmployeeTeam::insert($data);
        if ($status) {
            toastr()->success('Add New Member successfully!');
        }
        return redirect()->route('user.team.member.list.view', $team);
    }


    public function removeTeamMemberByUser($employee, $id)
    {
        EmployeeTeam::where('employee_id', $employee)->delete();
        toastr()->success('Member has removed successfully');

        return redirect()->route('user.team.member.list.view', [$id]);
    }


    public function createTeamRosterView($id)
    {
        $active = 'my-team-list';
        $rosters = Roster::all();
        $teamMemberLists = Team::find($id)->employees()->select('employees.id', 'first_name', 'last_name', 'employer_id')->get();
        return view('user.team.create-team-roster', compact('active', 'rosters', 'teamMemberLists'));
    }


    public function createTeamRosterSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'roster_id' => 'required',
            'employee_id' => 'required',
            'off_days' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Please fill all fields.');
            return redirect()->back();
        }

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        // set weekend
        Carbon::setWeekendDays($request->input('off_days'));
        while (strtotime($start_date) <= strtotime($end_date)) {
            // $rosterRequests = new RosterRequest();
            // $rosterRequests->employee_id = Auth::user()->employee_id;
            // $rosterRequests->date = $start_date;

            $rosterRequests = RosterRequest::firstOrNew(['employee_id' => $request->input('employee_id'), 'date' => $start_date]);

            if (Carbon::create($start_date)->isWeekend()) {
                $rosterRequests->roster_id = null;
                $rosterRequests->is_offday = 1;
            } else {
                $rosterRequests->roster_id = $request->input('roster_id');
            }

            // $rosterRequests->off_days = serialize($request->input('off_days'));

            $rosterRequests->is_revised = 1;

            $rosterRequests->save();
            $start_date = date("Y-m-d", strtotime("+1 days", strtotime($start_date)));
        }

        toastr()->success('Your roster generated successfully. Please revised and submit for approval.');

        // return redirect()->route('user.roster.review.view');
        return redirect()->back();
    }
}
