<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 ">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center">
                            <img alt="User Pic" src="{{ ($employee) ? (($employee->profile_image) ? asset('/storage/employee/img/'.$employee->profile_image) : (($employee->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}" class="rounded-circle img-fluid">
                        </div>
                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-bordered table-user-information">
                                <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td>{{ $employee->FullName }}</td>
                                </tr>
                                <tr>
                                    <td>Profile Complete:</td>
                                    <td>{{ $employee->profile_completion }}%</td>
                                </tr>
                                <tr>
                                    <td>Team: </td>
                                    <td><a href="{{ ($team) ? route('employee.setting.team.list', ['id' => $team->id]) : '#' }}">{{ ($team) ? $team->name : 'Untracked' }}</a></td>
                                </tr>
                                <tr>
                                    <td>Leave Balance:</td>
                                    <td><a href="{{ ($leavePermission && !$leaveBalance) ? route('admin.leave.application') : '#' }}">{{ ($leaveBalance) ? 'Generated' : 'Not Generated' }}</a></td>
                                </tr>

                                <tr>
                                    <td>Salary Settings:</td>
                                    <td><a href="{{ ($salaryPermission && !$salary) ? route('manage.salary.view') : '#' }}">{{ ($salary) ? 'Created' : 'Not Created' }}</a></td>
                                </tr>
                                <tr>
                                    <td>Journey: </td>
                                    <td><a href="{{ route('employee.journey', ['id' => $employee->id]) }}">Goto Journey</a></td>
                                </tr>
                                </tbody>
                            </table>
                            @can(_permission(\App\Utils\Permissions::IMPERSONATE_VIEW))
                                @if($employee->userDetails)
                                <a href="{{ route('impersonate', ['id' => $employee->userDetails->id]) }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Login as {{ $employee->FullName }}</a>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
