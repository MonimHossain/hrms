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
                            Attendance Summary
                        </h3>
                    </div>
                    <span class="pull-right">
                        @if($id == null)
                        <a href="{{ route('user.leave') }}" class="btn btn-outline-success"
                            style="position: relative; top: 12px;">Apply Leave</a>
                        @endif
                    </span>
                </div>
                <br>
                <div class="kt-portlet__body" style="padding: 0 25px;">
                    <div class="kt-section dtHorizontalExampleWrapper ">


                    @php
                    $total_office = 0;
                    $total_present = 0;
                    $total_absent = 0;
                    $total_late_entry = 0;
                    $total_early_leave = 0;
                    $missing_exit = 0;
                    $half_day = 0;

                    if ($rosters->isNotEmpty()){
                        foreach ($rosters as $item){
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
                                elseif ((strtotime($item->work_hours) < strtotime('7:30:00')) && (strtotime($item->work_hours) >
                                    strtotime('4:30:00'))) {
                                    $half_day++;
                                    }
                                else{
                                //
                                }
                            }
                        }
                    }
                    @endphp


                    <div class="container">
                        <form class="kt-form" action="{{ route('leave.dashboard') }}" method="get">
                            {{-- @csrf --}}
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
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <div class="kt-form__actions" style="margin-top: 26px;">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-2">
                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                        <a href="#rosterSection" id="rosterSectionButton" class="btn btn-warning">Change
                                            Request</a>
                                    </div>
                                </div> --}}
                            </div>
                        </form>
                    </div>

                    <div class="container">
                        <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>
                    </div>

                        <!-- card section start -->
                    <div class="container">
                        {{-- <div class="row">
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span class="dbox__count">{{ isset($total_office) ? $total_office : 0 }}</span>
                                        <span class="dbox__title">Total Office</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span
                                            class="dbox__count">{{ isset($total_present) ? ($total_present + $total_late_entry) : 0 }}</span>
                                        <span class="dbox__title">Present</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span class="dbox__count">{{ isset($total_absent) ? $total_absent : 0 }}</span>
                                        <span class="dbox__title">Absent</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span
                                            class="dbox__count">{{ isset($total_late_entry) ? $total_late_entry : 0 }}</span>
                                        <span class="dbox__title">Late Entry</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span
                                            class="dbox__count">{{ isset($total_early_leave) ? $total_early_leave : 0 }}</span>
                                        <span class="dbox__title">Early Leave</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="dbox dbox--color-3">
                                    <div class="dbox__body">
                                        <span class="dbox__count">{{ isset($missing_exit) ? $missing_exit : 0 }}</span>
                                        <span class="dbox__title">Missing Exit</span>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-xs-6 col-md-3">
                                <a class="info-tile tile-success" href="#">
                                    <div class="tile-heading">
                                        <div class="pull-left">Present</div>
                                        {{-- <div class="pull-right">+4.5%</div> --}}
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-check"></i></div>
                                        <div class="pull-right">
                                            {{ isset($total_present) ? ($total_present + $total_late_entry) : 0 }}</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <a class="info-tile tile-danger" href="#">
                                    <div class="tile-heading">
                                        <div class="pull-left">Absent</div>
                                        {{-- <div class="pull-right">+4.5%</div> --}}
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-times"></i></div>
                                        <div class="pull-right">
                                            {{ isset($total_absent) ? $total_absent : 0 }}</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <a class="info-tile tile-sky" href="#">
                                    <div class="tile-heading">
                                        <div class="pull-left">Half Days</div>
                                        {{-- <div class="pull-right">+4.5%</div> --}}
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-minus"></i></div>
                                        <div class="pull-right">
                                            {{ isset($half_day) ? $half_day : 0 }}</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <a class="info-tile tile-orange" href="#">
                                    <div class="tile-heading">
                                        <div class="pull-left">Approved Leaves</div>
                                        {{-- <div class="pull-right">+4.5%</div> --}}
                                    </div>
                                    <div class="tile-body">
                                        <div class="pull-left"><i class="fas fa-user-injured"></i></div>
                                        <div class="pull-right">
                                            {{ isset($approvedLeaves) ? $approvedLeaves : 0 }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- card section end -->



                    <div class="container">
                        <div class="row">
                            {{-- {!! $calendar->calendar() !!} --}}
                            <div class="col-sm-12">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- <hr>
                    <div class="kt-section dtHorizontalExampleWrapper" id="rosterSection">
                        <div class="kt-portlet__head-label">
                            <h5 class="kt-portlet__head-title">
                                Roster
                            </h5>
                        </div>

                        <table class="table table-bordered table-striped table-hover table-condensed" id="" width="100%">
                            <thead>
                                <tr>
                                    <th class="bold">Date</th>
                                    <th class="bold">Roster</th>
                                    <th class="bold">Attendance</th>
                                    <th class="bold">Status</th>
                                    <th class="bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($rosters as $item)
                                <tr>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->roster_start)->format('H:i:s') }} - {{  \Carbon\Carbon::parse($item->roster_end)->format('H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->punch_in)->format('H:i:s') }} - {{  \Carbon\Carbon::parse($item->punch_out)->format('H:i:s') }}</td>

                                    <td>{{ _lang('attendance.status', $item->status) }}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-date="{{ $item->date }}" class="change_request"><i class="la la-edit"></i></a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                </div>

                {{-- Modal --}}
                {{-- <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal custom-modal fade" id="attendance_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<!-- Attendance change request Modal -->
<div class="modal custom-modal fade" id="changeRequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Correction Request for <span class="text-success bold" id="changeDateTitle"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="kt-section__info text-danger mb-5">
                    * You can apply for 15 days earlier from today.
                </span>
                <br>
                <form class="kt-form mt-3" action="{{ route('user.attendance.change.request') }}" method="post">
                    @csrf

                    <input type="hidden" value="" name="change_date" id="changeDate">
                    <input type="hidden" value="2" name="status">
                    <div class="row">

                        {{-- <div class="col-sm-3">
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
                        </div> --}}

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Punch In</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control time-picker" readonly
                                        placeholder="Select time" name="punch_in" value="{{ old('punch_in') }}" />
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
                                <label>Punch Out</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control time-picker" readonly
                                        placeholder="Select time" name="punch_out" value="{{ old('punch_out') }}" />
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
                                <label>Out off Office</label>
                                <div>
                                    <select class="form-control kt-select2 process" id="kt_select2_31" name="out_of_office">
                                        <option value="">Select Option</option>
                                        <option value="Meeting">Meeting</option>
                                        <option value="Out of Office">Out of Office</option>
                                    </select>
                                </div>
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
                                    <button type="submit" name='submit' value="attendance_change" class="btn btn-primary">Request</button>
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
{{-- <link rel="stylesheet" href="https://www.jqueryscript.net/demo/animated-event-calendar/dist/simple-calendar.css"> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pg-calendar@1.4.31/dist/css/pignose.calendar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />

{{-- attendance css --}}
<link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

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

    .fc-event .fc-time {
        color: white !important;
    }

    .fc-event .fc-title {
        color: white !important;
    }

    .fc-time{
        display : none;
    }

</style>

@endpush

@push('library-js')
{{-- <script src="https://www.jqueryscript.net/demo/animated-event-calendar/dist/jquery.simple-calendar.js"></script> --}}
<script src="{{ asset('assets/vendors/general/moment/moment.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/pg-calendar@1.4.31/dist/js/pignose.calendar.js"></script>
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
<script src="{{ asset('assets/js/demo1/pages/crud/metronic-datatable/base/html-table.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
{{-- {!! $calendar->script() !!} --}}


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

    $('#change-request-date').datepicker({
        rtl: KTUtil.isRTL(),
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows,
    });

    $('.time-picker').timepicker({
        minuteStep: 1,
        defaultTime: "",
        showSeconds: !0,
        showMeridian: !1,
        snapToStep: !0
    });

</script>

<script>
    $(document).ready(function () {

        // Add smooth scrolling to all links
        $("#rosterSectionButton").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1500, function(){

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });

        $(document).on('click', '.change_request', function(){
            $('#attendance_info').modal('hide');
        });
        $(document).on('click', '.change_request', function(){
            let changeDate = $(this).data('date');
            $('#changeRequest').modal('show');
            $("#changeRequest .modal-body #changeDate").val( changeDate );
            $("#changeRequest #changeDateTitle").text( changeDate );
        });

        // $(function() {
            // $('#calendar-{{$calendar->getId()}}').fullCalendar({
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
                    @foreach($approvedLeavesData as $approvedLeave)
                        @php 
                            if($approvedLeave->quantity > 1){
                                $endDate = date('Y-m-d H:i:s', strtotime('+1 day', $approvedLeave->end_date));
                            } else {
                                $endDate = $approvedLeave->end_date;
                            }
                        @endphp
                    {
                        id: '{{ $approvedLeave->id }}',
                        title : "{{ 'Leave - ' . $approvedLeave->leaveType->short_code }}",
                        start : '{{ $approvedLeave->start_date }}',
                        end: '{{ $endDate }}',
                        color: '#ffa726',
                        type: 'leave',
                    },
                    @endforeach
                    @foreach($rosters as $attendance)
                        @if(!in_array($attendance->date, $leave_dates))
                        {
                            id: '{{ $attendance->id }}',
                            title : "{{ _lang('attendance.status', $attendance->status) }}",
                            start : '{{ $attendance->date }}',
                            end: '{{ $attendance->date }}',
                            type: 'attendance',
                            @if($attendance->status == \App\Utils\AttendanceStatus::ABSENT)
                                color: '#EF5350',
                            @elseif($attendance->status == \App\Utils\AttendanceStatus::PRESENT)
                                color: '#4CAF50',
                            @elseif($attendance->status == \App\Utils\AttendanceStatus::LATE)
                                color: '#FFA726',
                            @elseif($attendance->status == \App\Utils\AttendanceStatus::DAYOFF)
                                color: '#424242',
                            @elseif($attendance->status == \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF)
                                color: '#424242',
                            @else
                                color: '#e040fb',
                            @endif

                        },
                        @endif
                    @endforeach                    
                ],
                eventRender: function(event, element, view) {
                    $(element[0]).attr('data-toggle', 'modal');
                    $(element[0]).attr('data-target', '#attendance_info');
                },
                eventClick: function(calEvent, jsEvent, view){
                    console.log(calEvent.type);
                    // $('#attendance_info').modal();
                    if(calEvent.type == 'attendance') {
                        $('#attendance_info').on('show.bs.modal', function () {

                        var attendance_id = calEvent.id // Extract info from data-* attributes
                        let url = "{{ route('user.team.attandance.details') }}";
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
                                    $('#attendance_info .modal-body').html(res);

                                },
                                error: function (request, status, error) {
                                    console.log("ajax call went wrong:" + request.responseText);
                                }
                            });
                        });
                        $('#attendance_info').on('hide.bs.modal', function (e) {
                            $('#attendance_info .modal-body').html('');
                        });
                    } else {
                        $('#attendance_info .modal-body').html('<p class="text-center">On Leave</p>');
                    }
                }
            });

        // });


        // $('#attendance_info').on('show.bs.modal', function (event) {
        //     var button = $(event.relatedTarget) // Button that triggered the modal
        //     var attendance_id = button.data('attendance-id') // Extract info from data-* attributes

        //     let url = "{{ route('user.team.attandance.details') }}";
        //     $.ajax({
        //         type: "post",
        //         url: url,
        //         data: {
        //             attendance_id,
        //             "_token": "{{ csrf_token() }}",
        //         },
        //         // dataType: 'json',
        //         success: function (res) {
        //             $('.modal-body').html(res);

        //         },
        //         error: function (request, status, error) {
        //             console.log("ajax call went wrong:" + request.responseText);
        //         }
        //     });
        // });
    });

</script>
@endpush