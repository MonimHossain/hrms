<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Center;
use App\Division;
use App\EmployeeDepartmentProcess;
use App\LeaveRule;
use App\Services\TeamService;
use App\Utils\Permissions;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Team;
use App\Department;
use App\EmployeeTeam;
use App\Process;
use App\User;
use App\Utils\LeaveStatus;
use App\TeamWorkflow;
use App\ProcessOrdering;
use App\ProcessSegment;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\DataTables\DataTables;

class TeamController extends Controller
{

    /**
     ** @Function name : Constructor Function
     * @Param :
     * @return void
     *
     */

    public function __constructor()
    {
        $this->middleware('auth');
    }


    /**
     * @method: Team
     * @param :
     * @return void
     *
     */
    public function team()
    {

        $active = 'employee-team';
        $teamAll = Team::all();
        $teamsew = [];
        $teams = Team::whereNull('parent_id')->with('children')->orderBy('name', 'asc')->get()->reduce(function ($teams, $team) {
            $view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? "<a href='" . route('employee.setting.team.list', ['id' => $team->id]) . "' class='editor_edit'><i class='flaticon-eye'></i></a>" : null;
            $edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? "<a target='_blank' href='" . route('employee.setting.team.edit', ['id' => $team->id]) . "' class='editor_edit'><i class='flaticon-edit'></i></a>" : null;
            $delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? "<a href='#' id='" . $team->id . "' class='team_remove'><i class='flaticon-delete'></i></a>" : null;

            $is_functional = ($team->is_functional) ? 'Functional' : "Non-functional";
            $teamName = $team->name . " <span class='kt-badge " . (($team->is_functional) ? 'kt-badge--unified-info' : 'kt-badge--unified-warning') . " kt-badge--inline kt-badge--pill'>" . $is_functional . "</span>";
            $teams[] = [
                'text' => $teamName,
                'nodes' => $this->teamChild($team->children),
                'tags' => [
                    $view .
                        (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' .
                        (($view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete)
                ],
                'href' => route('employee.setting.team.list', ['id' => $team->id])
            ];
            return $teams;
        });


        //return ($teams);
        return view('admin.employee.team.index', compact('active', 'teams', 'teamAll'));
    }

    // get child team recursive
    public function teamChild($team)
    {
        $data = $team->reduce(function ($team, $item) {
            $view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? "<a href='" . route('employee.setting.team.list', ['id' => $item->id]) . "' class='editor_edit'><i class='flaticon-eye'></i></a>" : null;
            $edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? "<a target='_blank' href='" . route('employee.setting.team.edit', ['id' => $item->id]) . "' class='editor_edit'><i class='flaticon-edit'></i></a>" : null;
            $delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? "<a href='" . route('employee.setting.team.delete', ['id' => $item->id]) . "' id='" . $item->id . "' class='employee_remove'><i class='flaticon-delete'></i></a>" : null;


            $is_functional = ($item->is_functional) ? 'Functional' : "Non-functional";
            $teamName = $item->name . " <span class='kt-badge " . (($item->is_functional) ? 'kt-badge--unified-info' : 'kt-badge--unified-warning') . " kt-badge--inline kt-badge--pill'>" . $is_functional . "</span>";
            $team[] = [
                'text' => $teamName,
                'nodes' => ($item->children) ? $this->teamChild($item->children) : null,
                'tags' => [
                    $view .
                        (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' .
                        (($view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete)
                ],
                'href' => route('employee.setting.team.list', ['id' => $item->id])
            ];
            return $team;
        });
        return $data;
    }

    public function teamDataTable()
    {
        $teams = Team::with('employees', 'department', 'process', 'processSegment', 'teamLead')->get();

        return DataTables::of($teams)
            ->addColumn('hot', function ($teams) {
                return optional($teams->teamLead)->FullName;
            })
            ->addColumn('department', function ($teams) {
                return ($teams->department) ? $teams->department->name : '-';
            })
            ->addColumn('process', function ($teams) {
                return (($teams->process) ? $teams->process->name : '') . ' - ' . (($teams->processSegment) ? $teams->processSegment->name : '');
            })
            ->addColumn('department', function ($teams) {
                return ($teams->department) ? $teams->department->name : '-';
            })
            ->addColumn('createdBy', function ($teams) {
                return ($teams->createdBy) ? $teams->createdBy->FullName : '-';
            })
            ->addColumn('updatedBy', function ($teams) {
                return ($teams->updatedBy) ? $teams->updatedBy->FullName : '-';
            })
            ->addColumn('action', function ($teams) {

                $view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? '<a href="' . route('employee.setting.team.list', ["id" => $teams->id]) . '" class="editor_edit"><i class="flaticon-eye"></i></a>' : null;
                $edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? '<a target="_blank" href="' . route('employee.setting.team.edit', ['id' => $teams->id]) . '" class="editor_edit"><i class="flaticon-edit"></i></a>' : null;
                $delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? '<a href="#" id="' . $teams->id . '" class="team_remove"><i class="flaticon-delete"></i></a>' : null;
                return $view .
                    (($view && $edit) ? (' / ' . $edit) : $edit) . ' ' .
                    (($view && $edit && $delete || $view && $delete || $edit && $delete) ? (' / ' . $delete) : $delete);
            })
            ->make(true);
    }


    /**
     * @method: Create Team
     * @param :
     * @return void
     *
     */
    public function createTeam()
    {
        $active = 'employee-team';
        $employees = Employee::has('userDetails')->get();
        $reportingTo = Employee::has('userDetails')->get();
        $divisions = Division::all();
        //$departments = Department::all();
        //$processes = Process::all();
        //$segments = ProcessSegment::all();
        $teams = Team::all();
        return view('admin.employee.team.create', compact('active', 'employees', 'reportingTo', 'teams', 'divisions'));
    }

    public function saveTeam(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'division_id' => 'required',
                'center_id' => 'required',
                'department_id' => 'required',
                //'process_id' => 'required',
                'process_segment_id' => 'required_with:process_id',
                'team_lead_id' => 'required',
                'supervisor.*' => 'different:team_lead_id',
                'is_functional' => 'required'
            ],
            [
                'supervisor.*.different' => 'Team lead and supervisors can not be same.',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }

        $data = $request->except('_token');

        $teamService = new TeamService($data, $request);
        $teamService->createTeam();


        //$team = new Team();
        //$team->name = $data['name'];
        //$team->team_lead_id = $data['team_lead_id'];
        //$team->division_id = $data['division_id'];
        //$team->center_id = $data['center_id'];
        //$team->process_id = $data['process_id'];
        //$team->process_segment_id = $data['process_segment_id'];
        //$team->department_id = $data['department_id'];
        //$team->is_functional = $data['is_functional'];
        //$team->parent_id = ($data['parent_id']) ? $data['parent_id'] : null;
        //$team->created_by = (auth()->user()->employeeDetails) ? auth()->user()->employee_id : Null;
        //$team->created_at = $data['created_at'];
        //
        //if ($team->save()) {
        //    //  Add team leader to team
        //    $team->employees()->attach($data['team_lead_id'], ['member_type' => TeamMemberType::TEAMLEADER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //    if($request->get('is_functional')) {
        //        $team->employees()->where('employee_id', $data['team_lead_id'])->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
        //            'process_id' => $team->process_id,
        //            'process_segment_id' => $team->process_segment_id,
        //            'department_id' => $team->department_id,
        //            'team_id' => $team->id,
        //            'added_at' => Carbon::now()->toDateTimeString()
        //        ]));
        //    }
        //    Employee::find($data['team_lead_id'])->userDetails->givePermissionTo([_permission(Permissions::TEAM_VIEW), _permission(Permissions::USER_ROSTER_CREATE), _permission(Permissions::USER_ROSTER_VIEW)]);
        //}
        //
        //
        //$supervisors = [];
        //if ($request->has('supervisor')) {
        //    foreach ($data['supervisor'] as $key => $item) {
        //        $supervisors[] = [
        //            'stage' => $key,
        //            'supervisor_id' => $item
        //        ];
        //        // Add supervisors to team
        //        if ($item) {
        //            $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //            if($request->get('is_functional')) {
        //                $team->employees()->where('employee_id', $item)->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                    'process_id' => $team->process_id,
        //                    'process_segment_id' => $team->process_segment_id,
        //                    'department_id' => $team->department_id,
        //                    'team_id' => $team->id,
        //                    'added_at' => Carbon::now()->toDateTimeString()
        //                ]));
        //            }
        //            Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW)]);
        //        }
        //    }
        //
        //    $leaveRule = new LeaveRule();
        //    $leaveRule->team_id = $team->id;
        //    $leaveRule->rules = serialize($supervisors);
        //    $leaveRule->save();
        //}


        //toastr()->success('New Team successfully created');

        return redirect()->route('employee.team');
    }

    /**
     * @method:
     * @param :
     * @return void
     *
     */
    public function teamEdit($id)
    {
        $active = 'employee-team';
        $employees = Employee::has('userDetails')->get();
        $team = Team::find($id);
        $supervisors = unserialize($team->leaveRule->rules);
        $divisions = Division::all();
        $centers = $divisions->where('id', $team->division_id)->first()->centers;
        $departments = $centers->where('id', $team->center_id)->first()->departments;
        $processes = ($departments && $team->department_id) ? $departments->where('id', $team->department_id)->first()->processes : null;
        $segments = ($processes && $team->process_id) ? $processes->where('id', $team->process_id)->first()->processSegments : null;
        $teams = Team::where('id', '!=', $team->id)->get();
        return view('admin.employee.team.edit', compact('id', 'team', 'active', 'employees', 'supervisors', 'teams', 'divisions', 'centers', 'departments', 'processes', 'segments'));
    }

    public function updateTeam(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'division_id' => 'required',
                'center_id' => 'required',
                'department_id' => 'required',
                //'process_id' => 'required',
                'process_segment_id' => 'required_with:process_id',
                'team_lead_id' => 'required',
                'supervisor.*' => 'different:team_lead_id',
                'is_functional' => 'required'
            ],
            [
                'supervisor.*.different' => 'Team lead and supervisors can not be same.',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message, '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
            return redirect()->back()->withInput();
        }


        $data = $request->except('_token');

        $teamService = new TeamService($data, $request);
        $teamService->updateTeam();

        //$team = Team::find($request->input('team_id'));
        //
        //$ex_team_lead = $team->employees()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->first();
        //
        ////$team->employees()->detach();
        //$team->name = $data['name'];
        //$team->team_lead_id = $data['team_lead_id'];
        //$team->division_id = $data['division_id'];
        //$team->center_id = $data['center_id'];
        //$team->department_id = $data['department_id'];
        //$team->process_id = $data['process_id'] ?? null;
        //$team->process_segment_id = $data['process_segment_id'] ?? null;
        //$team->parent_id = ($data['parent_id']) ? $data['parent_id'] : null;
        //$team->is_functional = $data['is_functional'];
        //$team->created_by = (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : Null;
        //$team->created_at = $data['created_at'];
        //
        //if ($team->save()) {
        //    //  Add team leader to team
        //    if ($ex_team_lead->id != $data['team_lead_id']) {
        //
        //        $query = $ex_team_lead->departmentProcess()->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //        $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //
        //        $query->delete();
        //        $team->employees()->detach($ex_team_lead->id);
        //        $team->employees()->attach($data['team_lead_id'], ['member_type' => TeamMemberType::TEAMLEADER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //        if ($team->is_functional) {
        //
        //            if ($team->employees->count()){
        //                foreach ($team->employees as $employee){
        //                    $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                        'process_id' => $data['process_id'] ?? null,
        //                        'process_segment_id' => $data['process_segment_id'] ?? null,
        //                        'department_id' => $data['department_id'] ?? null,
        //                        'team_id' => $team->id,
        //                        'added_at' => Carbon::now()->toDateTimeString()
        //                    ]));
        //                }
        //            }
        //        }else {
        //
        //            if ($team->employees->count()){
        //                foreach ($team->employees as $employee){
        //                    $query = $employee->departmentProcess()->where('team_id', $team->id)->where('removed_at', null)->first();
        //                    if($query){
        //                        //$query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //                        $query->forceDelete();
        //                    }
        //                }
        //            }
        //
        //        }
        //        Employee::find($data['team_lead_id'])->userDetails->givePermissionTo([_permission(Permissions::TEAM_VIEW), _permission(Permissions::TEAM_CREATE)]);
        //
        //    } else {
        //        if ($team->is_functional) {
        //            if($ex_team_lead->departmentProcess()->where('team_id', $request->input('team_id'))->count()){
        //                $query = $ex_team_lead->departmentProcess()->where('team_id', $request->input('team_id'))->where('removed_at', null)->update([
        //                    'process_id' => $data['process_id'] ?? null,
        //                    'process_segment_id' => $data['process_segment_id'] ?? null,
        //                    'department_id' => $data['department_id'] ?? null,
        //                ]);
        //            }else {
        //                $ex_team_lead->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                    'process_id' => $data['process_id'] ?? null,
        //                    'process_segment_id' => $data['process_segment_id'] ?? null,
        //                    'department_id' => $data['department_id'] ?? null,
        //                    'team_id' => $team->id,
        //                    'added_at' => Carbon::now()->toDateTimeString()
        //                ]));
        //            }
        //
        //        }else {
        //            $query = $ex_team_lead->departmentProcess()->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //
        //            if($query){
        //                $query->forceDelete();
        //            }
        //        }
        //
        //    }
        //
        //    $supervisors = [];
        //    if ($request->has('supervisor')) {
        //
        //        foreach ($team->employees()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get() as $emp){
        //            $team->employees()->detach($emp->id);
        //            $query = Employee::find($emp->id)->departmentProcess()->where('team_id', $team->id)->where('removed_at', null)->first();
        //            if($query){
        //                $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //                $query->delete();
        //
        //            }
        //        }
        //
        //        foreach ($data['supervisor'] as $key => $item) {
        //            if ($item) {
        //                $supervisors[] = [
        //                    'stage' => $key,
        //                    'supervisor_id' => $item
        //                ];
        //                // Add supervisors to team
        //                $ex_supervisor = $team->employees()->where('employee_id', $item)->wherePivot('member_type', TeamMemberType::SUPERVISOR)->first();
        //
        //                if ($ex_supervisor && ($ex_supervisor->id == $item)) {
        //
        //                    if ($team->is_functional) {
        //                        $query = EmployeeDepartmentProcess::where('employee_id', $item)->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //                        if ($query) {
        //                            $query->process_id = $data['process_id'] ?? null;
        //                            $query->process_segment_id = $data['process_segment_id'] ?? null;
        //                            $query->department_id = $data['department_id'] ?? null;
        //                            $query->save();
        //                        } else {
        //
        //                            EmployeeDepartmentProcess::create([
        //                                'employee_id' => $item,
        //                                'process_id' => $data['process_id'] ?? null,
        //                                'process_segment_id' => $data['process_segment_id'] ?? null,
        //                                'department_id' => $data['department_id'] ?? null,
        //                                'team_id' => $team->id,
        //                                'added_at' => Carbon::now()->toDateTimeString()
        //                            ]);
        //                        }
        //                    }else {
        //                        $query = EmployeeDepartmentProcess::where('employee_id', $item)->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //                        if($query){
        //                            $query->forceDelete();
        //                        }
        //                    }
        //                    Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
        //
        //                } elseif ($ex_supervisor) {
        //
        //                    $query = $ex_supervisor->departmentProcess()->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //                    if ($query) {
        //                        $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //                        $query->delete();
        //                        $team->employees()->detach($ex_supervisor->id);
        //                        $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //                        if ($team->is_functional) {
        //                            $query->forceDelete();
        //                            Employee::find($item)->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                                'process_id' => $data['process_id'] ?? null,
        //                                'process_segment_id' => $data['process_segment_id'] ?? null,
        //                                'department_id' => $data['department_id'] ?? null,
        //                                'team_id' => $team->id,
        //                                'added_at' => Carbon::now()->toDateTimeString()
        //                            ]));
        //                        }else {
        //
        //                            if($query){
        //                                $query->forceDelete();
        //                            }
        //                        }
        //                        Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
        //                    } else {
        //                        $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //                        if ($team->is_functional) {
        //                            Employee::find($item)->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                                'process_id' => $data['process_id'] ?? null,
        //                                'process_segment_id' => $data['process_segment_id'] ?? null,
        //                                'department_id' => $data['department_id'] ?? null,
        //                                'team_id' => $team->id,
        //                                'added_at' => Carbon::now()->toDateTimeString()
        //                            ]));
        //                        }
        //                        Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
        //                    }
        //                } else {
        //                    $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
        //                    if ($team->is_functional) {
        //
        //                        $team->employees()->where('employee_id', $item)->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                            'process_id' => $team->process_id,
        //                            'process_segment_id' => $team->process_segment_id,
        //                            'department_id' => $team->department_id,
        //                            'team_id' => $team->id,
        //                            'added_at' => Carbon::now()->toDateTimeString()
        //                        ]));
        //
        //                    }else {
        //
        //                        $q = $team->employees()->where('employee_id', $item)->first();
        //                        if ($q){
        //                            $q->departmentProcess()->forceDelete();
        //                        }
        //                    }
        //                    //dd($item);
        //                    Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW)]);
        //                }
        //            }
        //        }
        //
        //        $teamMembers = $team->employees()->wherePivot('member_type', '!=', TeamMemberType::TEAMLEADER)->wherePivot('member_type', '!=', TeamMemberType::SUPERVISOR)->get();
        //
        //        if ($team->is_functional) {
        //
        //            if ($teamMembers->count()){
        //                foreach ($teamMembers as $employee){
        //                    $employee->departmentProcess()->where('team_id', $request->input('team_id'))->forceDelete();
        //
        //                    $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
        //                        'process_id' => $team->process_id,
        //                        'process_segment_id' => $team->process_segment_id,
        //                        'department_id' => $team->department_id,
        //                        'team_id' => $team->id,
        //                        'added_at' => Carbon::now()->toDateTimeString()
        //                    ]));
        //                }
        //            }
        //        }else {
        //            if ($team->employees->count()){
        //                foreach ($teamMembers as $employee){
        //                    $query = $employee->departmentProcess()->where('team_id', $team->id)->where('removed_at', null)->first();
        //                    if($query){
        //                        //$query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //                        $query->forceDelete();
        //                    }
        //                }
        //            }
        //
        //        }
        //
        //        $leaveRule = $team->leaveRule;
        //        $leaveRule->team_id = $team->id;
        //        $leaveRule->rules = serialize($supervisors);
        //        $leaveRule->save();
        //    }
        //
        //    if ($team->is_functional) {
        //        $members = $team->employees()->wherePivot('member_type', '!=', TeamMemberType::TEAMLEADER)->wherePivot('member_type', '!=', TeamMemberType::SUPERVISOR)->get();
        //        foreach ($members as $member) {
        //            $hasPivot = Employee::where('id', $member->id)->whereHas('teamMember', function ($query) use ($team) {
        //                $query->where('member_type', TeamMemberType::MEMBER);
        //            })->exists();
        //            //dd('ok');
        //            if ($hasPivot) {
        //                $member->teamMember()->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
        //            }else{
        //                $member->teamMember()->updateExistingPivot($team->id, ['member_type' => TeamMemberType::MEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
        //            }
        //
        //            $query = EmployeeDepartmentProcess::where('employee_id', $member->id)->where('team_id', $request->input('team_id'))->where('removed_at', null)->first();
        //            $query->process_id = $data['process_id'] ?? null;
        //            $query->process_segment_id = $data['process_segment_id'] ?? null;
        //            $query->department_id = $data['department_id'] ?? null;
        //            $query->save();
        //        }
        //    }else{
        //        $members = $team->employees()->wherePivot('member_type', '!=', TeamMemberType::TEAMLEADER)->wherePivot('member_type', '!=', TeamMemberType::SUPERVISOR)->get();
        //        foreach ($members as $member) {
        //            $hasPivot = Employee::where('id', $member->id)->whereHas('teamMember', function ($query) use ($team) {
        //                $query->where('member_type', TeamMemberType::MEMBER);
        //            })->exists();
        //            if (!$hasPivot) {
        //                $member->teamMember()->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
        //            }else{
        //                $member->teamMember()->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
        //            }
        //            $query = EmployeeDepartmentProcess::where('employee_id', $member->id)->where('team_id', $request->input('team_id'))->first();
        //            if($query){
        //                //$query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
        //                $query->forceDelete();
        //            }
        //        }
        //    }
        //
        //
        //
        //}


        //toastr()->success('New Team successfully created');

        return redirect()->route('employee.team');
    }

    public function teamDelete($id)
    {
        $team = Team::where('id', $id)->first();
        if (!$team->children->count()) {
            foreach ($team->employees as $employee) {
                $query = $employee->departmentProcess()->where('team_id', $id)->where('removed_at', null)->first();
                if ($query) {
                    $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
                    $query->delete();
                }
            }
            $team->delete();
            toastr()->success('Team successfully deleted');
        } else {
            toastr()->error('Delete child team first.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        }
        return redirect()->route('employee.team');
    }

    public function teamList($id)
    {
        $active = 'employee-team';
        $teams = Team::all();
        $teamList = Team::where('id', $id)->with(['employees', 'employees.employeeJourney'])->first();
        return view('admin.employee.team.team-member-list', compact(
            'active',
            'teams',
            'teamList',
            'id'
        ));
    }

    public function createTeamMember($id)
    {
        $active = 'employee-team';
        $team = Team::find($id);
        foreach ($team->employees as $employee) {
            $data[] = $employee->id;
        }

        $employees = Employee::has('userDetails')
            ->whereNotIn('id', $data)
            ->get();
        $processes = Process::all();
        $departments = Department::all();
        return view('admin.employee.team.create-team-member', compact('active', 'employees', 'processes', 'departments', 'id'));
    }

    public function saveTeamMember(Request $request)
    {
        // dd($request->all());
        $employee = Employee::find($request->input('employee_id'));
        $teamID = $request->input('team_id');
        $hasPivot = Employee::where('id', $request->input('employee_id'))->whereHas('teamMember', function ($query) use ($teamID) {
            $query->where('member_type', TeamMemberType::MEMBER);
        })->exists();
        $team = Team::where('id', $teamID)->first();

        if (!$hasPivot) {
            $employee->teamMember()->attach($teamID, ['member_type' => ($team->is_functional) ? TeamMemberType::MEMBER : TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => $request->input('created_at')]);
            if ($team->is_functional) {
                $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
                    'process_id' => $team->process_id,
                    'process_segment_id' => $team->process_segment_id,
                    'department_id' => $team->department_id,
                    'team_id' => $team->id,
                    'added_at' => $request->input('created_at')
                ]));
            }
            toastr()->success('Add New Member successfully!');
        } else {
            $employee->teamMember()->attach($teamID, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => $request->input('created_at')]);
            if ($team->is_functional) {
                $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
                    'process_id' => $team->process_id,
                    'process_segment_id' => $team->process_segment_id,
                    'department_id' => $team->department_id,
                    'team_id' => $team->id,
                    'added_at' => $request->input('created_at')
                ]));
            }
            toastr()->warning($employee->first_name . ' belongs to ' . $employee->teamMember[0]->name . ' team.')->success($employee->first_name . ' added successfully as an assoc. member.');
        }

        return redirect()->route('employee.setting.team.list', $teamID);
    }

    public function removeTeamMember($employee, $teamId)
    {
        $team = Team::find($teamId);
        $team->employees()->detach($employee);
        $query = Employee::find($employee)->departmentProcess()->where('team_id', $teamId)->where('removed_at', null)->first();
        if ($query) {
            $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
            $query->delete();
        }
        $supervisors = [];
        foreach ($team->employees()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get() as $key => $supervisor) {
            $supervisors[] = [
                'stage' => $key,
                'supervisor_id' => $supervisor->id
            ];
        }

        if ($supervisors) {
            $leaveRule = $team->leaveRule;
            $leaveRule->team_id = $team->id;
            $leaveRule->rules = serialize($supervisors);
            $leaveRule->save();
        }



        toastr()->success('Member has removed successfully');

        return redirect()->route('employee.setting.team.list', $teamId);
    }


    public function transferTeamMember(Request $request)
    {
        // validate request
        $validator = Validator::make(
            $request->all(),
            [
                'team_id' => 'required',
                'employee_id' => 'required',
                'transfer_team_id' => 'required',
                'added_at' => 'required'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                toastr()->error($message);
            }
            return redirect()->back()->withInput();
        }

        // transfer team member
        $teamService = new TeamService(null, $request);
        $transferTeam = $teamService->transferTeamMember();

        if ($transferTeam) {
            toastr()->success("Member successfully transfered to the .$transferTeam->name.", '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        } else {
            toastr()->error("Something went wrong!");
        }

        return redirect()->back();
    }

    //




    /**
     * @method:
     * @param :
     * @return void
     *
     */

    public function getAllSegment(Request $request)
    {
        $processSegment = ProcessSegment::where('process_id', $request->input('id'))->get();
        $data = '';
        foreach ($processSegment as $segment) {
            $data .= '<option value="' . $segment->id . '">' . $segment->name . '</option>';
        }
        return $data;
    }


    //    public function teamJsonData ()
    //    {
    //        $userId = auth()->user()->id;
    //        $team = Team::Orwhere('team_lead_id', $userId)->Orwhere('reporting_to_id_one', $userId)->OrWhere('reporting_to_id_two', $userId)->OrWhere('reporting_to_id_three', $userId)->get();
    //        $data = $team->reduce(function($teamData, $values){
    //            $item['id'] = $values->id;
    //            $item['team_name'] = $values->name;
    //            $item['lemp_name'] = $values->teamleadEmployee->FullName;
    //            $item['bemp_name'] = $values->supOneEmployee->FullName;
    //            $item['cemp_name'] = $values->supTwoEmployee->FullName;
    //            $item['demp_name'] = $values->supThreeEmployee->FullName;
    //            $item['demaprtment'] = $values->demaprtmentName->name;
    //            $item['process'] = $values->processName->name;
    //            $teamData[] = $item;
    //            return $teamData;
    //        });
    //        return json_encode($data);
    //    }


    //    public function saveTeam (Request $request)
    //    {
    //        $data = $request->except('_token');
    //        $team = Team::create($data);
    //        $teamWorkFlowId = TeamWorkflow::create(['team_id'=> $team->id, 'workflow_id'=>LeaveStatus::LEAVE]);
    //        $processOrdering = [
    //            [
    //                'order_number' => 1,
    //                'emp_id' => $team->reporting_to_id_one,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ],
    //            [
    //                'order_number' => 2,
    //                'emp_id' => $team->reporting_to_id_two,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ],
    //            [
    //                'order_number' => 3,
    //                'emp_id' => $team->reporting_to_id_three,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ]
    //        ];
    //        $status = ProcessOrdering::insert($processOrdering);
    //        if($status){
    //            Employee::find($data['team_lead_id'])->userDetails->givePermissionTo(['Team View', 'Team Create']);
    //            toastr()->success('New Team successfully created');
    //        }
    //        return redirect()->route('employee.team');
    //    }


    //    public function updateTeam(Request $request)
    //    {
    //        $data = $request->except('_token');
    //        $team = Team::where('id', $data['fld_id'])->first();
    //        $team->update([
    //            'team_lead_id' => $data['team_lead_id'],
    //            'reporting_to_id_one' => $data['reporting_to_id_one'],
    //            'reporting_to_id_two' => $data['reporting_to_id_two'],
    //            'reporting_to_id_three' => $data['reporting_to_id_three'],
    //            'process' => $data['process'],
    //            'process_segment' => $data['process_segment'],
    //            'demaprtment' => $data['demaprtment'],
    //            'name' => $data['name']
    //        ]);
    //
    //
    //        $teamWorkFlowId = TeamWorkflow::where('team_id', $data['fld_id'])->where('workflow_id', LeaveStatus::LEAVE)->first();
    //
    //
    //        $processOrdering = [
    //            [
    //                'order_number' => 1,
    //                'emp_id' => $team->reporting_to_id_one,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ],
    //            [
    //                'order_number' => 2,
    //                'emp_id' => $team->reporting_to_id_two,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ],
    //            [
    //                'order_number' => 3,
    //                'emp_id' => $team->reporting_to_id_three,
    //                'team_workflow_id' => $teamWorkFlowId->id
    //            ]
    //        ];
    //
    //        if ($data['process_ordering'] == 'yes') {
    //            ProcessOrdering::destroy($teamWorkFlowId->id);
    //            ProcessOrdering::insert($processOrdering);
    //        }
    //
    //        Employee::find($data['team_lead_id'])->userDetails->givePermissionTo('Team Leader');
    //        toastr()->success('New Team successfully created');
    //
    //        return redirect()->route('employee.team');
    //    }


    //    public function teamDelete($id)
    //    {
    //        Team::where('id', $id)->delete();
    //        return redirect()->route('employee.team');
    //    }


    //    public function teamList($id)
    //    {
    //        $active = 'employee-team';
    //        $teamList = EmployeeTeam::where('team_id', $id)->get();
    //        return view('admin.employee.team.team-member-list', compact('active', 'teamList', 'id'));
    //    }


    //    public function createTeamMember($id)
    //    {
    //        $active = 'employee-team';
    //        $employees = Employee::doesntHave('employeeTeam')->doesntHave('teamCheck')->get();
    //        $processes = Process::all();
    //        $departments = Department::all();
    //        return view('admin.employee.team.create-team-member', compact('active', 'employees', 'processes', 'departments', 'id'));
    //    }


    //    public function saveTeamMember(Request $request)
    //    {
    //        $employee = $request->input('employee_id');
    //        $team = $request->input('team_id');
    //        $data = [
    //            'employee_id' => $employee,
    //            'team_id' => $team,
    //        ];
    //        $status = EmployeeTeam::insert($data);
    //        if ($status) {
    //            toastr()->success('Add New Member successfully!');
    //        }
    //        return redirect()->route('employee.setting.team.list', $team);
    //    }


    //    public function removeTeamMember($employee, $id)
    //    {
    //
    //        EmployeeTeam::where('employee_id', $employee)->delete();
    //        toastr()->success('Member has removed successfully');
    //
    //        return redirect()->route('employee.setting.team.list', $id);
    //    }
    //

    public function employeeTeam(Request $request)
    {
        $active = 'employee-team-list';
        $employees = Employee::has('userDetails')->get();
        $employee_teams = [];
        if ($request->employee_id) {
            $employee_teams = Employee::where('id', $request->employee_id)->first();
        }
        return view('admin.employee.team.employee-team-list', compact('active', 'employees', 'employee_teams'));
    }
}
