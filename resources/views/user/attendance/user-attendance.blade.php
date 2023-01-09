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
                    My Roster
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body ">

            {{-- // TODO daily attendance report for single user --}}
            {{-- <div class="row">
                <div class="col-md-4">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small></h5>
                            <div class="punch-det">
                                <h6>Punch In at</h6>
                                <p>Wed, 11th Mar 2019 10.00 AM</p>
                            </div>
                            <div class="punch-info">
                                <div class="punch-hours">
                                    <span>3.45 hrs</span>
                                </div>
                            </div>
                            <div class="punch-btn-section">
                            </div>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box">
                                            <p>Break</p>
                                            <h6>1.21 hrs</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box">
                                            <p>Overtime</p>
                                            <h6>3 hrs</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div class="stats-list">
                                <div class="stats-info">
                                    <p>Today <strong>3.45 <small>/ 8 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 31%"
                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Week <strong>28 <small>/ 40 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 31%"
                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>This Month <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 62%"
                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="stats-info">
                                    <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 62%"
                                            aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Today Activity</h5>
                            <ul class="res-activity-list">
                                <li>
                                    <p class="mb-0">Punch In at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        10.00 AM.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Punch Out at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        11.00 AM.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Punch In at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        11.15 AM.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Punch Out at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        1.30 PM.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Punch In at</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        2.00 PM.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}


            {{-- <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div> --}}

            <div class="kt-section">

                <form class="kt-form" action="{{ route('user.attendance.view') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label>Month</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly placeholder="Select Month"
                                        id="month-pick" name="month" value="{{ $month }}" />
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
                                <label>year</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly placeholder="Select Year"
                                        id="year-pick" name="year" value="{{ $year }}" />
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
                                <div class="kt-form__actions" style="margin-top: 26px;">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>


                <div class="kt-section__content">
                    @if (!isset($attendances) )

                    No records for this month

                    @elseif($attendances->count() == 0)
                    No records for this month
                    @else

                    {{-- roster calendar view --}}
                    <div class="row">
                        <div class="col-sm-8 offset-sm-2">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    {{-- <div class="table-responsive">
                        <table class="table table-striped custom-table table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    @foreach($attendances as $attendance)
                                    <th
                                        class="text-bold {{ (\Carbon\Carbon::now()->format('d') >= \Carbon\Carbon::parse($attendance->date)->format('d')) ? 'text-info' : '' }}">
                                        {{ \Carbon\Carbon::parse($attendance->date)->format('M d') }}</th>
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
                                    @foreach ($items as $item)
                                    @if ($item->status == \App\Utils\AttendanceStatus::PRESENT)
                                    <td class="text-bold text-center"><a href="javascript:void(0);"
                                            class="{{ ($item->punch_in && $item->punch_out) ? 'text-success' : 'text-muted'}}"
                                            data-attendance-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    </td>
                                    @elseif($item->status == \App\Utils\AttendanceStatus::LATE)
                                    <td class="text-bold text-center"><a href="javascript:void(0);"
                                            class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}"
                                            data-attendance-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    </td>
                                    @else
                                    <td
                                        class="text-bold  text-center {{ ($item->status == \App\Utils\AttendanceStatus::ABSENT) ? 'text-danger' : (($item->status == \App\Utils\AttendanceStatus::DAYOFF) ? '' : 'text-warning') }}">
                                        {{ _lang('attendance.status',$item->status) }}</td>
                                    @endif
                                    @endforeach

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}




                    {{-- // TODO demo attendace table --}}
                    {{-- <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date </th>
                                            <th>Roster</th>
                                            <th>Attendance</th>
                                            <th>Working Hrs</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $attendance)
                                        <tr>

                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->roster_start)->toTimeString() }} - {{ \Carbon\Carbon::parse($attendance->roster_end)->toTimeString() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->punch_id)->toTimeString() }} - {{ \Carbon\Carbon::parse($attendance->punch_out)->toTimeString() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->work_hours)->toTimeString() }}</td>
                                            @if ($attendance->status == \App\Utils\AttendanceStatus::PRESENT)
                                            <td class="text-bold "><a href="javascript:void(0);"
                                                    class="{{ ($attendance->punch_in && $attendance->punch_out) ? 'text-success' : 'text-muted'}}"
                                                    data-attendance-id="{{ $attendance->id }}" data-toggle="modal"
                                                    data-target="#attendance_info">{{ _lang('attendance.status',$attendance->status) }}</a>
                                            </td>
                                            @elseif($attendance->status == \App\Utils\AttendanceStatus::LATE)
                                            <td class="text-bold "><a href="javascript:void(0);"
                                                    class="{{ ($attendance->punch_in && $attendance->punch_out) ? 'text-warning' : 'text-muted'}}"
                                                    data-attendance-id="{{ $attendance->id }}" data-toggle="modal"
                                                    data-target="#attendance_info">{{ _lang('attendance.status',$attendance->status) }}</a>
                                            </td>
                                            @else
                                            <td
                                                class="text-bold  {{ ($attendance->status == \App\Utils\AttendanceStatus::ABSENT) ? 'text-danger' : (($attendance->status == \App\Utils\AttendanceStatus::DAYOFF) ? '' : 'text-warning') }}">
                                                {{ _lang('attendance.status',$attendance->status) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    @endif


                </div>
            </div>
        </div>
    </div>

</div>

<!-- end:: Content -->

<!-- Roster Modal -->
<div class="modal custom-modal fade" id="roster_info" role="dialog">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Roster Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<!-- /Roster Modal -->

<!-- Attendance change request Modal -->
<div class="modal custom-modal fade" id="changeRequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Roster change request for <span class="text-success bold" id="changeDateTitle"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <span class="kt-section__info text-danger mb-5">
                    * You can apply for 15 days earlier from today.
                </span>
                <br> --}}
                <form class="kt-form mt-3" action="{{ route('user.attendance.change.request') }}" method="post">
                    @csrf

                    <input type="hidden" value="" name="change_date" id="changeDate">
                    <input type="hidden" value="1" name="status" >
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Roster Start</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control time-picker" readonly
                                        placeholder="Select time" name="roster_start" value="{{ old('roster_start') }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Roster End</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control time-picker" readonly
                                        placeholder="Select time" name="roster_end" value="{{ old('roster_end') }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-clock-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-1 text-center mt-5">
                            - OR -
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group mt-5">
                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                    <input type="checkbox" name="is_adjusted_day_off" class="is_adjusted_day_off" value="1"> Is adjusted day off?
                                        <span></span>
                                </label>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group form-group-last">
                                <label for="exampleTextarea">Remarks</label>
                                <textarea class="form-control" id="exampleTextarea" rows="3" spellcheck="false"
                                    name="remarks" required></textarea>
                            </div>
                        </div>

                        <div class="col-xl-2">
                            <div class="form-group">
                                <div class="kt-form__actions" style="margin-top: 26px;">
                                    <button type="submit" name='submit' value="roster_change" class="btn btn-primary">Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- {{ dd($rosters) }} --}}
<!-- /Attendance Modal -->
@endsection

@push('css')

<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />
{{-- attendance css --}}
<link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />

@endpush


@push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js') }}" type="text/javascript">
</script>
@endpush


@push('js')
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
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

    $('.time-picker').timepicker({
        minuteStep: 1,
        defaultTime: "",
        showSeconds: !0,
        showMeridian: !1,
        snapToStep: !0,
    });

</script>


<script>
    $(document).ready(function (){

        $(document).on('click', '.change_request', function(){
            $('#roster_info').modal('hide');
        });
        $(document).on('click', '.change_request', function(){
            let changeDate = $(this).data('date');
            $('#changeRequest').modal('show');
            $("#changeRequest .modal-body #changeDate").val( changeDate );
            $("#changeRequest #changeDateTitle").text( changeDate );
        });

        $(document).on('change', '.is_adjusted_day_off', function () {
            if($(this).is(":checked")){
                $('.time-picker').prop('readonly', false).prop('disabled', true);
            }else{
                $('.time-picker').prop('readonly', true).prop('disabled', false);
            }
        });

        $('#calendar').fullCalendar({
            selectable: true,
            // theme: true,
            // themeSystem:'bootstrap3',
            displayEventTime : false,
            header: {
                left: null,
                center: 'title',
                right: null
            },
            contentHeight: 'auto',
            defaultDate: new Date({{ $year }}, {{ $month }}-1, 1),
            events : [
                @foreach($attendances as $attendance)
                {

                    id: '{{ $attendance->id }}',
                    @if($attendance->status != \App\Utils\AttendanceStatus::DAYOFF && $attendance->status != \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF && $attendance->roster_start && $attendance->roster_end)
                    // title : 'Roster <br> {{ Carbon\Carbon::parse($attendance->roster_start)->format('H:i:s'). ' - '. Carbon\Carbon::parse($attendance->roster_end)->format('H:i:s') }}',
                    title : 'WD <br> {{ Carbon\Carbon::parse($attendance->roster_start)->format('H:i') }} - {{ Carbon\Carbon::parse($attendance->roster_end)->format('H:i') }}',
                    color: '#4CAF50',
                    @elseif($attendance->status == \App\Utils\AttendanceStatus::DAYOFF)
                    title : "DAYOFF",
                    color: '#424242',
                    @elseif($attendance->status == \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF)
                    title : "ADO",
                    color: '#424242',
                    @endif
                    start : '{{ $attendance->date }}',
                    end: '{{ $attendance->date }}',


                },
                @endforeach
            ],
            eventRender: function(event, element, view) {
                // console.log(element[0]);
                // console.log(event);

                $(element[0]).attr('data-toggle', 'modal');
                $(element[0]).attr('data-target', '#roster_info');
                element.find('span.fc-title').html(element.find('span.fc-title').text());
            },
            eventClick: function(calEvent, jsEvent, view){
                console.log(calEvent.id);
                // $('#attendance_info').modal();

                $('#roster_info').on('show.bs.modal', function () {

                    var attendance_id = calEvent.id // Extract info from data-* attributes
                    let url = "{{ route('user.roster.details') }}";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            attendance_id,
                            "_token": "{{ csrf_token() }}",
                            "change_request": 1,
                        },
                        // dataType: 'json',
                        success: function (res) {
                            $('#roster_info .modal-body').html(res);

                        },
                        error: function (request, status, error) {
                            console.log("ajax call went wrong:" + request.responseText);
                        }
                    });
                });
                $('#roster_info').on('hide.bs.modal', function (e) {
                    $('#roster_info .modal-body').html('');
                });
            }
        });
    });
</script>
@endpush
