@extends('layouts.container')



@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title bold">
                                 Leave details of <span class="text-success">{{ $employee->first_name .' '. $employee->last_name }}</span>
                            </h3>
                        </div>
                        <span class="pull-right">
                        @if($id == null)
                            <a href="{{ route('user.leave') }}" class="btn btn-outline-success" style="position: relative; top: 12px;">Apply Leave</a>
                        @endif
                        </span>
                    </div>
                    {{-- <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section dtHorizontalExampleWrapper ">

                        </div>
                    </div> --}}

                    <!--begin::Form-->

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
                @if($leaveBalances->count() && ($employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PERMANENT || $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION))

                <div class="card ">
{{--                    <div class="card-header">--}}
{{--                        <div class="card-title">--}}
{{--                            <h3 class="card-label pl-2 bold">--}}
{{--                                Leave Balance--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="card-body">
                        {{-- && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PERMANENT --}}
                        <table class="table table-bordered text-center" id="html_table" >
                            <thead>

                                @if($leaveBalances)
                                    <tr>
                                        @foreach($leaveBalances as $balance)
                                            @if(
                                                $balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL ||
                                                $balance->leave_type_id == \App\Utils\LeaveStatus::SICK ||
                                                $balance->leave_type_id == \App\Utils\LeaveStatus::LWP ||
                                                $balance->leave_type_id == \App\Utils\LeaveStatus::EARNED
                                            )
                                            <th  class="bold" colspan="{{ ($balance->leave_type_id == \App\Utils\LeaveStatus::EARNED) ? '3' : '3' }}">{{( $balance->leave_type_id == \App\Utils\LeaveStatus::LWP) ? 'LWP' : _lang('leave.leaveType',$balance->leave_type_id)  }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                @else
                                    <div class="alert alert-primary" role="alert">
                                        Leave balance not generated yet.
                                    </div>
                                @endif
                            </thead>
                            <tbody>

                            <tr>
                                @if($leaveBalances)
                                    @php
                                        $earnLeaveService = new \App\Services\EarnLeaveService($employee);
                                        // dd($earnLeaveService);
                                    @endphp
                                    @foreach($leaveBalances as $balance)

                                        @if ($employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                                <td><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}</td>
                                                <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}</td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                                <td><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}</td>
                                                <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}</td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                                <td><span class="bold">Total :</span> {{ str_replace('.0', '', $balance->total) }}</td>
                                                <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $balance->remain) }}</td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                                <td colspan="3">
                                                    <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                            @endif
                                        @else
                                            <?php
                                                $earnLeaveService = new App\Services\EarnLeaveService($employee);
                                            ?>
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                                <td><span class="bold">Total :</span> 
                                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                                    @else
                                                        {{ str_replace('.0', '', $balance->total)  }}
                                                    @endif
                                                </td>
                                                <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                <td><span class="bold">Remain :</span> 
                                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                                    @else
                                                        {{ str_replace('.0', '', $balance->remain)  }}
                                                    @endif
                                                </td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                                <td><span class="bold">Total :</span> 
                                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                                    @else
                                                        {{ str_replace('.0', '', $balance->total)  }}
                                                    @endif
                                                </td>
                                                <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                <td><span class="bold">Remain :</span> 
                                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                                    @else
                                                        {{ str_replace('.0', '', $balance->remain)  }}
                                                    @endif
                                                </td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                                    <td><span class="bold">Total :</span> 
                                                        @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                            {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                                        @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                            {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                                        @else
                                                            {{ str_replace('.0', '', ($balance->total + $earnLeaveService->calculateEarnLeaveBalance()) )  }}
                                                        @endif
                                                    </td>
                                                    <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                                    <td><span class="bold">Remain :</span> 
                                                        @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                            {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                                        @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                            {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                                        @else
                                                            {{ str_replace('.0', '', ($balance->total + $earnLeaveService->calculateEarnLeaveBalance() - $balance->used))  }}
                                                        @endif
                                                    </td>
                                            @endif
                                            @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                                <td colspan="3">
                                                    <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}
                                                </td>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                @elseif($leaveBalances->count() == 0)
                    <div class="alert alert-primary" role="alert">
                        Leave balance not generated yet.
                    </div>
                    <br>
                @endif


                @if($leaveBalances->count() && $leaves->count())
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label pl-2 bold">
                                Leave Status
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                            <table class="table table-bordered text-center" id="lookup">
                                <thead class="">
                                    {{-- <th>Subject</th> --}}
                                    {{-- <th>Description</th> --}}
                                    <th>Reason</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Leave Type</th>
                                    <th>Quantity</th>
                                    <th>Leave Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($leaves as $leave)
                                    <tr>
                                        {{-- <td>{{ $leave->subject }}</td> --}}
                                        {{-- <td>{{ $leave->description }}</td> --}}
                                        <td>{{ ($leave->leaveReason) ? $leave->leaveReason->leave_reason : '-' }}</td>
                                        <td>{{ date_format(date_create($leave->start_date), "d-m-Y") }}</td>
                                        <td>{{ date_format(date_create($leave->end_date), "d-m-Y")   }}</td>
                                        <td>{{ _lang('leave.leaveType', $leave->leave_type_id) }}</td>
                                        <td>{{ str_replace('.0', '', $leave->quantity) }}</td>
                                        <td class="text-bold {{ (\App\Utils\LeaveStatus::APPROVED == $leave->leave_status) ? 'text-success' : ((\App\Utils\LeaveStatus::PENDING == $leave->leave_status) ? 'text-warning' : 'text-danger')}}">
                                            {{ trans('leave.status.'.$leave->leave_status) }}
                                        </td>
                                        <td>
                                            <a href="#" title="Leave Application" data-toggle="modal" form-size="modal-md" data-target="#kt_modal"
                                            action="{{ route('user.leave.view', ['id'=>$leave->id]) }}"
                                            style="cursor: pointer"
                                            class="globalModal">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" redirect="user.leave.leave-detail" modelName="Leave" id="{{ $leave->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            {{ $leaves->links() }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .inner-table {
            border-collapse: collapse;
            border-spacing: 0px;
            text-align: center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width: .5px;
            border-style: solid;
        }

        .inner-table th {
            border: 1px solid #0abb87;
        }

        .inner-table td {
            border: 1px solid #0abb87;
        }
    </style>

@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/metronic-datatable/base/html-table.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>

    <script>
        $("#lookup").on('click', '.lookup_remove', function () {
            var id = $(this).attr('id');
            var modelName = $(this).attr('modelName');
            var redirect = $(this).attr('redirect');
            var getRouteId = (typeof $(this).attr('getRouteId') !== "undefined") ? $(this).attr('getRouteId') : null;
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to cancel leave?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('cancel.leave', ['']) }}/"+id,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {
                            console.log(results.success)
                            if (results.success === 'success') {
                                swal.fire("Done!", results.success, "success");
                                window.location.href = "{{ route('leave.list') }}"
                            } else {
                                swal.fire("Error!", results.error, "error");
                            }
                        }
                    });
                    {{--window.location.href = "{{ route('cancel.leave', ['']) }}/"+id;--}}
                }
            });
        });
    </script>
@endpush



