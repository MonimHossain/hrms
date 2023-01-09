@extends('layouts.container')

@section('content')


    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Requested Leave For Approval
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-2x nav-tabs-line-success " role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_2_1">Approval Request @if($leavesToUpperHot->count() || $leavesToHot->count())<span class="kt-badge kt-badge--danger">{{ $leavesToUpperHot->count() + $leavesToHot->count() }}</span>@endif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_2">Cancel Request @if($leaveCancelRequests->count())<span class="kt-badge kt-badge--danger">{{ $leaveCancelRequests->count() }}</span>@endif</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_tabs_2_1" role="tabpanel">
                                @if($leavesToHot->count() || $leavesToUpperHot->count())
                                    <div class="kt-section">
                                        <h5>From the team I'm leading</h5>
                                        <div class="table-responsive table-scroll">
                                            <table class="table table-bordered table-wrap table-striped custom-table table-responsive mb-0 text-center">
                                                <thead>
                                                <th>Employee Name</th>
                                                <th>Team Name</th>
                                                <th>Dept.</th>
                                                <th>Process</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Quantity</th>
                                                <th>Leave Type</th>
                                                <th>Leave Status</th>
                                                <th>Action</th>
                                                </thead>
                                                <tbody>
                                                @foreach($leavesToHot as $leave)
                                                    @php
                                                        $tempEmp = $leave->employee;
                                                        $tempTeam = $tempEmp->teamMember()->wherePivotIn('member_type', [\App\Utils\TeamMemberType::MEMBER])->first();
                                                        $tempDeptProcess = $tempEmp->departmentProcess()->where('team_id', $tempTeam->id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{ $tempEmp->employer_id }} - {{ $leave->employee->FullName }}
                                                        </td>

                                                        <td>
                                                            {{ $tempTeam->name }}
                                                        </td>

                                                        <td>
                                                            {{ $tempDeptProcess->department->name }}
                                                        </td>

                                                        <td>
                                                            {{ ($tempDeptProcess->process && $tempDeptProcess->processSegment) ? $tempDeptProcess->process->name.' - '.$tempDeptProcess->processSegment->name : '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $leave->start_date }}
                                                        </td>
                                                        <td>
                                                            {{ $leave->end_date }}
                                                        </td>
                                                        <td>
                                                            {{ str_replace('.0', '',$leave->quantity) }}
                                                        </td>
                                                        <td>
                                                            {{ _lang('leave.leaveType', $leave->leave_type_id) }}
                                                        </td>
                                                        <td class="text-bold {{ (\App\Utils\LeaveStatus::APPROVED == $leave->leave_status) ? 'text-success' : ((\App\Utils\LeaveStatus::PENDING == $leave->leave_status) ? 'text-warning' : 'text-danger')}}">
                                                            {{ trans('leave.status.'.$leave->leave_status) }}
                                                        </td>
                                                        <td>
                                                <span title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"
                                                      action="{{ route('leave.view', ['id'=>$leave->id, 'approval_type'=>'team_leader', 'approval_id' => auth()->user()->employee_id]) }}"
                                                      style="cursor: pointer"
                                                      class="globalModal pull-left text-success"><i class="flaticon-eye"></i></span>
                                                            /
                                                            <a title="Leave Details" target="_blank" href="{{ route('leave.list', ['id'=>$leave->employee->id]) }}"
                                                               class=" text-success"><i class="flaticon-exclamation"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if($leavesToUpperHot->count())
                                                    @foreach($leavesToUpperHot as $leave)
                                                        @php
                                                            $tempEmp = $leave->employee;
                                                            $tempTeam = $tempEmp->teamMember()->wherePivotIn('member_type', [\App\Utils\TeamMemberType::MEMBER])->first();
                                                            $tempDeptProcess = $tempEmp->departmentProcess()->where('team_id', $tempTeam->id)->first();
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                {{ $tempEmp->employer_id }} - {{ $leave->employee->FullName }}
                                                            </td>

                                                            <td>
                                                                {{ $tempTeam->name }}
                                                            </td>

                                                            <td>
                                                                {{ $tempDeptProcess->department->name }}
                                                            </td>

                                                            <td>
                                                                {{ ($tempDeptProcess->process && $tempDeptProcess->processSegment) ? $tempDeptProcess->process->name.' - '.$tempDeptProcess->processSegment->name : '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $leave->start_date }}
                                                            </td>
                                                            <td>
                                                                {{ $leave->end_date }}
                                                            </td>
                                                            <td>
                                                                {{ str_replace('.0', '',$leave->quantity) }}
                                                            </td>
                                                            <td>
                                                                {{ _lang('leave.leaveType', $leave->leave_type_id) }}
                                                            </td>
                                                            <td class="text-bold {{ (\App\Utils\LeaveStatus::APPROVED == $leave->leave_status) ? 'text-success' : ((\App\Utils\LeaveStatus::PENDING == $leave->leave_status) ? 'text-warning' : 'text-danger')}}">
                                                                {{ trans('leave.status.'.$leave->leave_status) }}
                                                            </td>
                                                            <td>
                                                <span title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"
                                                      action="{{ route('leave.view', ['id'=>$leave->id, 'approval_type'=>'upper_team_leader', 'approval_id' => auth()->user()->employee_id]) }}"
                                                      style="cursor: pointer"
                                                      class="globalModal pull-left text-success"><i class="flaticon-eye"></i></span>
                                                                <a title="Leave Details" target="_blank" href="{{ route('leave.list', ['id'=>$leave->employee->id]) }}"
                                                                   class="btn-sm btn-outline-success pull-left text-dark">Leave Details</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if($leavesToUpperHot->count() == 0 && $leavesToHot->count() == 0)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        No one requested for any leave.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_2" role="tabpanel">
                                @if($leaveCancelRequests->count())
                                    <div class="kt-section">
                                        <h5>From the team I'm leading</h5>
                                        <div class="table-responsive table-scroll">
                                            <table class="table table-bordered table-wrap table-striped custom-table table-responsive mb-0 text-center">
                                                <thead>
                                                <th>Employee Name</th>
                                                <th>Team Name</th>
                                                <th>Dept.</th>
                                                <th>Process</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Quantity</th>
                                                <th>Leave Type</th>
                                                <th>Leave Status</th>
                                                <th>Action</th>
                                                </thead>
                                                <tbody>
                                                @foreach($leaveCancelRequests as $leave)
                                                    @php
                                                        $tempEmp = $leave->employee;
                                                        $tempTeam = $tempEmp->teamMember()->wherePivotIn('member_type', [\App\Utils\TeamMemberType::MEMBER])->first();
                                                        $tempDeptProcess = $tempEmp->departmentProcess()->where('team_id', $tempTeam->id)->first();
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{ $tempEmp->employer_id }} - {{ $leave->employee->FullName }}
                                                        </td>

                                                        <td>
                                                            {{ $tempTeam->name }}
                                                        </td>

                                                        <td>
                                                            {{ $tempDeptProcess->department->name }}
                                                        </td>

                                                        <td>
                                                            {{ ($tempDeptProcess->process && $tempDeptProcess->processSegment) ? $tempDeptProcess->process->name.' - '.$tempDeptProcess->processSegment->name : '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $leave->start_date }}
                                                        </td>
                                                        <td>
                                                            {{ $leave->end_date }}
                                                        </td>
                                                        <td>
                                                            {{ $leave->quantity }}
                                                        </td>
                                                        <td>
                                                            {{ _lang('leave.leaveType', $leave->leave_type_id) }}
                                                        </td>
                                                        <td class="text-bold {{ (\App\Utils\LeaveStatus::APPROVED == $leave->leave_status) ? 'text-success' : ((\App\Utils\LeaveStatus::PENDING == $leave->leave_status) ? 'text-warning' : 'text-danger')}}">
                                                            {{ trans('leave.status.'.$leave->leave_status) }}
                                                        </td>
                                                        <td>
                                                            <span title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"
                                                                  action="{{ route('leave.view', ['id'=>$leave->id, 'approval_type'=>'cancel_leave', 'approval_id' => auth()->user()->employee_id]) }}"
                                                                  style="cursor: pointer"
                                                                  class="globalModal pull-left text-success"><i class="flaticon-eye"></i></span>
                                                                        /
                                                            <a title="Leave Details" target="_blank" href="{{ route('leave.list', ['id'=>$leave->employee->id]) }}"
                                                               class=" text-success"><i class="flaticon-exclamation"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if($leaveCancelRequests->count() == 0)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        No one requested for leave cancel.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>



{{--                    @if($leavesToSupervisor->count())--}}
{{--                            <div class="kt-section">--}}
{{--                                <h5>From the team I'm Supervising</h5>--}}
{{--                                <div class="table-responsive table-scroll">--}}
{{--                                    <table class="table table-bordered table-wrap table-striped custom-table table-nowrap mb-0">--}}
{{--                                        <thead>--}}
{{--                                        <th>Employee Name</th>--}}
{{--                                        <th>Start Date</th>--}}
{{--                                        <th>End Date</th>--}}
{{--                                        <th>Quantity</th>--}}
{{--                                        <th>Leave Type</th>--}}
{{--                                        <th>Leave Status</th>--}}
{{--                                        <th>Action</th>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach($leavesToSupervisor as $leave)--}}
{{--                                            <tr>--}}
{{--                                                <td>--}}
{{--                                                    {{ $leave->employee->employer_id }} - {{ $leave->employee->FullName }}--}}
{{--                                                </td>--}}

{{--                                                <td>--}}
{{--                                                    {{ $leave->start_date }}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    {{ $leave->end_date }}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    {{ $leave->quantity }}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    {{ _lang('leave.leaveType', $leave->leave_type_id) }}--}}
{{--                                                </td>--}}
{{--                                                <td class="text-bold {{ (\App\Utils\LeaveStatus::APPROVED == $leave->leave_status) ? 'text-success' : ((\App\Utils\LeaveStatus::PENDING == $leave->leave_status) ? 'text-warning' : 'text-danger')}}">--}}
{{--                                                    {{ trans('leave.status.'.$leave->leave_status) }}--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                <span title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"--}}
{{--                                                      action="{{ route('leave.view', ['id'=>$leave->id, 'approval_type'=>'supervisor', 'approval_id' => auth()->user()->employee_id]) }}"--}}
{{--                                                      style="cursor: pointer"--}}
{{--                                                      class="btn-sm btn-outline-success globalModal pull-left text-dark"><i class="fa fa-eye"></i></span>--}}
{{--                                                    <a title="Leave Details" target="_blank" href="{{ route('leave.list', ['id'=>$leave->employee->id]) }}"--}}
{{--                                                       class="btn-sm btn-outline-success pull-left text-dark">Leave Details</a>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}


                    </div>
                    <!--end::Form-->


                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')



    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
@endpush
