@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">

                <form class="kt-form center-division-form" action="" method="get">
                {{-- @csrf --}}
                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <h3 style="float: left;" class="kt-portlet__head-title">
                                                Generate Salary
                                            </h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group center-division-item">
                                    <label>Division</label>
                                    <select id="division" name="division_id" class="form-control division" required>
                                        <option value="">Select Division <span class="text-danger">*</span></option>
                                        @foreach ($divisions as $item)
                                            <option value="{{ $item->id }}" {{ (old('division_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3">
                                <div class="form-group center-division-item">
                                    <label>center</label>
                                    <select id="center" name="center_id" class="form-control center" required>
                                        <option value="">Select Center <span class="text-danger">*</span></option>
{{--                                                    @foreach ($centers as $item)--}}
{{--                                                        <option value="{{ $item->id }}" {{ (old('center_id') == $item->id) ? 'selected' : '' }}>{{ $item->center }}</option>--}}
{{--                                                    @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
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
                            <div class="col-xl-3">
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
                                        array_push($employeeType, \App\Utils\EmploymentTypeStatus::PROBATION);
                                        array_push($employeeType, \App\Utils\EmploymentTypeStatus::PERMANENT);
                                    @endphp
                                @endcan
                            @endcan

                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Employment Type </label>
                                    <select name="employment_type_id" class="form-control"  required>
                                        <option value="">Select</option>
                                        @foreach ($employmentTypes as $item)
                                            @if(in_array($item->id,$employeeType))
                                                <option value="{{ $item->id }}" {{ (old('employment_type_id') == $item->id) ? 'selected' : '' }}>{{ $item->type }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Is Deductible? (PF,Tax,Loan ....)</label>
                                    <select name="is_deductable" class="form-control"  required>
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                        <button type="submit" class="btn btn-primary">Generate</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>



                        {{-- <div class="kt-portlet__body">
                            <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Salary Cycle:</label>
                                    <div>
                                        <div class='input-group' id='kt_daterangepicker'>
                                            <input type='text' class="form-control" readonly placeholder="Select date range"  name="salary_cycle" value="{{ old('salary_cycle') }}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Employment Type </label>
                                    <select name="employment_type_id" class="form-control"  required>
                                        <option value="">Select</option>
                                        @foreach ($employmentTypes as $item)
                                        <option value="{{ $item->id }}" {{ (old('employment_type_id') == $item->id) ? 'selected' : '' }}>{{ $item->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Is diductable? (PF,Tax,Loan ....)</label>
                                    <select name="is_deductable" class="form-control"  required>
                                        <option value="">Select</option>
                                        <option value="1">With Diduction</option>
                                        <option value="0">Without Diduction</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                        <button type="submit" class="btn btn-primary">Generate</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div> --}}


                    </div>
                </form>



                @if($generate_salary)
                <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('roster.save') }}">
                    @csrf

                    {{-- Salary --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <h3 style="float: left;" class="kt-portlet__head-title">
                                                        Generate Salary: {{ date('M, Y') }} {{-- TODO generated date month not current --}}
                                                    </h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="kt-portlet__body">
                                    @foreach($dependent_modules as $module)
                                    <div class="form-group">
                                        <div class="form-check">
                                            @if($module['status'])
                                                <i class="fa fa-check text-success pad-r-15"></i>
                                            @else
                                                <i class="fa fa-times text-danger pad-r-18"></i>
                                            @endif
                                            <label class="form-check-label" for="loanCheck">{{ $module['title'] }} of {{ date('M, Y') }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="form-group">
                                        <div class="form-check">
                                            @if($releasePreviousHold['status'])
                                                <i class="fa fa-check text-success pad-r-15"></i>
                                            @else
                                                <i class="fa fa-times text-danger pad-r-18"></i>
                                            @endif
                                            <label class="form-check-label" for="loanCheck">{{ $releasePreviousHold['title'] }} of {{ Carbon\Carbon::parse('1-'.$releasePreviousHold['month'].'-'.$releasePreviousHold['year'])->format('M Y') }}</label>
                                            &nbsp;&nbsp;&nbsp;
                                            @if($releasePreviousHold['button'])
                                                <a href="{{ route('salary.release.previous.hold.list', ['month'=> $month, 'year'=>$year]) }}" class="btn-sm btn-success">View List</a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 mar-top-15">
                                            {{-- <a class="btn btn-primary {{ $is_valid ? '':'disabled' }}" href="{{ route('generate.salary') }}">Generate Salary</a> --}}
                                            <a class="btn btn-primary {{ $is_valid ? '':'' }}" href="{{ route('generate.salary').'?'.Request::getQueryString() }}">Generate Salary</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Portlet-->
                    </div>
                    <!--end::Portlet-->
                </form>
                <!--end::Form-->
                @endif
            </div>
        </div>
    </div>
@endsection


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="/assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>

@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    @include('layouts.partials.includes.division-center')

    <script>
        $(document).ready(function(){
            $('.validationCheck').on('change', function(){
                if($(this).is(":checked")){
                    let id = $(this).attr('id');
                    let url = '{{ route('salary.validation', ['']) }}';
                    $.ajax({url: url + '/' + id, success: function(result){
                        alert(result);
                    }});
                }
            })
        })
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

    </script>


    <script>
        $("#kt_daterangepicker").daterangepicker({
            buttonClasses: " btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary",
            // timePicker: !0,
            // timePickerIncrement: 30,
            // locale: {
            //     format: "YYYY-MM-DD"
            // }
        }, function(a, t, e) {
            $("#kt_daterangepicker .form-control").val(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"))
        });
    </script>

@endpush
