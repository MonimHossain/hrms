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
                            Team Leave Status
                        </h3>
                    </div>
                </div>
                <br>
                <div class="kt-portlet__body">
                    <div class="kt-section">

                        <form class="kt-form" action="{{ route('team.leave.status') }}" method="get">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label>Team</label>
                                        <div class="input-group date">
                                            <select id="team_lead_id" name="team" class="form-control kt-selectpicker" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach ($teams as $team)
                                                    <option {{ ($team->id == Request::get('team')) ? 'selected':'' }} value="{{$team->id}}" data-tokens="{{ $team->name }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="kt-form__actions" >
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if($employees->count())
                            <table class="inner-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <?php
                                            $leaveTypeCount = 0;
                                            $leaveEcpt = array('PL', 'ML');
                                        ?>
                                        @foreach($leave_types as $type)
                                            @if(!in_array($type->short_code, $leaveEcpt))
                                                <th>
                                                    {{ $type->leave_type }}
                                                    <?php $leaveTypeCount++; ?>
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($employees))
                                    @foreach($employees as $teamMate)
                                        @if($teamMate->employee)
                                        <tr>                                        
                                            <td>{{ $teamMate->employee->employer_id ? $teamMate->employee->employer_id : '' }} - {{ $teamMate->employee->first_name.' '.$teamMate->employee->last_name }}</td>
                                            @if($teamMate->employee->leaveBalances->count())  
                                                @foreach($leave_types as $type)
                                                    @php
                                                        $found = false;
                                                        $all_leaves = $teamMate->employee->leaveBalances->where('year', date('Y'))->where('employment_type_id', $teamMate->employee->employeeJourney->employment_type_id );
                                                    @endphp
                                                    @if(!in_array($type->short_code, $leaveEcpt))
                                                        @foreach($all_leaves as $item)
                                                            @if($item->leaveType->short_code == $type->short_code)
                                                                @php
                                                                    $found = true;
                                                                @endphp
                                                                    @if($item->leaveType->short_code == 'EL')
                                                                        <?php
                                                                            $earnLeaveService = new App\Services\EarnLeaveService($teamMate->employee);
                                                                        ?>
                                                                        <td>
                                                                            <strong>Total:</strong> {{ str_replace('.0', '', ($item->total + $earnLeaveService->calculateEarnLeaveBalance())) }} <br>
                                                                            <strong>Used:</strong> {{ str_replace('.0', '', $item->used) }} <br>
                                                                            <strong>Remain:</strong> {{ str_replace('.0', '', ($item->total + $earnLeaveService->calculateEarnLeaveBalance() - $item->used)) }}
                                                                        </td>
                                                                    @elseif($item->leaveType->short_code == 'LWP')
                                                                        <td>
                                                                            <strong>Used:</strong> {{ str_replace('.0', '', $item->used) }}
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <?php
                                                                                $earnLeaveService = new App\Services\EarnLeaveService($teamMate->employee);
                                                                            ?>
                                                                            <strong>Total:</strong>
                                                                            @if($item->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $teamMate->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                                                {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                                                            @elseif($item->leave_type_id == \App\Utils\LeaveStatus::SICK  && $teamMate->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                                                {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                                                            @else
                                                                                {{ str_replace('.0', '', $item->total)  }}
                                                                            @endif
                                                                            <br>
                                                                            <strong>Used:</strong> {{ str_replace('.0', '', $item->used) }} <br>
                                                                            <strong>Remain:</strong>
                                                                            @if($item->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $teamMate->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                                                {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                                                            @elseif($item->leave_type_id == \App\Utils\LeaveStatus::SICK && $teamMate->employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                                                {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                                                            @else
                                                                                {{ str_replace('.0', '', $item->remain)  }}
                                                                            @endif
                                                                        </td>
                                                                    @endif                                                             
                                                            @endif
                                                        @endforeach
                                                        @if ($found == false)
                                                            <td>
                                                                Not available
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endforeach 
                                            @else
                                                <td colspan="{{ $leaveTypeCount }}">Leave balance not generated yet</td>
                                            @endif                                        
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-primary" role="alert">
                                Select team first
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

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
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




