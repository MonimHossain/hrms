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
                                Salary History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form center-division-form" action="{{ route('manage.salary.history') }}" method="GET">
                                <div class="row">
{{--                                    <div class="col-xl-2">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label>Month</label>--}}
{{--                                            <div class="input-group date">--}}
{{--                                                <input type="text" autocomplete="off" required class="form-control month-pick" name="date" placeholder="Select Month" value="{{ Request::get('date') }}">--}}
{{--                                                <div class="input-group-append">--}}
{{--                                        <span class="input-group-text">--}}
{{--                                            <i class="la la-calendar-check-o"></i>--}}
{{--                                        </span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-xl-2">
                                        <div class="form-group center-division-item">
                                            <label>Division</label>
                                            <select id="division" name="division_id" class="form-control division" required>
                                                <option value="">Select Division <span class="text-danger">*</span></option>
                                                @foreach ($divisions as $item)
                                                    <option value="{{ $item->id }}" {{ (old('division_id') == $item->id || Request::get('division_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group center-division-item">
                                            <label>center</label>
                                            <select id="center" name="center_id" class="form-control center" required>
                                                <option value="">Select Center <span class="text-danger">*</span></option>
                                                @foreach ($centers as $item)
                                                    <option value="{{ $item->id }}" {{ (old('center_id') == $item->id || Request::get('center_id') == $item->id) ? 'selected' : '' }}>{{ $item->center }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select id="department" name="department_id" class="form-control department">
                                                <option value="">Select Department <span class="text-danger">*</span></option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}" {{ (old('department_id') == $item->id || Request::get('department_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Process</label>
                                            <select id="process" name="process_id" class="form-control process">
                                                <option value="">Select Process <span class="text-danger">*</span></option>
                                                @foreach ($processes as $item)
                                                    <option value="{{ $item->id }}" {{ (old('process_id') == $item->id || Request::get('process_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}


                                    <div class="col-xl-2">
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
                                    <div class="col-xl-2">
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
                                    @php
                                        $employeeType = [];
                                        $flag = 0;
                                    @endphp

                                    @can(_permission(\App\Utils\Permissions::MANAGE_SALARY_HOURLY_VIEW))
                                        @php
                                            array_push($employeeType, \App\Utils\EmploymentTypeStatus::HOURLY);
                                            array_push($employeeType, \App\Utils\EmploymentTypeStatus::PROJECTBASEHOURLY);
                                        @endphp
                                    @endcan

                                    @can(_permission(\App\Utils\Permissions::MANAGE_SALARY_CONTRACTUAL_VIEW))
                                        @php
                                            array_push($employeeType, \App\Utils\EmploymentTypeStatus::CONTRACTUAL);
                                            array_push($employeeType, \App\Utils\EmploymentTypeStatus::PROJECTBASEFIXED);
                                        @endphp
                                    @endcan

                                    @can(_permission(\App\Utils\Permissions::MANAGE_SALARY_PERMANENT_VIEW))
                                        @can(_permission(\App\Utils\Permissions::ADMIN_SALARY_VIEW))
                                            @php
                                                $flag = 1;
                                                array_push($employeeType, \App\Utils\EmploymentTypeStatus::PROBATION);
                                                array_push($employeeType, \App\Utils\EmploymentTypeStatus::PERMANENT);
                                            @endphp
                                        @endcan
                                    @endcan
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employment Type </label>
                                            <select name="employment_type_id" class="form-control" >
                                                <option value="">Select</option>
                                                @foreach ($employmentTypes as $item)
                                                    @if(in_array($item->id,$employeeType))
                                                        <option value="{{ $item->id }}" {{ (old('employment_type_id') == $item->id || Request::get('employment_type_id') == $item->id) ? 'selected' : '' }}>{{ $item->type }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employment Status </label>
                                            <select name="employee_status_id" class="form-control" >
                                                <option value="">Select</option>
                                                @foreach ($employeeStatus as $item)
                                                    <option value="{{ $item->id }}" {{ (old('employee_status_id') == $item->id || Request::get('employee_status_id') == $item->id) ? 'selected' : '' }}>{{ $item->status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="col-xl-2">

                                        <label for="employee_id">Employee</label>
                                        <select class="form-control kt-selectpicker" data-live-search="true" id="employee_id"
                                                name="employee_id" >
                                            <option value="">Select</option>
                                        </select>

                                    </div>


                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                                @if(sizeof($salary_history))
                                                    <a class="btn btn-primary " href="{{ Request::fullUrl() . "&csv=true" }}">Downlaod CSV</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            @if($salary_history)
                            <div class="alert alert-success">
                                <strong>{{ $salary_history->total() }} &nbsp;</strong> results found.
                            </div>
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered table-nowrap mb-0 " width="100%" id="lookup">
                                <thead>
                                    <th>Employee</th>
                                    <th>Month</th>
                                    <th>Emp Type</th>
                                    <th>Emp Status</th>
                                    <th>Gross</th>
                                    <th>Payable</th>
                                    <th>Hold</th>
                                    <th>
                                        Action
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($salary_history as $salary)
                                        @php
                                            if($salary->employee == null){
                                                $salary->employee = \App\Employee::withoutGlobalScopes()->find($salary->employee_id);
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $salary->employee->employer_id }} - {{ $salary->employee->FullName }}</td>
                                            <td>{{ \Carbon\Carbon::parse($salary->month)->format('M Y') }}</td>
                                            <td>{{ $salary->employee->employeeJourney->employmentType->type }}</td>
                                            <td>{{ $salary->employee->employeeJourney->employeeStatus->status }}</td>
                                            @if($flag == 1)
                                                <td>{{ $salary->gross_salary }}</td>
                                                <td>{{ $salary->payable_amount }}</td>
                                            @else
                                                <td>****</td>
                                                <td>****</td>
                                            @endif
                                            <td>{{ ($salary->is_hold) ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a title="Pay Slip" data-toggle="modal" data-target="#kt_modal" href="#" action="{{ route('paySlip.emp.view', ['id'=>$salary->id, 'type'=>$salary->employment_type_id]) }}" class="globalModal"><i class="flaticon2-document"  data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="Pay Slip"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $salary_history->appends(request()->query())->links() }}
                            </div>
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
    @include('layouts.partials.includes.division-center')

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

        addSelect2Ajax('#employee_id', "{{route('employee.all.by.type')}}");
    </script>

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
@endpush
