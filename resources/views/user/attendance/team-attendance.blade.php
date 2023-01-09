@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        Team Member's Attendance
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">

                    <form class="kt-form" action="{{ route('user.team.attendance.submit') }}" method="get">
                        {{--                    @csrf--}}
                        {{--                    <div class="row">--}}
                        {{--                        <div class="col-xl-4">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>Month</label>--}}
                        {{--                                <div class="input-group date">--}}
                        {{--                                    <input type="text" class="form-control" readonly placeholder="Select Month" id="month-pick" name="month" value="{{ $month }}"/>--}}
                        {{--                                    <div class="input-group-append">--}}
                        {{--                                        <span class="input-group-text">--}}
                        {{--                                            <i class="la la-calendar-check-o"></i>--}}
                        {{--                                        </span>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="col-xl-4">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <label>year</label>--}}
                        {{--                                <div class="input-group date">--}}
                        {{--                                    <input type="text" class="form-control" readonly placeholder="Select Year" id="year-pick" name="year" value="{{ $year }}"/>--}}
                        {{--                                    <div class="input-group-append">--}}
                        {{--                                        <span class="input-group-text">--}}
                        {{--                                            <i class="la la-calendar-check-o"></i>--}}
                        {{--                                        </span>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="col-xl-4">--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <div class="kt-form__actions" style="margin-top: 26px;">--}}
                        {{--                                    <button type="submit" class="btn btn-primary">Filter</button>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}

                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>Team</label>
                                    <div class="input-group date">

                                        <select id="team_lead_id" name="team" class="form-control kt-selectpicker" data-live-search="true">
                                            <option value="">Select</option>
                                            @foreach ($teams as $team)
                                                <option {{ ($team->id == Request::get('team')) ? 'selected':'' }} value="{{$team->id}}"
                                                        data-tokens="{{ $team->name }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <div class="input-group date">
                                        <select id="employee_id" name="employee_id" class="form-control" data-live-search="true">
                                            <option value="">Select</option>
                                            @foreach ($employees as $employee)
                                                <option {{ ($employee->id == Request::get('employee_id')) ? 'selected':'' }} value="{{$employee->id}}"
                                                        data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control date_from" readonly placeholder="Select Start Date"
                                               id="kt_datepicker_3" name="date_from" value="{{ Request::get('date_from') }}"/>
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
                                    <label>Date To</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control date_to" readonly placeholder="Select End Date"
                                               id="kt_datepicker_3" name="date_to" value="{{ Request::get('date_to') }}"/>
                                        <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="reset" class="btn btn-secondary reset-button">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="kt-section__content">
                        @if (!isset($attendances) )

                            No records for this month

                        @elseif($attendances->count() == 0)
                            No records for this month
                        @else

                            @php
                                $total_office       =   0;
                                $total_present      =   0;
                                $total_absent       =   0;
                                $total_late_entry   =   0;
                                $total_early_leave  =   0;
                                $missing_exit       =   0;

                                if ($attendances->isNotEmpty()){
                                    foreach ($attendances as $item){
                                        $total_office++;
                                        if ($item->status == \App\Utils\AttendanceStatus::PRESENT){
                                            if (!($item->punch_in && $item->punch_out)) {
                                                $missing_exit++;
                                            }
                                            $total_present++;
                                        } elseif($item->status == \App\Utils\AttendanceStatus::LATE) {
                                            $total_late_entry++;
                                            if (!($item->punch_in && $item->punch_out)) {
                                                $missing_exit++;
                                            }
                                        }else {
                                            if ($item->status == \App\Utils\AttendanceStatus::ABSENT) {
                                                $total_absent++;
                                            }
                                            else if ($item->status == \App\Utils\AttendanceStatus::DAYOFF) {
                                                //
                                            }
                                            else{
                                                //
                                            }
                                        }
                                    }
                                }
                            @endphp



                        <!-- card section start -->
                            <div class="container">
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_office) ? $total_office : 0 }}</span>
                                                <span class="dbox__title">Total Office</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-2">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_present) ? ($total_present + $total_late_entry) : 0 }}</span>
                                                <span class="dbox__title">Present</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_absent) ? $total_absent : 0 }}</span>
                                                <span class="dbox__title">Absent</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_late_entry) ? $total_late_entry : 0 }}</span>
                                                <span class="dbox__title">Late Entry</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_early_leave) ? $total_early_leave : 0 }}</span>
                                                <span class="dbox__title">Early Leave</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($missing_exit) ? $missing_exit : 0 }}</span>
                                                <span class="dbox__title">Missing Exit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card section end -->
                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0" id="attendanceReport">
                                    <thead>
                                    <tr>
                                        <th>Employee</th>
                                        @php
                                            $period = new DatePeriod(
                                                new DateTime(Request::get('date_from')),
                                                new DateInterval('P1D'),
                                                new DateTime(date("Y-m-d", strtotime(date(Request::get('date_to')). "+1 day")))
                                            );
                                        @endphp
                                        @foreach ($period as $key => $value)
                                        <th class="text-bold">{{ $value->format('M d')  }}</th>
                                        @endforeach

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($attendances->groupBy('employee_id') as $items)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="javascript: void(0);">{{ $items[0]->employee->FullName }}</a>
                                                </h2>
                                            </td>
                                            @foreach ($period as $key => $value)
                                                <td class="text-bold text-center">
                                                    @foreach ($items as $item)
                                                        @if (date("Y-m-d", strtotime($item->date)) == $value->format('Y-m-d'))
                                                            @if ($item->status == \App\Utils\AttendanceStatus::PRESENT)
                                                                <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-success' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                                            @elseif($item->status == \App\Utils\AttendanceStatus::LATE)
                                                                <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                                            @elseif($item->status == \App\Utils\AttendanceStatus::HALF_DAY)
                                                                <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                                            @else
                                                                {{ _lang('attendance.status',$item->status) }}
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end:: Content -->

    <!-- Attendance Modal -->
    <div class="modal custom-modal fade" id="attendance_info" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- /Attendance Modal -->
@endsection

@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            var table = $('#attendanceReport').DataTable( {
                responsive: true,
                dom: 'Bftiprl',
                buttons: [
                    'excelHtml5'
                ],
                "searching": true
            } );
        } );

        new $.fn.dataTable.FixedHeader( table );
    </script>
@endpush



@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    
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
            format: 'mm',
            viewMode: 'months',
            minViewMode: 'months'
        });

        $('#year-pick').datepicker({
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

    <script>
        $('#attendance_info').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var attendance_id = button.data('attendance-id') // Extract info from data-* attributes
            let url = "{{ route('user.team.attandance.details') }}";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    attendance_id,
                    "_token": "{{ csrf_token() }}",
                },
                // dataType: 'json',
                success: function (res) {
                    $('.modal-body').html(res);

                },
                error: function (request, status, error) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });
        });
    </script>
@endpush
