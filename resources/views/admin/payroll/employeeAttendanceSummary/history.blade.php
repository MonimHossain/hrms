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
                                Employee Attendance Summary History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form" action="{{ route('manage.salary.employee.attendance-summary') }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" autocomplete="off" required class="form-control month-pick" name="start_date" placeholder="Select Date" value="{{ Request::get('start_date') }}">
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <div class="input-group date">
                                                <input type="text" autocomplete="off" required class="form-control month-pick" name="end_date" placeholder="Select Date" value="{{ Request::get('end_date') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group date">
                                                <input type="text" autocomplete="off" class="form-control" name="employee_id" placeholder="Select Employee ID" value="{{ Request::get('employee_id') }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-user"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <a href="#" title="Add Employee Attendance Summary" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('add.salary.employee.attendance-summary') }}" class="custom-btn globalModal btn btn-sm btn-primary pull-letf">
                                        Add new record
                                    </a> --}}
                                    {{-- <a href="#" title="Employee Hours Clearance" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('upload.salary.employee.hours.clearance.view', ['startDate'=>$startDate, 'endDate'=>$endDate]) }}" class="custom-btn globalModal btn btn-sm btn-primary pull-right">
                                        Clearance
                                    </a> --}}
                                </div>
                            </div>
                            @if($attendance_summary_history->count())
                            <div class="table-responsive">
                            <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Month</th>
                                    <th>Present</th>
                                    <th>Holiday</th>
                                    <th>Holiday Present</th>
                                    <th>Halfday</th>
                                    <th>Halfday Present</th>
                                    <th>Weekoff</th>
                                    <th>Adj. Dayoff</th>
                                    <th>Absent</th>
                                    <th>LWP</th>
                                    {{-- <th>Remarks</th> --}}
                                    {{-- <th>Created by</th> --}}
                                    {{-- <th>Updated by</th> --}}
                                    {{-- <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendance_summary_history as $attendance_sum)
                                        <tr>
                                            <td>{{ $attendance_sum->employee ? $attendance_sum->employee->employer_id : '-' }}</td>
                                            <td>{{ $attendance_sum->month }}</td>
                                            <td>{{ $attendance_sum->present }}</td>
                                            <td>{{ $attendance_sum->holiday }}</td>
                                            <td>{{ $attendance_sum->holiday_present }}</td>
                                            <td>{{ $attendance_sum->half_day }}</td>
                                            <td>{{ $attendance_sum->half_day_present }}</td>
                                            <td>{{ $attendance_sum->weekoff }}</td>
                                            <td>{{ $attendance_sum->adj_day_off }}</td>
                                            <td>{{ $attendance_sum->absent }}</td>
                                            <td>{{ $attendance_sum->lwp }}</td>
                                            {{-- <td>{{ $attendance_sum->createdBy ? $attendance_sum->createdBy->fullName : '-' }}</td> --}}
                                            {{-- <td>{{ $attendance_sum->updatedBy ? $attendance_sum->updatedBy->fullName : '-' }}</td> --}}
                                            {{-- <td>{{ $attendance_sum->remarks ? $attendance_sum->remarks : '-' }}</td> --}}
                                            {{-- <td> --}}
                                            {{-- <a href="#" title="Edit Employee Hour" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('edit.salary.employee.hours', ['id'=>$attendance_sum->id]) }}" class="text-primary custom-btn globalModal">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                            | <a href="#" redirect="manage.salary.employee.hours" modelName="EmployeeHours" id="{{ $attendance_sum->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $attendance_summary_history->appends(Request::all())->links() }}
                            </div>
                            @else 
                                <p>No data found!</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
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
        $('.month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });

    </script>
@endpush




