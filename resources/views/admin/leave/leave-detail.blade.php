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
                <div class="kt-portlet__body ">
                    <div class="kt-section dtHorizontalExampleWrapper ">
                        <h5>Leave Balance</h5>
                        @if($leaveBalance->count())
                            <table class="table table-bordered " id="html_table" width="100%">
                                <thead>
                                <tr class="text-center">
                                    @if($leaveBalance)
                                        <tr class="text-center">
                                            @foreach($leaveBalance as $balance)
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
                                </tr>
                                </thead>
                                <tbody>

                                <tr class="text-center">
                                    @if($leaveBalance)
                                        @php
                                            $earnLeaveService = new \App\Services\EarnLeaveService($employee);
                                            // dd($earnLeaveService);
                                        @endphp
                                        @foreach($leaveBalance as $balance)

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
                        @else
                        <div class="alert alert-info">
                            {{-- <strong>Info!</strong>  --}}
                            No data available
                        </div>
                        @endif

                        <br>
                        <br>
                        <h5 class="mb-3">Leave Applications</h5>
                        @if($leaves->count())
                            <table class="table table-bordered" id="" width="100%">
                                <thead>
                                <tr class="text-center">
                                    {{-- <th >Subject</th> --}}
                                    {{-- <th >Description</th> --}}
                                    <th >Reason</th>
                                    <th >Start Date</th>
                                    <th >End Date</th>
                                    <th >Leave Type</th>
                                    <th >Quantity</th>
                                    <th >Leave Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaves as $leave)
                                    <tr class="text-center">
                                        {{-- <td>{{ $leave->subject }}</td> --}}
                                        {{-- <td>{{ $leave->description }}</td> --}}
                                        <td>{{ ($leave->leaveReason) ? $leave->leaveReason->leave_reason : '-' }}</td>
                                        <td>{{ date_format(date_create($leave->start_date), "d/m/Y") }}</td>
                                        <td>{{ date_format(date_create($leave->end_date), "d/m/Y")   }}</td>
                                        <td>{{ trans('leave.leaveType.'.$leave->leave_type_id)  }}</td>
                                        <td>{{ str_replace('.0', '',$leave->quantity) }}</td>
                                        <td>{{ trans('leave.status.'.$leave->leave_status) }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                {{-- <strong>Info!</strong>  --}}
                                No data available
                            </div>
                        @endif
                    </div>
                </div>


                <!--begin::Form-->

                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        .inner-table{
            border-collapse: collapse; border-spacing: 0px; text-align:center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width:.5px;
            border-style:solid;
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
@endpush



