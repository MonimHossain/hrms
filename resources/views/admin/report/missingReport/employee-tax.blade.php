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
                                Employee Tax CSV Missing Report
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                             <form class="kt-form" action="{{ route('missing.report.employee.hour.csv') }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Start Date</label>
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

                                    <div class="col-xl-2">
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
                                    </div>

                                    <div class="col-xl-2">
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
                                                @if($salary_history->count())
                                                    <a class="btn btn-primary " href="{{ Request::fullUrl() . "&csv=true" }}">Downlaod CSV</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form> 

                            <div class="row">
                                <div class="col-md-12">
                                    
    
</div>
</div>

<div class="table-responsive">
<table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="lookup">
<thead>
<tr>
    <th>Date</th>
    <th>Employee Info</th>
    <th>Hour type</th>
    <th>Ready hour</th>
    <th>Lag hour</th>
    <th>Created By</th>
    <th>Updated By</th>
    <th>Remarks</th>
    <!-- <th>Action</th> -->
</tr>
</thead>
<tbody>
  @foreach($salary_history as $salary)
        <tr>
            <td>{{ date_format(date_create($salary->date),"d F Y") }}</td>
            <td>{{ $salary->employer_id ?? '' }}</td>
            <td>{{ $hour_type[$salary->hour_type] }}</td>
            <td>{{ $salary->ready_hour }}</td>
            <td>{{ $salary->lag_hour }}</td>
            <td>{{ $salary->createdBy ? $salary->createdBy->fullName : '-' }}</td>
            <td>{{ $salary->updatedBy ? $salary->updatedBy->fullName : '-' }}</td>
            <td>{{ $salary->remarks ? $salary->remarks : '-' }}</td>
            <td>
            <a href="#" redirect="missing.report.employee.hour.csv" modelName="EmployeeHours" id="{{ $salary->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
            </td>
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
format: 'yyyy-mm-dd',
viewMode: 'days',
minViewMode: 'days'
});

</script>
@endpush




