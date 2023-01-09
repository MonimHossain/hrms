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

                            @if($salary_history)
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered table-nowrap mb-0 " width="100%" id="lookup">
                                <thead>
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
                                        @if($salary->employee)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($salary->month)->format('M Y') }}</td>
                                                <td>{{ $salary->employee ? $salary->employee->employeeJourney->employmentType->type : '' }}</td>
                                                <td>{{ $salary->employee->employeeJourney->employeeStatus->status }}</td>
                                                <td>{{ $salary->gross_salary }}</td>
                                                <td>{{ $salary->payable_amount }}</td>
                                                <td>{{ ($salary->is_hold) ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a title="Pay Slip" data-toggle="modal" data-target="#kt_modal" href="#" action="{{ route('paySlip.employee.view', ['id'=>$salary->id, 'type'=>$salary->employment_type_id]) }}" class="globalModal"><i class="flaticon2-document"  data-skin="dark" data-toggle="kt-tooltip" data-placement="top" title="Pay Slip"></i></a>
                                                </td>
                                            </tr>
                                        @endif
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

        addSelect2Ajax('#employee_id', "{{route('employee.all')}}");
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
