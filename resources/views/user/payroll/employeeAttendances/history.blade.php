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
                                Employee Attendance History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form" action="{{ route('employee.manage.salary.employee.attendance') }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <div class="input-group date">
                                                <input required type="text" autocomplete="off" class="form-control month-pick" name="start_date" placeholder="Select Date" value="{{ Request::get('start_date') }}">
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
                                            <label>End Date</label>
                                            <div class="input-group date">
                                                <input required type="text" autocomplete="off" class="form-control month-pick" name="end_date" placeholder="Select Date" value="{{ Request::get('end_date') }}">
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
                                            <label>Attendance Type</label>
                                            <div class="input-group date">
                                                <select name="attendance_type" class="form-control" id="">
                                                    <option value="">All</option>

                                                    <!-- <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::CASUAL_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::CASUAL_LEAVE }}">Casual Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::SICK_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::SICK_LEAVE }}">Sick Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::EARNED_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::EARNED_LEAVE }}">Earned Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::MATERNITY_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::MATERNITY_LEAVE }}">Maternity Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::PATERNITY_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::PATERNITY_LEAVE }}">Paternity Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::LEAVE_WITHOUT_PAY ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::LEAVE_WITHOUT_PAY }}">Leave Without Pay</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::PRESENT ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::PRESENT }}">Present</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::WITHOUT_ROSTER ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::WITHOUT_ROSTER }}">Without Roster</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::HOLIDAY ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::HOLIDAY }}">Holly Day</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::DAYOFF ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::DAYOFF }}">Day Off</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF }}">Adjustment Day Off</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::LATE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::LATE }}">Late</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::EARLY_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::EARLY_LEAVE }}">Early Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::ANNUAL_LEAVE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::ANNUAL_LEAVE }}">Annual Leave</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::CASUAL_LEAVE_HALF ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::CASUAL_LEAVE_HALF }}">Casual Leave Half</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::ANNUAL_LEAVE_HALF ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::ANNUAL_LEAVE_HALF }}">Annual Leave Half</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::OUT_OF_OFFICE ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::OUT_OF_OFFICE }}">Out of Office</option>
                                                    <option {{ Request::get('attendance_type') == \App\Utils\AttendanceStatus::HALF_DAY ? 'selected':'' }} value="{{ \App\Utils\AttendanceStatus::HALF_DAY }}">Half Day</option> -->

                                                    <option {{ Request::get('attendance_type') == 'P' ? 'selected':'' }} value="'P'">P</option>
                                                    <option {{ Request::get('attendance_type') == 'A' ? 'selected':'' }} value="'A'">A</option>
                                                    <option {{ Request::get('attendance_type') == 'HD' ? 'selected':'' }} value="HD">HD</option>
                                                    <option {{ Request::get('attendance_type') == 'HDP' ? 'selected':'' }} value="HDP">HDP</option>
                                                    <option {{ Request::get('attendance_type') == 'GH' ? 'selected':'' }} value="GH">GH</option>
                                                    <option {{ Request::get('attendance_type') == 'ADO' ? 'selected':'' }} value="ADO">ADO</option>
                                                    <option {{ Request::get('attendance_type') == 'LWP' ? 'selected':'' }} value="LWP">LWP</option>
                                                    <option {{ Request::get('attendance_type') == 'L' ? 'selected':'' }} value="L">L</option>
                                                    <option {{ Request::get('attendance_type') == 'W' ? 'selected':'' }} value="W">W</option>
                                                    <option {{ Request::get('attendance_type') == 'Off' ? 'selected':'' }} value="Off">Off</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <input type="text" name="employee_id" class="form-control" value="{{ Request::get('employee_id') }}" placeholder="Enter Employee ID" id="">
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
                                @canany([_permission(\App\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_CREATE)])
                                    <a href="#" title="Add Employee Attendance" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('employee.add.salary.employee.attendance') }}" class="custom-btn globalModal btn btn-sm btn-primary pull-letf">
                                        Add new record
                                    </a>
                                @endcan
                                @canany([_permission(\App\Utils\Permissions::EMPLOYEE_ATTENDANCE_CLEARANCE_VIEW)])
                                    @if($clearance['flag'])
                                    <a href="#" title="Employee Attendance Clearance" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('employee.upload.salary.employee.attendance.clearance.view', ['startDate'=>$startDate, 'endDate'=>$endDate]) }}" class="custom-btn globalModal btn btn-sm btn-primary pull-right">
                                        Clearance
                                    </a>
                                    @endif
                                @endcan
</div>
</div>

<div class="table-responsive">
<table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="lookup">
<thead>
<tr>
    <th>Date</th>
    <th>Employee Info</th>
    <th>Attendance type</th>
    <th>Created By</th>
    <th>Updated By</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
    @foreach($salary_history as $salary)
        <tr>
            <td>{{ date_format(date_create($salary->date),"d F Y") }}</td>
            <td>{{ $salary->employer_id ?? '' }}</td>
            <td>{{ $salary->status ?? '' }}</td>
            <td>{{ (!empty($salary->createdBy)) ? $salary->createdBy->fullName : '-' }}</td>
            <td>{{ (!empty($salary->updatedBy)) ? $salary->updatedBy->fullName : '-' }}</td>
            <td>
            @canany([_permission(\App\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_EDIT)])
            <a href="#" title="Edit Employee Attendance" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('employee.edit.salary.employee.attendance', ['id'=>$salary->id]) }}" class="text-primary custom-btn globalModal">
                <i class="flaticon-edit"></i>
            </a>
            @endcan
            @canany([_permission(\App\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_DELETE)])
            | <a href="{{ route('employee.delete.salary.employee.attendance', ['id'=>$salary->id]) }}"><i class="flaticon-delete"></i></a>
            </td>
            @endcan
        </tr>
    @endforeach
</tbody>
</table>
{{ $salary_history->appends(Request::all())->links() }}
</div>
</div>
</div>
</div>
<!--end::Portlet-->
</div>
</div>
</div>
@endsection
@include('layouts.lookup-setup-delete')


<!-- @push('css')
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
@endpush -->


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
format: 'yyyy-mm-dd',
viewMode: 'days',
minViewMode: 'days'
});

/*Employee List*/
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

//addSelect2Ajax('#employee_id', "{{ route('employee.all') }}");

</script>
@endpush




