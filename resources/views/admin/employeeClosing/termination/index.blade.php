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
                                Separated Employee List
                            </h3>
                        </div>
                        <a href="" style="position: relative; top: 5px" title="Emergency Employee Closing Form" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.employee.termination.create') }}" class="text-primary custom-btn globalModal">
                            <span class="btn btn-outline-primary">Separate</span>
                        </a>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form" action="{{ route('admin.employee.termination')  }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Select Month</label>
                                        <div class="input-group date">
                                            <input type="text" readonly="readonly" required="required" placeholder=""
                                                   name="month" value="" class="form-control month-pick">
                                            <div class="input-group-append"><span class="input-group-text"><i
                                                        class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} : {{ $employee->FUllName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Separation Type</label>
                                            <div class="input-group">
                                                <select name="separation_type" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach(\App\Utils\EmployeeClosing::SeparationReason as $key=>$value)
                                                        <option value="{{ $value }}">{{ ucfirst(_lang('employee-closing.separationReason.'.$value)) }}</option>
                                                    @endforeach
                                                </select>
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


                            <div class="table-responsive">
                                @if(count($closingApplication) > 0)
                                <table class="table table-bordered table-striped custom-table table-nowrap mb-0">
                                    <tr>
                                            <th>Employee</th>
                                            <th>Reasons</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                            @foreach($closingApplication as $close)
                                            <tr>
                                                <td>
                                                    {{ $close->employee->employer_id }} - {{ $close->employee->FullName }}
                                                </td>
                                                <td>
                                                    @isset($close->separation_type)
                                                    {{  _lang('employee-closing.separationReason.'.$close->separation_type) }}
                                                    @endisset
                                                </td>
                                                <td>
                                                   {!! $close->termination_remarks !!}
                                                </td>
                                                <td>
                                                    <a href="" style="position: relative; top: 5px" title="Closing Application Form" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.employee.termination.view', ['id'=> $close->employee_id]) }}" class="text-primary custom-btn globalModal">
                                                        <span class="btn btn-outline-primary">View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                </table>
                                    {{ $closingApplication->appends(Request::all())->links()  }}
                                @else
                                    <p>Not Found !</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <!--end::Form-->


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
