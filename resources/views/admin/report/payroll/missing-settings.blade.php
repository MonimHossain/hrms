@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                           Missing Salary Settings Report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('report.payroll.all.missing.salary.settings')  }}" method="get">

                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Emoloyment Type</label>
                                            <div class="input-group date">
                                                <select name="employment_type" class="form-control" id="">
                                                    <option value="">All</option>
                                                    @foreach ($employment_types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-tags"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Select Employee:</label>
                                        <select id="employee_id" name="employee_id"
                                                class="form-control kt-selectpicker " data-live-search="true"
                                                data-placeholder="Select Employee">
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                                @if($emoloyee_list->count())
                                                    <a class="btn btn-primary " href="{{ Request::fullUrl() . "&csv=true" }}">Downlaod CSV</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="kt-section__content">
                                @if($emoloyee_list->count())
                                <table class="table table-striped table-bordered table-responsive" id="">
                                    <thead>
                                        <tr>
                                            <th style="min-width:50px">Employee ID</th>
                                            <th style="min-width:50px">Name</th>
                                            <th style="min-width:150px">Center</th>
                                            <th style="min-width:50px">Department</th>
                                            <th style="min-width:50px">Designation</th>
                                            <th style="min-width:50px">Process</th>
                                            <th style="min-width:50px">Email</th>
                                            <th style="min-width:50px">Phone</th>
                                            <th style="min-width:50px">Gender</th>
                                            <th style="min-width:50px">Joining Date</th>
                                            <th style="min-width:50px">Last Working Date</th>
                                            <th style="min-width:50px">Employment Type</th>
                                            <th style="min-width:50px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($emoloyee_list as $employee)
                                        <tr>
                                            <td style="min-width:50px">{{ $employee->employer_id }}</td>
                                            <td style="min-width:50px">{{ $employee->FullName }}</td>
                                            <td style="min-width:150px">
                                                @foreach($employee->divisionCenters as $item)
                                                    {{ $item->division->name .',  '.$item->center->center  ?? null }}@if(!$loop->last) <br> @endif
                                                @endforeach
                                            </td>
                                            <td style="min-width:50px">
                                                @foreach($employee->departmentProcess->unique('department_id') as $item)
                                                    {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                @endforeach
                                            </td>
                                            <td style="min-width:50px">{{ $employee->employeeJourney->designation->name ?? '' }}</td>
                                            <td style="min-width:50px">
                                                @foreach($employee->departmentProcess->unique('process_id') as $item)
                                                    {{ $item->process->name ?? null }}
                                                    -
                                                    {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                                @endforeach
                                            </td>
                                            <td style="min-width:50px">{{ $employee->email ?? '' }}</td>
                                            <td style="min-width:50px">{{ $employee->pool_phone_number ?? '' }}</td>
                                            <td style="min-width:50px">{{ $employee->gender ?? '' }}</td>
                                            <td style="min-width:50px">{{ $employee->employeeJourney->doj  ?? '' }}</td>
                                            <td style="min-width:50px">{{ $employee->employeeJourney->lwd  ?? '' }}</td>
                                            <td style="min-width:50px">{{ $employee->employeeJourney->employmentType->type  ?? '' }}</td>
                                            <td style="min-width:150px">
                                            @can(_permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW))
                                                <a href="{{ route('manage.salary.view') }}" class="btn btn-sm btn-primary">Move to Settings</a>
                                            @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $emoloyee_list->appends(request()->query())->links() }}
                                @else
                                    <p>No data found!</p>
                                @endif
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

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
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
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
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
        $("#kt_select2_3, #kt_select2_3_validate").select2({placeholder:"Select fields"})
    </script>
    <script>
        $(document).ready(function() {
            $('#exportTable').DataTable( {
                dom: 'Bftiprl',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "columnDefs": [
                    {"className": "dt-left", "targets": "_all"}
                ],
                "searching": false
            } );
        } );
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
    @endpush
