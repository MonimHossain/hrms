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
                                Appraisal Log
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="" method="GET">
                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Appraisal Year</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control year-pick" readonly required placeholder="" name="year"
                                                   value=""/>
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Employee</label>
                                        <div class="input-group">
                                            <select name="employee" id="" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">All</option>
                                               @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                @endforeach
                                            </select>
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
                                <table class="table table-striped custom-table mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Appraisal Year</th>
                                        <th>Employee Info</th>
                                        <th>Score</th>
{{--                                        <th>Grade</th>--}}
{{--                                        <th>Change Log</th>--}}
{{--                                        <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($appraisalList as $value)
                                    <tr>
                                        <td>{{ $value->parent->year }}</td>
                                        <td>
                                            <strong>Name:</strong>
                                            <a target="_blank" href="http://hrms.test/employee/profile/16">
                                                {{ $value->employee->FullName }}
                                            </a> <br>
{{--                                            <strong>EID:</strong> {{ $value->employee->employer_id }} <br>--}}
                                            <strong>Dept:</strong>Technology - Automation <br></td>
                                        <td>{{ $value->score ?? '' }}</td>
{{--                                        <td class="text-small">--}}
{{--                                            <p>Updated By - {{ $value->recommendBy->employer_id }}-{{ $value->recommendBy->FullName }}</p>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <a href="" class="btn btn-outline-primary">Edit</a>--}}
{{--                                        </td>--}}
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
{{--                                {{ $appraisalList->links() }}--}}
                            </div>
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
        // enable clear button
        $('.year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years'
        });

    </script>
@endpush




