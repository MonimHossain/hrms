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
                                LWP Application Details
                            </h3>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="kt-portlet__body">

                                    <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-success"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->all()) ? '' : 'active' }} {{ (request()->get('pending')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_1" role="tab">Pending
                                                Leaves</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->get('approved')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_2" role="tab">Approved
                                                Leaves</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane {{ (request()->all()) ? '' : 'active' }} {{ (request()->get('pending')) ? 'active' : ''  }}" id="kt_tabs_6_1" role="tabpanel">
                                            @if($pendingLeaves->count())
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Employee</th>
                                                    <th>Reason</th>
                                                    <th>Applied on</th>
                                                    {{-- <th>Leave Days</th> --}}
                                                    <th>Leave Type</th>
                                                    <th>Days Count</th>
                                                    <th>Pre. Approval Status</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pendingLeaves as $leave)
                                                    <tr>
                                                        @php
                                                            $employee = $leave->employee;
                                                        @endphp
                                                        <th scope="row">{{ $employee->employer_id }}</th>
                                                        <td>
                                                            <span
                                                                class="kt-media kt-media--circle kt-margin-r-5 kt-margin-t-5">
                                                                <img width="50"
                                                                     src="{{ ($employee) ? (($employee->profile_image) ? asset('/storage/employee/img/thumbnail/'.$employee->profile_image) : (($employee->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"
                                                                     alt="image">
                                                            </span>
                                                            {{ $leave->employee->FullName }}
                                                        </td>
                                                        {{-- <td>{{ $leave->subject }}</td> --}}
                                                        <td>{{ ($leave->leaveReason) ? $leave->leaveReason->leave_reason : '-' }}</td>
                                                        <td>{{ Carbon\Carbon::parse($leave->created_at)->toDateString() }}</td>
                                                        {{-- <td>
                                                            @if($leave->leave_days)
                                                                @php
                                                                    $leave_days = json_decode($leave->leave_days);
                                                                @endphp
                                                                @foreach($leave_days as $leave_day)
                                                                    @if($loop->last)
                                                                        {{ $leave_day }}
                                                                    @else
                                                                        {{ $leave_day . ', '   }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </td> --}}
                                                        <td>{{ _lang('leave.leaveType',$leave->leave_type_id)  }}</td>
                                                        <td>{{ str_replace('.0', '',$leave->quantity) }}</td>
                                                        <td>
                                                            @php
                                                                $approvals = [];
                                                                if($leave->lwp_approved_by){
                                                                    array_push($approvals, 'HOD');
                                                                    echo "<li>Reuested for final approval from HR</li>";
                                                                }
                                                                if($leave->hot_approved_by){
                                                                    array_push($approvals, 'HOT');
                                                                    echo "<li>Approved by HoT</li>";
                                                                }
                                                                if($leave->supervisor_approved_by){
                                                                    array_push($approvals, 'SUP');
                                                                    echo "<li>Approved by Supervisor</li>";
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>{{ _lang('leave.status',$leave->leave_status)  }}</td>
                                                        <td>
                                                            @can(_permission(\app\Utils\Permissions::ADMIN_LEAVE_APPROVAL_CREATE))
                                                                @if(!$leave->lwp_approved_by)
                                                                    <span title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"
                                                                        action="{{ route('admin.leave.view', ['id'=>$leave->id, 'approval_type'=>'HOD', 'approval_id' => auth()->user()->employee_id]) }}"
                                                                        style="cursor: pointer"
                                                                        class="globalModal pull-left text-success"><i class="fa fa-eye"></i></span>
                                                                @endif
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                                {{ $pendingLeaves->appends([
                                                            'pending' => 'true',
                                                            'approvedPage' => $approvedLeaves->currentPage()
                                                        ])->links() }}
                                            @else
                                                <div class="alert alert-info">
                                                    {{-- <strong>Info!</strong>  --}}
                                                    No data available
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tab-pane {{ (request()->get('approved')) ? 'active' : ''  }}" id="kt_tabs_6_2" role="tabpanel">
                                            @if($approvedLeaves->count())
                                            <table class="table table-bordered table-hover table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Employee</th>
                                                    {{-- <th>Subject</th> --}}
                                                    <th>Applied on</th>
                                                    <th>Leave From-To</th>
                                                    <th>Leave Type</th>
                                                    <th>Days Count</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($approvedLeaves as $leave)
                                                    <tr>
                                                        @php
                                                            $employee = $leave->employee;
                                                        @endphp
                                                        <th scope="row">{{ $employee->employer_id }}</th>
                                                        <td>
                                                            <span
                                                                class="kt-media kt-media--circle kt-margin-r-5 kt-margin-t-5">
                                                                <img width="50"
                                                                     src="{{ ($employee) ? (($employee->profile_image) ? asset('/storage/employee/img/thumbnail/'.$employee->profile_image) : (($employee->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"
                                                                     alt="image">
                                                            </span>
                                                            {{ $leave->employee->FullName }}
                                                        </td>
                                                        {{-- <td>{{ $leave->subject }}</td> --}}
                                                        <td>{{ Carbon\Carbon::parse($leave->created_at)->toDateString() }}</td>
                                                        <td>
                                                            @php
                                                                $leave_days = json_decode($leave->leave_days);
                                                            @endphp
                                                            @foreach($leave_days as $leave_day)
                                                                @if($loop->last)
                                                                    {{ $leave_day }}
                                                                @else
                                                                    {{ $leave_day . ', '   }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>{{ _lang('leave.leaveType',$leave->leave_type_id)  }}</td>
                                                        <td>{{ str_replace('.0', '',$leave->quantity) }}</td>
                                                        <td>{{ _lang('leave.status',$leave->leave_status)  }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                                {{ $approvedLeaves->appends([
                                                            'pending' => 'true',
                                                            'pendingPage' => $pendingLeaves->currentPage()
                                                        ])->links() }}
                                            @else
                                                <div class="alert alert-info">
                                                    {{-- <strong>Info!</strong>  --}}
                                                    No data available
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Form-->

                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')

@endpush

@push('library-js')
    <script
        src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>

    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}"
            type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}"
            type="text/javascript"></script>
@endpush
