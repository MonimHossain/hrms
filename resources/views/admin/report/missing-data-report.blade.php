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
                                            Missing data fields report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('Admin.Report.missing-data')  }}" method="get">

                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            {{-- <label>Employee ID</label> --}}
                                            <div class="input-group">
                                            <select  class="form-control kt-selectpicker @error('employee_id') validated @enderror" data-live-search="true" id="employee_id" name="employee_id">
                                                <option value="">Select Employee</option>
                                                    @foreach ($all_employees as $employee)
                                                        <option {{ Request::get('employee_id') == $employee->id  ? 'selected' : '' }} value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-1">
                                        <div class="form-group">
                                            {{-- <label>&nbsp;</label> --}}
                                            <div class="kt-form__actions">
                                                <p class="orBreak">Or</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            {{-- <label>Select Fields</label> --}}
                                            <div class="input-group">

                                            <select class="form-control kt-select2" id="kt_select2_3" name="fields[]" multiple="" data-select2-id="kt_select2_3" tabindex="-1" aria-hidden="true">
                                                <option value="doj" {{ Request::get('fields') != null && in_array('doj', Request::get('fields')) ? 'selected':'' }} >DOJ</option>
                                                <option value="religion" {{ Request::get('fields') != null && in_array('religion', Request::get('fields')) ? 'selected':'' }}>Religion</option>
                                                <option value="location" {{ Request::get('fields') != null && in_array('location', Request::get('fields')) ? 'selected':'' }} >Location</option>
                                                <option value="designation" {{ Request::get('fields') != null && in_array('designation', Request::get('fields')) ? 'selected':'' }} >Designation</option>
                                                <option value="personal_email" {{ Request::get('fields') != null && in_array('personal_email', Request::get('fields')) ? 'selected':'' }} >Personal Email</option>
                                                <option value="company_email" {{ Request::get('fields') != null && in_array('company_email', Request::get('fields')) ? 'selected':'' }} >Company Email</option>
                                                <option value="pool_phone" {{ Request::get('fields') != null && in_array('pool_phone', Request::get('fields')) ? 'selected':'' }} >Pool Phone</option>
                                                <option value="personal_phone" {{ Request::get('fields') != null && in_array('personal_phone', Request::get('fields')) ? 'selected':'' }} >Personal Phone</option>
                                                <option value="dob" {{ Request::get('fields') != null && in_array('dob', Request::get('fields')) ? 'selected':'' }} >Date of Birth</option>
                                                <option value="emergency_contact" {{ Request::get('fields') != null && in_array('emergency_contact', Request::get('fields')) ? 'selected':'' }} > Emargency Contact </option>
                                                <option value="bood_group" {{ Request::get('fields') != null && in_array('bood_group', Request::get('fields')) ? 'selected':'' }}>Blood Group</option>

                                                <option value="contractual_start_date" {{ Request::get('fields') != null && in_array('contractual_start_date', Request::get('fields')) ? 'selected':'' }}>Contractual Start Date</option>
                                                <option value="contractual_end_date" {{ Request::get('fields') != null && in_array('contractual_end_date', Request::get('fields')) ? 'selected':'' }}>Contractual End Date</option>
                                                <option value="probation_start_date" {{ Request::get('fields') != null && in_array('probation_start_date', Request::get('fields')) ? 'selected':'' }}>Probation Start Date</option>
                                                <option value="probation_period" {{ Request::get('fields') != null && in_array('probation_period', Request::get('fields')) ? 'selected':'' }}>Probation Period</option>
                                                <option value="permanent_doj" {{ Request::get('fields') != null && in_array('permanent_doj', Request::get('fields')) ? 'selected':'' }}>Confirmation Date</option>
                                                <option value="new_role_doj" {{ Request::get('fields') != null && in_array('new_role_doj', Request::get('fields')) ? 'selected':'' }}>New Role DOJ</option>
                                                <option value="job_role_id" {{ Request::get('fields') != null && in_array('job_role_id', Request::get('fields')) ? 'selected':'' }}>Job Role</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
{{--                                            <label>Employee ID</label>--}}
                                            <div class="input-group">
                                                <select  class="form-control @error('employment_type') validated @enderror" data-live-search="true" id="employment_type" name="employment_type">
                                                    <option value="">Select Employee Type</option>
                                                    <option {{ Request::get('employment_type') == \App\Utils\EmploymentTypeStatus::HOURLY  ? 'selected' : '' }} value="{{\App\Utils\EmploymentTypeStatus::HOURLY}}">Hourly</option>
                                                    <option {{ Request::get('employment_type') == \App\Utils\EmploymentTypeStatus::CONTRACTUAL  ? 'selected' : '' }} value="{{\App\Utils\EmploymentTypeStatus::CONTRACTUAL}}">Contractual</option>
                                                    <option {{ Request::get('employment_type') == \App\Utils\EmploymentTypeStatus::PROBATION  ? 'selected' : '' }} value="{{\App\Utils\EmploymentTypeStatus::PROBATION}}">Probation</option>
                                                    <option {{ Request::get('employment_type') == \App\Utils\EmploymentTypeStatus::PERMANENT  ? 'selected' : '' }} value="{{\App\Utils\EmploymentTypeStatus::PERMANENT}}">Permanent</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
{{--                                            <label>Employee Role</label>--}}
                                            <div class="input-group">
                                                <select  class="form-control @error('employee_role') validated @enderror" data-live-search="true" id="employee_role" name="employee_role">
                                                    <option value="">Select Employee Role</option>
                                                    @foreach($jobRoles as $role)
                                                    <option {{ Request::get('employee_role') == $role->id  ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 hidden">
                                        <div class="form-group">
                                            <label>Condition</label>
                                            <div class="input-group">
                                                <select name="condition" class="form-control" id="">
                                                    <option {{ Request::get('condition') == 'or' ? 'selected':'' }} value="or">any field</option>
                                                    <option {{ Request::get('condition') == 'and' ? 'selected':'' }} value="and">all fields</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            {{-- <label>&nbsp;</label> --}}
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="kt-section__content">
                                @if($employeeData)
                                    <div class="col-md-12">
                                        <h5>
                                            Total Employee Found: {{ $employeeData->total() }}
                                        </h5>
                                        <hr>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <th>
                                                Employee Info
                                            </th>
                                            <th>
                                                Missing Fields
                                            </th>
                                        </thead>
                                        @foreach($employeeData as $employee)
                                            <tr>
                                                <td>
                                                    Name: <a target="_blank" href="{{ route('employee.profile', [$employee->id]) }}">{{ $employee->fullName }}</a> <br>
                                                    EID: {{ $employee->employer_id }}
                                                </td>
                                                <td>
                                                    <?php
                                                        $missing_fields = [];
                                                        if(Request::get('fields') != null && in_array('doj', Request::get('fields'))){
                                                            array_push($missing_fields, 'DOJ');
                                                        }
                                                        if(Request::get('fields') != null && in_array('religion', Request::get('fields'))){
                                                            array_push($missing_fields, 'Religion');
                                                        }
                                                        if(Request::get('fields') != null && in_array('location', Request::get('fields'))){
                                                            array_push($missing_fields, 'Nearby Location');
                                                        }
                                                        if(Request::get('fields') != null && in_array('designation', Request::get('fields'))){
                                                            array_push($missing_fields, 'Designaation');
                                                        }
                                                        if(Request::get('fields') != null && in_array('personal_email', Request::get('fields'))){
                                                            array_push($missing_fields, 'Personal Email');
                                                        }
                                                        if(Request::get('fields') != null && in_array('company_email', Request::get('fields'))){
                                                            array_push($missing_fields, 'Company Email');
                                                        }
                                                        if(Request::get('fields') != null && in_array('pool_phone', Request::get('fields'))){
                                                            array_push($missing_fields, 'Pool Phone');
                                                        }
                                                        if(Request::get('fields') != null && in_array('personal_phone', Request::get('fields'))){
                                                            array_push($missing_fields, 'Personal Phone');
                                                        }
                                                        if(Request::get('fields') != null && in_array('dob', Request::get('fields'))){
                                                            array_push($missing_fields, 'DOB');
                                                        }
                                                        if(Request::get('fields') != null && in_array('emergency_contact', Request::get('fields'))){
                                                            array_push($missing_fields, 'Emargency Contact');
                                                        }
                                                        if(Request::get('fields') != null && in_array('bood_group', Request::get('fields'))                                                ){
                                                            array_push($missing_fields, 'Blood Group');
                                                        }
                                                    ?>
                                                    {{ implode(', ', $missing_fields)  }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    {{ $employeeData->appends(Request::all())->links() }}

                                @elseif($employee)
                                    <table class="table table-hover table-striped" width="50%">
                                        <tr>
                                            <th>Fields</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($required_fields as $field)
                                            <tr>
                                                <td class="{{ in_array($field, $missing) ? 'text-danger':'' }}">
                                                    {{ $field }}
                                                </td>
                                                <td>
                                                    @if(in_array($field, $missing))
                                                        <i class="fa fa-times text-danger"></i>
                                                    @else
                                                        <i class="fa fa-check  text-success"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
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
