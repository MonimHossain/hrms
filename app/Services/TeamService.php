<?php

namespace App\Services;

use App\Employee;
use App\EmployeeDepartmentProcess;
use App\LeaveRule;
use App\Team;
use App\Utils\Permissions;
use App\Utils\TeamMemberType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeamService
{
    private $data, $request;

    public function __construct($data = null, $request = null)
    {
        $this->data = $data;
        $this->request = $request;
    }

    // create team
    public function createTeam()
    {
        $team = new Team();
        $team->name = $this->data['name'];
        $team->team_lead_id = $this->data['team_lead_id'];
        $team->division_id = $this->data['division_id'];
        $team->center_id = $this->data['center_id'];
        $team->process_id = $this->data['process_id'];
        $team->process_segment_id = $this->data['process_segment_id'];
        $team->department_id = $this->data['department_id'];
        $team->is_functional = $this->data['is_functional'];
        $team->parent_id = ($this->data['parent_id']) ? $this->data['parent_id'] : null;
        $team->created_by = (auth()->user()->employeeDetails) ? auth()->user()->employee_id : Null;
        $team->created_at = $this->data['created_at'];
        DB::transaction(function () use ($team) {
            if ($team->save()) {
                // add teamleader
                $this->addTeamLead($team);
                // add supervisors
                $this->addSupervisor($team);
                toastr()->success('New Team successfully created');
            } else {
                toastr()->error('New team creation failed.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
        });
    }

    // update team
    public function updateTeam()
    {
        $team = Team::find($this->request->input('team_id'));
        $ex_team_lead = $team->employees()->wherePivot('member_type', TeamMemberType::TEAMLEADER)->first();
        $prev_team_func = $team->is_functional;
        $team->name = $this->data['name'];
        $team->team_lead_id = $this->data['team_lead_id'];
        $team->division_id = $this->data['division_id'];
        $team->center_id = $this->data['center_id'];
        $team->process_id = $this->data['process_id'];
        $team->process_segment_id = $this->data['process_segment_id'];
        $team->department_id = $this->data['department_id'];
        $team->is_functional = $this->data['is_functional'];
        $team->parent_id = ($this->data['parent_id']) ? $this->data['parent_id'] : null;
        $team->created_by = (auth()->user()->employeeDetails) ? auth()->user()->employee_id : Null;
        $team->created_at = $this->data['created_at'];
        DB::transaction(function () use ($team, $ex_team_lead, $prev_team_func) {
            if ($team->save()) {
                // add teamleader
                $this->addTeamLead($team, $ex_team_lead);
                // add supervisors
                $this->addSupervisor($team, $update = 1);
                // update team member department process
                $this->updateTeamEmployeesDepartmentProcess($team, $prev_team_func);

                toastr()->success('Team successfully updated');
            } else {
                toastr()->error('Team updating failed.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
            }
        });
    }

    // add team leader to team
    public function addTeamLead($team, $ex_team_lead = null)
    {
        //dd($ex_team_lead->id != $this->data['team_lead_id']);
        //dd($ex_team_lead);
        if ($ex_team_lead == null) { // when new team create

            $team->employees()->attach($this->data['team_lead_id'], ['member_type' => TeamMemberType::TEAMLEADER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
            if ($this->data['is_functional']) {
                $team->employees()->where('employee_id', $this->data['team_lead_id'])->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
                    'process_id' => $team->process_id,
                    'process_segment_id' => $team->process_segment_id,
                    'department_id' => $team->department_id,
                    'team_id' => $team->id,
                    'added_at' => Carbon::now()->toDateTimeString()
                ]));
            }
            Employee::find($this->data['team_lead_id'])->userDetails->givePermissionTo([_permission(Permissions::TEAM_VIEW), _permission(Permissions::USER_ROSTER_CREATE), _permission(Permissions::USER_ROSTER_VIEW)]);
        } elseif ($ex_team_lead->id != $this->data['team_lead_id']) { // update new team lead details
            //remove ex team lead
            $query = $ex_team_lead->departmentProcess()->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
            $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
            $query->delete();
            $team->employees()->detach($ex_team_lead->id);

            // add new team lead
            $team->employees()->attach($this->data['team_lead_id'], ['member_type' => TeamMemberType::TEAMLEADER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);

            $teamEmployees = $team->employees;
            $teamEmployeesCount = $teamEmployees->count();
            if ($team->is_functional) {
                if ($teamEmployeesCount) {
                    foreach ($teamEmployees as $employee) {
                        //$employee->departmentProcess()->save(new EmployeeDepartmentProcess([
                        //    'process_id' => $data['process_id'] ?? null,
                        //    'process_segment_id' => $data['process_segment_id'] ?? null,
                        //    'department_id' => $data['department_id'] ?? null,
                        //    'team_id' => $team->id,
                        //    'added_at' => Carbon::now()->toDateTimeString()
                        //]));
                        EmployeeDepartmentProcess::updateOrCreate(
                            [
                                'employee_id' => $employee->id,
                                'team_id' => $team->id,
                                'removed_at' => null
                            ],
                            [
                                'process_id' => $this->data['process_id'] ?? null,
                                'process_segment_id' => $this->data['process_segment_id'] ?? null,
                                'department_id' => $this->data['department_id'] ?? null,
                                'added_at' => Carbon::now()->toDateTimeString()
                            ]
                        );
                    }
                }
            } else {
                if ($teamEmployeesCount) {
                    foreach ($teamEmployees as $employee) {
                        $query = $employee->departmentProcess()->where('team_id', $team->id)->where('removed_at', null)->first();
                        dd($query);
                        if ($query) {
                            $query->forceDelete();
                        }
                    }
                }
            }
            Employee::find($this->data['team_lead_id'])->userDetails->givePermissionTo([_permission(Permissions::TEAM_VIEW), _permission(Permissions::TEAM_CREATE)]);
        } else { // update existing team lead details
            if ($team->is_functional) { // update team lead details
                if ($ex_team_lead->departmentProcess()->where('team_id', $this->request->input('team_id'))->count()) {
                    $query = $ex_team_lead->departmentProcess()->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->update([
                        'process_id' => $this->data['process_id'] ?? null,
                        'process_segment_id' => $this->data['process_segment_id'] ?? null,
                        'department_id' => $this->data['department_id'] ?? null,
                    ]);
                } else {

                    $ex_team_lead->departmentProcess()->save(new EmployeeDepartmentProcess([
                        'process_id' => $this->data['process_id'] ?? null,
                        'process_segment_id' => $this->data['process_segment_id'] ?? null,
                        'department_id' => $this->data['department_id'] ?? null,
                        'team_id' => $team->id,
                        'added_at' => Carbon::now()->toDateTimeString()
                    ]));
                }
            } else {
                $query = $ex_team_lead->departmentProcess()->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
                if ($query) {
                    $query->forceDelete();
                }
            }
        }
    }

    // add supervisor to the team
    public function addSupervisor($team, $update = 0)
    {
        $supervisors = [];
        if (!$update) {
            if ($this->request->has('supervisor')) {
                foreach ($this->data['supervisor'] as $key => $item) {
                    $supervisors[] = [
                        'stage' => $key,
                        'supervisor_id' => $item
                    ];
                    // Add supervisors to team
                    if ($item) {
                        $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
                        if ($this->request->get('is_functional')) {
                            $team->employees()->where('employee_id', $item)->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
                                'process_id' => $team->process_id,
                                'process_segment_id' => $team->process_segment_id,
                                'department_id' => $team->department_id,
                                'team_id' => $team->id,
                                'added_at' => Carbon::now()->toDateTimeString()
                            ]));
                        }
                        Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW)]);
                    }
                }

                $leaveRule = new LeaveRule();
                $leaveRule->team_id = $team->id;
                $leaveRule->rules = serialize($supervisors);
                $leaveRule->save();
            }
        } else {
            if ($this->request->has('supervisor')) {
                foreach ($team->employees()->wherePivot('member_type', TeamMemberType::SUPERVISOR)->get() as $emp) {
                    $team->employees()->detach($emp->id);
                    $query = $emp->departmentProcess()->where('team_id', $team->id)->where('removed_at', null)->first();
                    if ($query) {
                        //$query->forceDelete();
                        if ($team->is_functional) {
                            $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
                            $query->delete();
                        } else {
                            $query->forceDelete();
                        }
                    }
                }

                foreach ($this->data['supervisor'] as $key => $item) {
                    if ($item) {
                        $supervisors[] = [
                            'stage' => $key,
                            'supervisor_id' => $item
                        ];

                        // Add supervisors to team
                        $ex_supervisor = $team->employees()->where('employee_id', $item)->wherePivot('member_type', TeamMemberType::SUPERVISOR)->first();
                        if ($ex_supervisor && ($ex_supervisor->id == $item)) {
                            if ($team->is_functional) {
                                $query = EmployeeDepartmentProcess::where('employee_id', $item)->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
                                if ($query) {
                                    $query->process_id = $this->data['process_id'] ?? null;
                                    $query->process_segment_id = $this->data['process_segment_id'] ?? null;
                                    $query->department_id = $this->data['department_id'] ?? null;
                                    $query->save();
                                } else {
                                    EmployeeDepartmentProcess::create([
                                        'employee_id' => $item,
                                        'process_id' => $this->data['process_id'] ?? null,
                                        'process_segment_id' => $this->data['process_segment_id'] ?? null,
                                        'department_id' => $this->data['department_id'] ?? null,
                                        'team_id' => $team->id,
                                        'added_at' => Carbon::now()->toDateTimeString()
                                    ]);
                                }
                            } else {
                                $query = EmployeeDepartmentProcess::where('employee_id', $item)->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
                                if ($query) {
                                    $query->forceDelete();
                                }
                            }
                            Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
                        } elseif ($ex_supervisor) {
                            $query = $ex_supervisor->departmentProcess()->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
                            if ($query) {
                                $newSup = Employee::find($item);
                                if ($team->is_functional) {
                                    $query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
                                    $query->delete();
                                    $team->employees()->detach($ex_supervisor->id);
                                    $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
                                    if (!$newSup->departmentProcess()->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->exists()) {
                                        $newSup->departmentProcess()->save(new EmployeeDepartmentProcess([
                                            'process_id' => $this->data['process_id'] ?? null,
                                            'process_segment_id' => $this->data['process_segment_id'] ?? null,
                                            'department_id' => $this->data['department_id'] ?? null,
                                            'team_id' => $team->id,
                                            'added_at' => Carbon::now()->toDateTimeString()
                                        ]));
                                    }
                                } else {
                                    if ($query) {
                                        $query->forceDelete();
                                    }
                                }
                                Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
                            } else {
                                $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
                                if ($team->is_functional) {
                                    Employee::find($item)->departmentProcess()->save(new EmployeeDepartmentProcess([
                                        'process_id' => $this->data['process_id'] ?? null,
                                        'process_segment_id' => $this->data['process_segment_id'] ?? null,
                                        'department_id' => $this->data['department_id'] ?? null,
                                        'team_id' => $team->id,
                                        'added_at' => Carbon::now()->toDateTimeString()
                                    ]));
                                }
                                Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW), _permission(Permissions::SUPERVISOR_CREATE)]);
                            }
                        } else {
                            $team->employees()->attach($item, ['member_type' => TeamMemberType::SUPERVISOR, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null]);
                            if ($team->is_functional) {

                                $team->employees()->where('employee_id', $item)->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
                                    'process_id' => $team->process_id,
                                    'process_segment_id' => $team->process_segment_id,
                                    'department_id' => $team->department_id,
                                    'team_id' => $team->id,
                                    'added_at' => Carbon::now()->toDateTimeString()
                                ]));
                            } else {

                                $q = $team->employees()->where('employee_id', $item)->first();
                                if ($q) {
                                    $q->departmentProcess()->forceDelete();
                                }
                            }
                            //dd($item);
                            Employee::find($item)->userDetails->givePermissionTo([_permission(Permissions::SUPERVISOR_VIEW)]);
                        }
                    }
                }
            }
            $leaveRule = $team->leaveRule;
            $leaveRule->team_id = $team->id;
            $leaveRule->rules = serialize($supervisors);
            $leaveRule->save();
        }
    }

    public function updateTeamEmployeesDepartmentProcess($team, $prev_team_func)
    {
        //dd($team->is_functional && ($team->is_functional != $prev_team_func));
        if ($team->is_functional) {
            $members = $team->employees()->wherePivot('member_type', '!=', TeamMemberType::TEAMLEADER)->wherePivot('member_type', '!=', TeamMemberType::SUPERVISOR)->get();
            foreach ($members as $member) {
                if ($team->is_functional != $prev_team_func) {
                    $hasPivot = Employee::where('id', $member->id)->whereHas('teamMember', function ($query) use ($team) {
                        //$query->where('member_type', TeamMemberType::MEMBER)->where('team_id', $team->id);
                        $query->where('member_type', TeamMemberType::MEMBER);
                    })->exists();
                    if ($hasPivot) {
                        $member->teamMember()->where('team_id', $team->id)->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
                    } else {
                        $member->teamMember()->where('team_id', $team->id)->updateExistingPivot($team->id, ['member_type' => TeamMemberType::MEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
                    }
                }

                $query = EmployeeDepartmentProcess::where('employee_id', $member->id)->where('team_id', $this->request->input('team_id'))->where('removed_at', null)->first();
                if ($query) {
                    $query->process_id = $this->data['process_id'] ?? null;
                    $query->process_segment_id = $this->data['process_segment_id'] ?? null;
                    $query->department_id = $this->data['department_id'] ?? null;
                    $query->save();
                } else {
                    $team->employees()->where('employee_id', $member->id)->first()->departmentProcess()->save(new EmployeeDepartmentProcess([
                        'process_id' => $team->process_id,
                        'process_segment_id' => $team->process_segment_id,
                        'department_id' => $team->department_id,
                        'team_id' => $team->id,
                        'added_at' => Carbon::now()->toDateTimeString()
                    ]));
                }
            }
        } else {
            $members = $team->employees()->wherePivot('member_type', '!=', TeamMemberType::TEAMLEADER)->wherePivot('member_type', '!=', TeamMemberType::SUPERVISOR)->get();
            foreach ($members as $member) {
                //$hasPivot = Employee::where('id', $member->id)->whereHas('teamMember', function ($query) use ($team) {
                //    $query->where('member_type', TeamMemberType::MEMBER)->where('team_id', $team->id);
                //})->exists();
                //if (!$hasPivot) {
                //    $member->teamMember()->where('team_id', $team->id)->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
                //} else {
                //    $member->teamMember()->where('team_id', $team->id)->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
                //}
                $member->teamMember()->where('team_id', $team->id)->updateExistingPivot($team->id, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => Carbon::now()->toDateTimeString()]);
                $query = EmployeeDepartmentProcess::where('employee_id', $member->id)->where('team_id', $this->request->input('team_id'))->first();
                if ($query) {
                    //$query->update(['removed_at' => Carbon::now()->toDateTimeString()]);
                    $query->forceDelete();
                }
            }
        }
    }

    public function teamList($team)
    {
        //dd($team);

        if ($team != null) {
            $teams = $team->reduce(function ($teams, $team) {
                //$view = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_VIEW)) ? "<a href='".route('employee.setting.team.list', ['id' => $team->id])."' class='editor_edit'><i class='flaticon-eye'></i></a>" : null;
                //$edit = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_EDIT)) ? "<a target='_blank' href='".route('employee.setting.team.edit', ['id'=> $team->id])."' class='editor_edit'><i class='flaticon-edit'></i></a>" : null;
                //$delete = auth()->user()->hasPermissionTo(_permission(Permissions::ADMIN_TEAM_DELETE)) ? "<a href='#' id='".$team->id."' class='team_remove'><i class='flaticon-delete'></i></a>" : null;

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
                    'href' => route('employee.setting.team.list', ['id' => $team->id])
                ];
                return $teams;
            });
            return $teams;
        }
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
                'href' => route('employee.setting.team.list', ['id' => $item->id])
            ];
            return $team;
        });
        return $data;
    }


    public function transferTeamMember()
    {
        $request = $this->request;
        $teamId = $request->get('team_id');
        $employeeId = $request->get('employee_id');
        $transferTeamId = $request->get('transfer_team_id');
        $created_at = Carbon::parse($request->get('added_at'))->toDateTimeString();

        $this->removeTeamMember($employeeId, $teamId);
        $transferTeam = $this->addTeamMember($employeeId, $transferTeamId, $created_at);
        return $transferTeam;
    }

    public function removeTeamMember($employeeId, $teamId)
    {
        $team = Team::find($teamId);
        $team->employees()->detach($employeeId);
        $query = Employee::find($employeeId)->departmentProcess()->where('team_id', $teamId)->where('removed_at', null)->first();
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
    }

    public function addTeamMember($employeeId, $teamId, $created_at = null)
    {
        $employee = Employee::find($employeeId);
        $teamID = $teamId;

        if ($created_at == null) $created_at = now()->toDateTimeString();

        $hasPivot = Employee::where('id', $employeeId)->whereHas('teamMember', function ($query) use ($teamID) {
            $query->where('member_type', TeamMemberType::MEMBER);
        })->exists();
        $team = Team::where('id', $teamID)->first();

        if (!$hasPivot) {
            $employee->teamMember()->attach($teamID, ['member_type' => ($team->is_functional) ? TeamMemberType::MEMBER : TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => $created_at]);
            if ($team->is_functional) {
                $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
                    'process_id' => $team->process_id,
                    'process_segment_id' => $team->process_segment_id,
                    'department_id' => $team->department_id,
                    'team_id' => $team->id,
                    'added_at' => $created_at
                ]));
            }
            // toastr()->success('Add New Member successfully!');
        } else {
            $employee->teamMember()->attach($teamID, ['member_type' => TeamMemberType::ASSTMEMBER, 'created_by' => (auth()->user()->employeeDetails) ? auth()->user()->employeeDetails->id : null, 'created_at' => $created_at]);
            if ($team->is_functional) {
                $employee->departmentProcess()->save(new EmployeeDepartmentProcess([
                    'process_id' => $team->process_id,
                    'process_segment_id' => $team->process_segment_id,
                    'department_id' => $team->department_id,
                    'team_id' => $team->id,
                    'added_at' => $created_at
                ]));
            }
            toastr()->warning($employee->first_name . ' belongs to ' . $employee->teamMember[0]->name . ' team.')->success($employee->first_name . ' added successfully as an assoc. member.', '', ['extendedTimeOut' => 0, 'timeOut' => 0]);
        }

        return $team;
    }
}
