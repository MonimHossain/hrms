@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Leave Report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('Admin.Leave.report.view')  }}" method="get">

                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>From Year</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control year-pick" required autocomplete="off"
                                                       placeholder="Select Date"
                                                       id="" name="date_from" value="{{ Request::get('date_from') }}"/>
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" required placeholder="Employee ID" name="employer_id" value="{{ Request::get('employer_id') }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="kt-section__content">
                                <h5 class="pt-5">Leave Balance Summary</h5>
                                @php
                                    $leaveBalance = $leave;
                                @endphp
                                @if($leaveBalance)
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
                                    <p>No data found !</p>
                                @endif
                            </div>
                            <div class="kt-section__content">
                                <h5 class="pt-5">Leave Application Summary</h5>
                                @if(!empty($employeeCollection) && count($employeeCollection) > 0)
                                    <table class="table table-striped table-bordered custom-table table-nowrap mb-0 p-1">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Number Of Application</th>
                                                <th>Quantity (Day)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employeeCollection as $employee)
                                                <tr>
                                                    <td>
                                                        {{ $employee->employer_id }}
                                                    </td>
                                                    <td>
                                                        {{ $employee->FullName }}
                                                    </td>
                                                    <td>
                                                        {{ (isset($employee->leaves[0]))? $employee->leaves[0]->numberApplication:0 }}
                                                    </td>
                                                    <td>
                                                        {{ (isset($employee->leaves[0]))? str_replace('.0', '',$employee->leaves[0]->totalLeave):0 }}
                                                    </td>
                                                    <td class="text-bold text-center">
                                                        <a title="Leave Details" target="_blank" href="{{ route('admin.leave.list', ['id'=>$employee->id]) }}" class="btn-sm btn-primary">Leave Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    {!! $employeeCollection->render() !!}
                                @else
                                    <p>No data found !</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script>
        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }

        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm-dd',
            // viewMode: 'months',
            // minViewMode: 'months'
        });

        $('.year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });
    </script>

    @endpush
