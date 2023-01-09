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
                                Process Salary Settings
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form hidden" action="{{ route('kpi.setting.index')  }}" method="GET">

                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" required
                                                       placeholder="Select Date"
                                                       id="kt_datepicker_3" name="date_from" value="{{ Request::get('date_from') }}"/>
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
                                                <input type="text" class="form-control" readonly
                                                       placeholder="Select Date"
                                                       id="kt_datepicker_3" name="date_to" value="{{ Request::get('date_to') }}"/>
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
                                                <input type="text" class="form-control"  placeholder="Employee ID" name="employee_id" value="{{ Request::get('employee_id') }}"/>
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
                                    <th>Division</th>
                                    <th>Center</th>
                                    <th>Department</th>
                                    <th>Process</th>
                                    <th>Process Segment</th>
                                    <th>Employment Type</th>
                                    <th>Salary Type</th>
                                    <th>Amount</th>
                                    <th>KPI Boundary</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($AllSettings as $singleSettings)
                                <tr>
                                    <td>{{ $singleSettings->division_id ?? '' }}</td>
                                    <td>{{ $singleSettings->center->center ?? '' }}</td>
                                    <td>{{ $singleSettings->department->name ?? '' }}</td>
                                    <td>{{ $singleSettings->process->name ?? '' }}</td>
                                    <td>{{ $singleSettings->processSegment->name ?? '' }}</td>
                                    <td>{{ $singleSettings->employmentType->type ?? '' }}</td>
                                    <td>{{ ($singleSettings->salary_type == 1)? "Hourly":"Fixed" }}</td>
                                    <td>{{ $singleSettings->amount }}</td>
                                    <td>{{ $singleSettings->kpi_boundary }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('process.payment.setting.edit', [$singleSettings->id]) }}" class="editor_edit"><i class="flaticon-edit"></i></a>
                                        | <a href="#" redirect="process.payment.setting.index" modelName="ProcessSalarySetting" id="{{ $singleSettings->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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


@endpush




