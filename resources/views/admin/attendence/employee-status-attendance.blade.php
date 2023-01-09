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
                    Employee's Attendance
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section">

                <form class="kt-form" action="{{ route('employee.attendance.view') }}" method="get">

                    <div class="row">
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>Date From</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" required placeholder="Select Month"
                                        id="month-pick" name="datefrom" value="{{ $df }}" />
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
                                    <input type="text" class="form-control" required placeholder="Select Year"
                                        id="year-pick" name="dateto" value="{{ $dt }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-2">
                            <div class="form-group">
                                <label>Department</label>
                                <select name="department_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($departments as $item)
                                    <option
                                        {{ (isset($departmentRequest) && $departmentRequest== $item->id) ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>Process</label>
                                <select name="process_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($processes as $item)
                                    <option
                                        {{ (isset($processRequest) && $processRequest == $item->id) ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>Shift</label>
                                <select name="shift" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($roster as $item)
                                    <option
                                        {{ (isset($shift) && $shift == $item->roster_start) ? 'selected' : '' }}
                                        value="{{ $item->roster_start }}">{{ $item->roster_start }} - {{ $item->roster_end }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>Employee:</label>
                                <select id="employee_id" name="employee_id" required class="form-control kt-selectpicker " data-live-search="true"
                                        data-placeholder="Select Employee">
                                    <option value="" selected="selected">Select</option>
                                    {{--                                                <select id="kt_select2_1" name="employee_id" class="form-control kt-select2" name="param">--}}
                                    {{--                                                    <option value="">Select</option>--}}
                                    {{--                                                    @foreach ($employees as $employee)--}}
                                    {{--                                                        <option value="{{$employee->id}}" data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }}--}}
                                    {{--                                                            - {{ $employee->FullName }}</option>--}}
                                    {{--                                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="kt-form__actions" >
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="kt-section__content">
                    @if (!isset($employee) && !isset( $tableDate) )

                    no records

                    @elseif($employees->count() == 0)
                    no records
                    @else

                    <?php

                        $total_office       =   0;
                        $total_present      =   0;
                        $total_absent       =   0;
                        $total_late_entry   =   0;
                        $total_early_leave  =   0;
                        $missing_exit       =   0;

                        foreach ($employees as $items){
                            if ($items->attendances->isNotEmpty()){
                                foreach ($items->attendances as $item){
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
                        }
                    ?>

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
                            </div>
                            <div class="col-md-2">
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
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Process</th>
                                    <th>Department</th>
                                    @php
                                        $period = new DatePeriod(
                                            new DateTime($df),
                                            new DateInterval('P1D'),
                                            new DateTime(date("Y-m-d", strtotime(date($dt). "+1 day")))
                                        );
                                    @endphp
                                    @foreach ($period as $key => $value)
                                    <th class="text-bold">{{ $value->format('M d')  }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($employees as $items)
                                @if ($items->attendances->isNotEmpty())
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript: void(0);">{{ $items->employer_id }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript: void(0);">{{ $items->FullName }}</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript: void(0);">@foreach($items->departmentProcess->unique('process_id') as $item)
                                                    {{ $item->process->name ?? null }}
                                                    -
                                                    {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                                @endforeach</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript: void(0);">@foreach($items->departmentProcess->unique('department_id') as $item)
                                                    {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                @endforeach</a>
                                        </h2>
                                    </td>
                                    @foreach ($period as $key => $value)
                                        <td class="text-bold text-center">
                                            @foreach ($items->attendances as $item)
                                                @if (date("Y-m-d", strtotime($item->date)) == $value->format('Y-m-d'))
                                                    @if ($item->status == \App\Utils\AttendanceStatus::PRESENT)
                                                        <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-success' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                                            data-toggle="modal"
                                                                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                                    @elseif($item->status == \App\Utils\AttendanceStatus::HALF_DAY)
                                                        <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                                        data-toggle="modal"
                                                                                        data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                                    @elseif($item->status == \App\Utils\AttendanceStatus::LATE)
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
                                    {{-- @foreach ($items->attendances as $item)
                                    @if ($item->status == \App\Utils\AttendanceStatus::PRESENT)
                                    <td class="text-bold text-center"><a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-success' : 'text-muted'}}"
                                            data-attendance-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    </td>
                                    @elseif($item->status == \App\Utils\AttendanceStatus::LATE)
                                    <td class="text-bold text-center"><a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}"
                                            data-attendance-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    </td>
                                    @else
                                    <td
                                        class="text-bold  text-center {{ ($item->status == \App\Utils\AttendanceStatus::ABSENT) ? 'text-danger' : (($item->status == \App\Utils\AttendanceStatus::DAYOFF) ? '' : 'text-warning') }}">
                                        {{ _lang('attendance.status',$item->status) }}</td>
                                    @endif
                                    @endforeach --}}

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{ $employees->appends(Request::all())->links() }}
                    </div>
                    @endif

                    {{-- // TODO Admin employee Attendace data --}}

                    <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>


                    {{-- <div class="row">
                        <div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0">
									<thead>
										<tr>
											<th>#</th>
											<th>Date </th>
											<th>Roster Start</th>
											<th>Roster End</th>
											<th>Punch In</th>
											<th>Punch Out</th>
											<th>Production</th>
											<th>Break</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>19 Mar 2019</td>
											<td>10 AM</td>
											<td>10 AM</td>
											<td>7 PM</td>
											<td>7 PM</td>
											<td>9 hrs</td>
											<td>1 hrs</td>
											<td>Present</td>
										</tr>
										<tr>
											<td>2</td>
											<td>20 Mar 2019</td>
											<td>10 AM</td>
											<td>10 AM</td>
											<td>7 PM</td>
											<td>7 PM</td>
											<td>9 hrs</td>
											<td>1 hrs</td>
											<td>Present</td>
										</tr>
									</tbody>
								</table>
							</div>
                        </div>
                    </div> --}}





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

<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />
{{-- attendance css --}}
<link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
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

    function addSelect2Ajax($element, $url, $changeCallback, data) {
        var placeHolder = $($element).data('placeholder');

        if (typeof $changeCallback == 'function') {
            $($element).change($changeCallback)
        }

        // $($element).hasClass('select2') && $($element).select2('destroy');

        return $($element).select2({
            allowClear: true,
            width: "resolve",
            ...data,
            placeholder: placeHolder,
            ajax: {
                url: $url,
                data: function (params) {
                    return {
                        keyword: params.term,
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj, index) {
                            return {id: obj.id, text: obj.name};
                        })
                    };
                }
            }
        });

    }

    addSelect2Ajax('#employee_id', "{{route('employee.all')}}");
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

$('#year-pick').datepicker({
    rtl: KTUtil.isRTL(),
    todayBtn: "linked",
    clearBtn: true,
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows,
    format: 'yyyy-mm-dd',
    // viewMode: "years",
    // minViewMode: "years"
});
</script>

<script>
    $('#attendance_info').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var attendance_id = button.data('attendance-id') // Extract info from data-* attributes
    let url = "{{ route('employee.attandance.details') }}";
    $.ajax({
        type: "post",
        url: url,
        data: {
            attendance_id,
            "_token": "{{ csrf_token() }}",
        },
        // dataType: 'json',
        success: function(res) {
            $('.modal-body').html(res);

        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
});
</script>
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
