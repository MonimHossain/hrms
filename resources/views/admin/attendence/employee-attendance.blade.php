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
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>Employee:</label>
                                <select id="employee_id" name="employee_id" required class="form-control kt-selectpicker " data-live-search="true"
                                        data-placeholder="Select Employee">
                                    <option value="" selected="selected">Select</option>
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
                                    <th>Full Name</th>
                                    <th>Log Date</th>
                                    <th>Roster Start</th>
                                    <th>Roster_End</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Department</th>
                                    <th>Process</th>
                                    <th>WHours</th>
                                    <th>Over time</th>
                                    <th>Att</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            @if($employees[0])
                            <tbody>
                                @foreach ($employees[0]->attendances as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript: void(0);">{{ $employees[0]->employer_id }}</a>
                                            </h2>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="javascript: void(0);">{{ $employees[0]->FullName }}</a>
                                            </h2>
                                        </td>
                                        <th>{{ $item->date }}</th>
                                        <th>{{ $item->roster_start ? date('h:i:s A', strtotime($item->roster_start)) : '' }}</th>
                                        <th>{{ $item->roster_end ? date('h:i:s A', strtotime($item->roster_end)) : '' }}</th>
                                        <th>{{ $item->punch_in ? date('h:i:s A', strtotime($item->punch_in)) : '' }}</th>
                                        <th>{{ $item->punch_out ? date('h:i:s A', strtotime($item->punch_out)) : '' }}</th>
                                        <td>
                                            @foreach($employees[0]->departmentProcess->unique('department_id') as $dept)
                                                {{ $dept->department->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($employees[0]->departmentProcess->unique('process_id') as $processData)
                                                {{ $processData->process->name ?? null }}
                                                -
                                                {{ $processData->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach
                                        </td>
                                        <th>{{ $item->work_hours }}</th>
                                        <td></td>
                                        <th>{{ _lang('attendance.status',$item->status) }}</th>
                                        <th>{{ $item->remarks }}</th>
                                    </tr>
                                @endforeach

                            </tbody>
                            @else
                                <tbody>
                                    <tr>
                                        <th colspan="9">No attendance data found</th>
                                    </tr>
                                </tbody>
                            @endif

                        </table>
                        <!-- {{ $employees->appends(Request::all())->links() }} -->
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
