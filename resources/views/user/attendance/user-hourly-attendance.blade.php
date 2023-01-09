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
                    My Daily Attendance
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body ">

            {{-- // TODO daily attendance report for single user --}}
            <div class="row hidden">
                {{-- <div class="col-md-6">
                    <div class="card punch-status">
                        <div class="card-body">
                            <h5 class="card-title">Timesheet <small class="text-muted">11 Mar 2019</small></h5>
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

                <div class="col-md-6">
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
                                    <p>This Month <strong>28 <small>/ 40 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 31%"
                                            aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-md-4">
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
                </div> --}}
            </div>


            {{-- <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div> --}}

            <div class="kt-section">

                <form class="kt-form" action="{{ route('user.hourly.attendance.view') }}" method="get">
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
                                <div class="kt-form__actions" style="margin-top: 26px;">
                                    <button type="submit" class="btn btn-primary">Filter</button>
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

                    {{-- roster calendar view --}}
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <div id="calendar"></div>
                        </div>
                    </div> --}}

                    <?php
                    
                    function sum_the_time($time1, $time2) {
                        $times = array($time1, $time2);
                        $seconds = 0;
                        foreach ($times as $time)
                        {
                            list($hour,$minute,$second) = explode(':', $time);
                            $seconds += $hour*3600;
                            $seconds += $minute*60;
                            $seconds += $second;
                        }
                        $hours = floor($seconds/3600);
                        $seconds -= $hours*3600;
                        $minutes  = floor($seconds/60);
                        $seconds -= $minutes*60;
                        // return "{$hours}:{$minutes}:{$seconds}";
                        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); 
                    }
                    function sum_rate($time, $rate) {
                        $rate = $rate/3600;
                        $times = array($time);
                        $seconds = 0;
                        foreach ($times as $time)
                        {
                            list($hour,$minute,$second) = explode(':', $time);
                            $seconds += $hour*3600;
                            $seconds += $minute*60;
                            $seconds += $second;
                        }
                        $total = $seconds * $rate;
                        return $total;
                    }
                    $total_month_hour = "00:00:00";
                    $total_month_earn = 0;
                    ?>

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <tr>
                                    <th>Date</th>
                                    <th>Ready Hour</th>
                                    <th>Lag Hour</th>
                                    <th>Break Hour</th>
                                    <th>Total Hour</th>
                                    <th>Amount</th>
                                <tr>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        @php
                                            $total_hour = sum_the_time($attendance->ready_hour, $attendance->lag_hour);
                                            $total_month_hour = sum_the_time($total_month_hour, $total_hour);
                                            $total_month_earn += sum_rate($total_hour, 45)
                                        @endphp

                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->ready_hour }}</td>
                                        <td>{{ $attendance->lag_hour }}</td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $total_hour }}</td>
                                        <td>{{ number_format(sum_rate($total_hour, 45), 2) }}</td>
                                    </tr>
                                @endforeach()
                                <tr>
                                    <th colspan="4" class="text-right">
                                        Total
                                    </th>
                                    <th>
                                        {{ $total_month_hour }}
                                    </th>
                                    <th>
                                        {{ number_format($total_month_earn, 2) }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    
                    @endif


                </div>
            </div>
        </div>
    </div>

</div>

<!-- end:: Content -->

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
        format: 'yyyy-mm',
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
                    title : '{{ $attendance->lag_hour }}',
                    @if($attendance->lag_hour)
                        color: '#2dbdb6',
                    @endif
                    start : '{{ $attendance->date }}',
                    end: '{{ $attendance->date }}',
                },
                {
                    id: '{{ $attendance->id }}',
                    title : '{{ $attendance->ready_hour }}',
                    @if($attendance->ready_hour)
                        color: '#2739c1',
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
