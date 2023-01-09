@extends('layouts.container')

@push('css')
    <!--start:: google chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

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
                                            Employee Data Report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <div class="kt-section__content">
                                <form class="kt-form  center-division-form" action="{{ route('Admin.Report.employee-data')  }}" method="get">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Division</label>
                                                <div>
                                                    <select required class="form-control kt-select2 division" id="kt_select2_222" name="division">
                                                        <option value="">Select Option</option>
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}" {{ isset($filters['division']) && $filters['division'] == $division->id ? 'selected': '' }}>{{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Center</label>
                                                <div>
                                                    <select class="form-control kt-select2 center" id="kt_select2_222" name="center">
                                                        <option value="">Select Center</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2 department" id="kt_select2_22" name="department">
                                                        <option value="">Select Option</option>
{{--                                                        @foreach($departments as $department)--}}
{{--                                                            <option value="{{ $department->id }}" {{ isset($filters['department']) && $filters['department'] == $department->id ? 'selected': '' }}>{{ $department->name }}</option>--}}
{{--                                                        @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2 process" id="kt_select2_31" name="process">
                                                        <option value="">Select Option</option>
{{--                                                        @foreach($processes as $process)--}}
{{--                                                            <option value="{{ $process->id }}" {{ isset($filters['process']) && $filters['process'] == $process->id ? 'selected': '' }}>{{ $process->name }}</option>--}}
{{--                                                        @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process segment</label>
                                                <div>
                                                    <select class="form-control kt-select2 process-segment" id="kt_select2_62" name="process_segment">
                                                        <option value="">Select Option</option>
{{--                                                        @foreach($processSegments as $processSegment)--}}
{{--                                                            <option value="{{ $processSegment->id }}" {{ isset($filters['process_segment']) && $filters['process_segment'] == $processSegment->id ? 'selected': '' }}>{{ $processSegment->name }}</option>--}}
{{--                                                        @endforeach--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employment Type</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_32" name="employment_type">
                                                        <option value="">Select Option</option>
                                                        @foreach($employmentTypes as $employmentType)
                                                            <option value="{{ $employmentType->id }}" {{ isset($filters['employment_type']) && $filters['employment_type'] == $employmentType->id ? 'selected': '' }}>{{ $employmentType->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employee Status</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_38" name="employee_status">
                                                        <option value="">Select Option</option>
                                                        @foreach($employeeStatuses as $employeeStatus)
                                                            <option value="{{ $employeeStatus->id }}" {{ isset($filters['employee_status']) && $filters['employee_status'] == $employeeStatus->id ? 'selected': '' }}>{{ $employeeStatus->status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Employee ID</label>
                                                <div class="input-group">
                                                <select  class="form-control kt-selectpicker @error('employee_id') validated @enderror" data-live-search="true" id="employee_id" name="employee_id">
                                                    <option value="">Select</option>
                                                        @foreach ($all_employees as $employee)
                                                            <option {{ Request::get('employee_id') == $employee->id ? 'selected' : '' }} value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                                            </option>
                                                        @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-5">
                                            <div class="form-group">
                                                <label>Select Designations</label>
                                                <div class="input-group">
                                                <select class="form-control kt-select2" id="kt_select2_3" name="designations[]" multiple="" data-select2-id="kt_select2_3" tabindex="-1" aria-hidden="true">
                                                    @foreach ($designations as $designation)
                                                        <option value="{{ $designation->id }}" {{ Request::get('designations') != null && in_array($designation->id, Request::get('designations')) ? 'selected':'' }} >{{ $designation->name }}</option>
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
                                <div class="row">
                                    <div class="col-md-12 mb-30">
                                        <h5>Total result found: {{ $employees->total() }}</h5>
                                        <hr>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover table-checkable table-responsive" id="">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Center</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Process</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Joining Date</th>
                                            <th>Last Working Date</th>
                                            <th>Employment Type</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($employees as $employee)
                                            <tr>
                                                <td>{{ $employee->employer_id }}</td>
                                                <td>{{ $employee->FullName }}</td>
                                                <td>
                                                    @foreach($employee->divisionCenters as $item)
                                                        {{ $item->division->name .',  '.$item->center->center  ?? null }}@if(!$loop->last) <br> @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($employee->departmentProcess->unique('department_id') as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $employee->employeeJourney->designation->name ?? '' }}</td>
                                                <td>
                                                    @foreach($employee->departmentProcess->unique('process_id') as $item)
                                                        {{ $item->process->name ?? null }}
                                                        -
                                                        {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $employee->email ?? '' }}</td>
                                                <td>{{ $employee->pool_phone_number ?? '' }}</td>
                                                <td>{{ $employee->gender ?? '' }}</td>
                                                <td>{{ $employee->employeeJourney->doj  ?? '' }}</td>
                                                <td>{{ $employee->employeeJourney->lwd  ?? '' }}</td>
                                                <td>{{ $employee->employeeJourney->employmentType->type  ?? '' }}</td>
                                                <td class="text-center">
                                                    <a target="_blank" href="{{ route('employee.profile', $employee->id) }}"><i class="flaticon-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if(!$employees->count())
                                            <tr class="text-center">
                                                <td colspan="12">No data found</td>
                                            </tr>
                                        @endif
                                    </thead>
                                </table>
                                @if($employees->count())
                                    {{ $employees->appends(Request::all())->links() }}
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

@endpush

@push('js')
    @include('layouts.partials.includes.division-center')
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
            format: 'yyyy-mm-dd',
            // viewMode: 'months',
            // minViewMode: 'months'
        });

        $('.year-pick').datepicker({
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

    @endpush
