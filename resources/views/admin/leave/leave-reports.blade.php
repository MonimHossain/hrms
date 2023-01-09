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
                                Requested Leave
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form" action="{{ route('leave.request') }}" method="get">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group date">
                                                <select id="team_lead_id" name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{$employee->id}}" data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" readonly placeholder="Select Start Date"
                                                       id="kt_datepicker_3" name="date_from" value="" />
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
                                                <input type="text" class="form-control" readonly placeholder="Select End Date"
                                                       id="kt_datepicker_3" name="date_to" value="" />
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
                                            <label>Department</label>
                                            <div class="input-group date">
                                                <select id="team_lead_id" name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{$department->id}}" data-tokens="{{ $department->name }}">{{ $department->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Process</label>
                                            <div class="input-group date">
                                                <select id="team_lead_id" name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach ($processes as $process)
                                                        <option value="{{$process->id}}" data-tokens="{{ $process->name }}">{{ $process->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions" >
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable">
                                    <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Quantity</th>
                                        <th>Leave Type</th>
                                        <th>Leave Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            12154
                                        </td>
                                        <td>
                                            Md. Khayrul Hsan
                                        </td>
                                        <td>
                                            leave
                                        </td>
                                        <td>
                                            This is description
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            .5
                                        </td>
                                        <td>
                                            Sick
                                        </td>
                                        <td class="text-bold text-center">
                                            <a href="javascript:void(0);" class="text-success" >Pending</a>
                                        </td>
                                    </tr><tr>
                                        <td>
                                            12154
                                        </td>
                                        <td>
                                            Md. Khayrul Hsan
                                        </td>
                                        <td>
                                            leave
                                        </td>
                                        <td>
                                            This is description
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            .5
                                        </td>
                                        <td>
                                            Sick
                                        </td>
                                        <td class="text-bold text-center">
                                            <a href="javascript:void(0);" class="text-success" >Pending</a>
                                        </td>
                                    </tr><tr>
                                        <td>
                                            12154
                                        </td>
                                        <td>
                                            Md. Khayrul Hsan
                                        </td>
                                        <td>
                                            leave
                                        </td>
                                        <td>
                                            This is description
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            .5
                                        </td>
                                        <td>
                                            Sick
                                        </td>
                                        <td class="text-bold text-center">
                                            <a href="javascript:void(0);" class="text-success" >Pending</a>
                                        </td>
                                    </tr><tr>
                                        <td>
                                            12154
                                        </td>
                                        <td>
                                            Md. Khayrul Hsan
                                        </td>
                                        <td>
                                            leave
                                        </td>
                                        <td>
                                            This is description
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            12/08/2019
                                        </td>
                                        <td>
                                            .5
                                        </td>
                                        <td>
                                            Sick
                                        </td>
                                        <td class="text-bold text-center">
                                            <a href="javascript:void(0);" class="text-success" >Pending</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

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
