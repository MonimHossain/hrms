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
                                KPI List
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('kpi.setting.index')  }}" method="GET">

                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input required="required" type="text" class="form-control" readonly placeholder="Select Month"
                                                       id="month-pick" name="month" value="{{ Request::get('month') }}" />
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
                                                <input required="required" type="text" class="form-control" readonly placeholder="Select Year"
                                                       id="year-pick" name="year" value="{{ Request::get('year') }}" />
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
                                            <div class="input-group">
                                            <select class="form-control kt-selectpicker" data-live-search="true" id="employee_id"
                                                name="employee_id" >
                                                <option value="">Select</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5">
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
                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Date</th>
                                    <th>Grade</th>
                                    <th>Amount</th>
                                    <th>Reward and Recognition</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($kpis as $kpi)
                                <tr>
                                    <td>{{ $kpi->employer_id ?? 0 }}</td>
                                    <td>{{ date('m/Y', strtotime($kpi->monthly_date)) }}</td>
                                    <td>{{ $kpi->grade }}</td>
                                    <td>{{ $kpi->amount }}</td>
                                    <td>{{ ($kpi->r_and_r == 2) ? 'NO':'YES' }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('kpi.setting.edit', [$kpi->id]) }}" class="editor_edit"><i class="flaticon-edit"></i></a>
                                        |
                                        <a href="#" redirect="kpi.setting.index" modelName="Kpi" id="{{ $kpi->id }}" class="lookup_remove" ><i class="flaticon-delete"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
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

    <style>
        .inner-table{
            border-collapse: collapse; border-spacing: 0px; text-align:center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width:.5px;
            border-style:solid;
        }
        .inner-table th {
            border: 1px solid #0abb87;
        }

        .inner-table td {
            border: 1px solid #0abb87;
        }
    </style>

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
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


        // Date
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




