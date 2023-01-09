@extends('layouts.container')

@section('content')
<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="step-first">
                <div class="kt-grid__item">

                    <!--begin: Form Wizard Nav -->
                    <div class="kt-wizard-v1__nav">
                        <div class="kt-wizard-v1__nav-items">
                            <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <i class="flaticon-user-ok"></i>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        Personal Info
                                    </div>
                                </div>
                            </a>
                            <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <i class="flaticon-user-settings"></i>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        Academic & Training
                                    </div>
                                </div>
                            </a>
                            <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <i class="flaticon-profile-1"></i>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        Employment Info
                                    </div>
                                </div>
                            </a>
                            <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <i class="flaticon-support"></i>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        Contact Info
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    <!--end: Form Wizard Nav -->
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                    <!--begin: Form Wizard Form-->
                    <form class="kt-form kt-form--fit center-division-form" id="kt_form" action="{{ route('employee.update.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                            <div class="kt-form__section kt-form__section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Employee ID</label>
                                                <input type="text" class="form-control" autocomplete="off" id="employer_id" name="employer_id" placeholder="Employee ID" value="{{ (old('employer_id')) ? old('employer_id') : $employee->employer_id }}"  required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Login ID</label>
                                                <input type="text" class="form-control" name="login_id" placeholder="Login ID" value="{{ (old('login_id')) ? old('login_id') : $employee->login_id }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ (old('first_name')) ? old('first_name') : $employee->first_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ (old('last_name')) ? old('last_name') : $employee->last_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Official Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $employee->email }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Personal Email</label>
                                                <input type="email" class="form-control" name="personal_email" placeholder="Personal Email" value="{{ $employee->personal_email }}">
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Center</label>
                                                <select name="center" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Dhaka">Dhaka</option>
                                                    <option value="Chittagong">Chittagong</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select name="gender" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <option {{ ($employee->gender == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                                    <option {{ ($employee->gender == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="date_of_birth" value="{{ $employee->date_of_birth }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <select name="religion" class="form-control">
                                                    <option value="">Select</option>
                                                    <option {{ ($employee->religion == 'Islam') ? 'selected' : '' }} value="Islam">Islam</option>
                                                    <option {{ ($employee->religion == 'Hinduism') ? 'selected' : '' }} value="Hinduism">Hinduism</option>
                                                    <option {{ ($employee->religion == 'Christian') ? 'selected' : ''}} value="Christian" >Christian</option>
                                                    <option {{ ($employee->religion == 'Buddhist') ? 'selected' : '' }} value="Buddhist">Buddhist</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>SSC Reg. No.</label>
                                                <input type="text" class="form-control" name="ssc_reg_num" placeholder="SSC REG. No." value="{{ $employee->ssc_reg_num }}">
                                            </div>
                                        </div>

{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>center</label>--}}
{{--                                                <select name="center_id" class="form-control" required>--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($centers as $item)--}}
{{--                                                        <option value="{{ $item->id }}" {{ ($employee->center_id == $item->id) ? 'selected' : '' }}>{{ $item->center }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="col-xl-12">
                                            <div class="form-group">
                                            <label>Nearby Location</label>
                                            <select class="form-control" id="kt_multipleselectsplitter_1" name="nearby_location_id">
                                                <optgroup label="Select">
                                                    <option value="">Select</option>
                                                </optgroup>
                                                @foreach ($locations as $center=>$locationNearby)
                                                <optgroup label="{{ \App\Center::whereId($center)->first()->division->name }} - {{ \App\Center::whereId($center)->first()->center }}" class="testing">
                                                    @foreach ($locationNearby as $nearby)
                                                    <option {{ ($employee->nearby_location_id == $nearby->id) ? 'selected' : '' }} value="{{ $nearby->id }}">{{ $nearby->nearby }}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>


                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Marital Status</label>
                                                <select name="marital_status" class="form-control">
                                                    <option value="">Select</option>
                                                    <option {{ ($employee->marital_status == 'Married') ? 'selected' : '' }} value="Married">Married</option>
                                                    <option {{ ($employee->marital_status == 'Unmarried') ? 'selected' : '' }} value="Unmarried">Unmarried</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>NID</label>
                                                <input type="text" class="form-control" name="nid" placeholder="NID" value="{{ $employee->nid }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Passport</label>
                                                <input type="text" class="form-control" name="passport" placeholder="passport" value="{{ $employee->passport }}">
                                            </div>
                                        </div>


                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <select name="blood_group_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($bloodGroups as $item)
                                                    <option {{ (($employee->bloodGroup) && ($employee->bloodGroup->name == $item->name)) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


{{--                                        <div class="col-xl-12">--}}
{{--                                            <hr class="bg-info">--}}
{{--                                        </div>--}}


{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Bank Name</label>--}}
{{--                                                <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="{{ $employee->bank_name }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Branch Name</label>--}}
{{--                                                <input type="text" class="form-control" name="bank_branch" placeholder="Branch Name" value="{{ $employee->bank_branch }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Bank Account</label>--}}
{{--                                                <input type="text" class="form-control" name="bank_account" placeholder="Bank Account" value="{{ $employee->bank_account }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Bank Routing</label>--}}
{{--                                                <input type="text" class="form-control" name="bank_routing" placeholder="Bank Account" value="{{ $employee->bank_routing }}">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}



                                        <div class="col-xl-12">
                                        <hr class="bg-info">
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Father's Name</label>
                                                <input type="text" class="form-control" name="father_name" placeholder="Father Name" value="{{ $employee->father_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Mother's Name</label>
                                                <input type="text" class="form-control" name="mother_name" placeholder="Mother Name" value="{{ $employee->mother_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Spouse Name</label>
                                                <input type="text" class="form-control" name="spouse_name" placeholder="Spouse Name" value="{{ $employee->spouse_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Spouse DOB</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="spouse_dob" value="{{ $employee->spouse_dob }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child Name 1</label>
                                                <input type="text" class="form-control" name="child1_name" placeholder="Child Name 1" value="{{ $employee->child1_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child DOB 1</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="child1_dob" value="{{ $employee->child1_dob }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child Name 2</label>
                                                <input type="text" class="form-control" name="child2_name" placeholder="Child Name 2" value="{{ $employee->child2_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child DOB 2</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="child2_dob" value="{{ $employee->child2_dob }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child Name 3</label>
                                                <input type="text" class="form-control" name="child3_name" placeholder="Child Name 3" value="{{ $employee->child3_name }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Child DOB 3</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="child3_dob" value="{{ $employee->child3_dob }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-form__section kt-form__section--first">
                                <div class="kt-wizard-v1__form">
                                    <div id="kt_repeater_1">
                                        <div class="form-group form-group-last row" id="kt_repeater_1">
                                            <label class="col-lg-2 col-form-label"><b>Academic</b></label>

                                            <div data-repeater-list="academic" class="col-lg-12">
                                                @forelse ($employee->educations as $key => $educations)
                                                <div data-repeater-item class="form-group row align-items-center">
                                                    {{-- {{ ($employee->educations->levelOfEducation->id == $item->name) ? 'selected' : '' }} --}}


                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Level of Education:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <select name="academic[{{ $key }}][level_of_education_id]" class="form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($educationLevels as $item)
                                                                    <option {{ ($educations->levelOfEducation && $educations->levelOfEducation->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Exam Degree Title:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Exam Degree Title" name="academic[{{ $key }}][exam_degree_title]" value="{{ $educations->exam_degree_title }}">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Major/Department/Faculty:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Major/Department/Faculty" name="academic[{{ $key }}][major]" value="{{ $educations->major }}">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
{{--                                                    <div class="col-md-3">--}}
{{--                                                        <div class="kt-form__group--inline">--}}
{{--                                                            <div class="kt-form__label">--}}
{{--                                                                <label>Institute Name:</label>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="kt-form__control">--}}
{{--                                                                <select name="academic[{{ $key }}][institute_id]" class="form-control">--}}
{{--                                                                    <option value="">Select</option>--}}
{{--                                                                    @foreach ($institutes as $item)--}}
{{--                                                                    <option {{ ($educations->institute && $educations->institute->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="d-md-none kt-margin-b-10"></div>--}}
{{--                                                    </div>--}}
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Institute Name:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <div class="typeahead">
                                                                    <input class="form-control kt_typeahead_1" id="" type="text" dir="ltr" placeholder="Institute Name" name="institute"  value="{{ ($educations->institute) ? $educations->institute : '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>CGPA/Division/Class:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="CGPA/Division/Class" name="academic[{{ $key }}][result]" value="{{ $educations->result }}">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Passing Year:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Ex: 2017" name="academic[{{ $key }}][passing_year]" value="{{ $educations->passing_year }}">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                            <i class="la la-trash-o"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                                @empty
                                                <div data-repeater-item class="form-group row align-items-center">

                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Level of Education:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <select name="level_of_education_id" class="form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($educationLevels as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Exam Degree Title:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Exam Degree Title" name="exam_degree_title">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Major/Department/Faculty:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Major/Department/Faculty" name="major">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Institute Name:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <select name="institute_id" class="form-control">
                                                                    <option value="">Select</option>
                                                                    @foreach ($institutes as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>CGPA/Division/Class:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="CGPA/Division/Class" name="result">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="kt-form__group--inline">
                                                            <div class="kt-form__label">
                                                                <label>Passing Year:</label>
                                                            </div>
                                                            <div class="kt-form__control">
                                                                <input type="text" class="form-control" placeholder="Ex: 2017" name="passing_year">
                                                            </div>
                                                        </div>
                                                        <div class="d-md-none kt-margin-b-10"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                            <i class="la la-trash-o"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                                @endforelse
                                            </div>


                                        </div>
                                        <div class="form-group form-group-last row">
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                                    <i class="la la-plus"></i> Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <hr class="bg-info">
                                    </div>



                                    <div id="kt_repeater_2">
                                            <div class="form-group form-group-last row" id="kt_repeater_2">
                                                <label class="col-lg-2 col-form-label"><b>Traning</b>:</label>

                                                <div data-repeater-list="training" class="col-lg-12">
                                                    @forelse ($employee->trainings as $key => $trainings)
                                                    <div data-repeater-item class="form-group row align-items-center">


                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Title:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Title" name="training[{{ $key }}][training_title]" value="{{ $trainings->training_title }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Country:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Country" name="training[{{ $key }}][country]" value="{{ $trainings->country }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Topics Covered:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: PHP, Javascript" name="training[{{ $key }}][topics_covered]" value="{{ $trainings->topics_covered }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Institute:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Institute" name="training[{{ $key }}][institute]" value="{{ $trainings->institute }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Traning Year:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: 2017" name="training[{{ $key }}][training_year]" value="{{ $trainings->training_year }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Duration:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: 6 Months" name="training[{{ $key }}][duration]" value="{{ $trainings->duration }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Location:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Location" name="training[{{ $key }}][location]" value="{{ $trainings->location }}">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                                <i class="la la-trash-o"></i>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div data-repeater-item class="form-group row align-items-center">


                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Title:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Title" name="training_title">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Country:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Country" name="country">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Topics Covered:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: PHP, Javascript" name="topics_covered">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Institute:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Institute" name="institute">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Traning Year:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: 2017" name="training_year">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Duration:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Ex: 6 Months" name="duration">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="kt-form__group--inline">
                                                                <div class="kt-form__label">
                                                                    <label>Location:</label>
                                                                </div>
                                                                <div class="kt-form__control">
                                                                    <input type="text" class="form-control" placeholder="Location" name="location">
                                                                </div>
                                                            </div>
                                                            <div class="d-md-none kt-margin-b-10"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold">
                                                                <i class="la la-trash-o"></i>
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="form-group form-group-last row">
                                                <div class="col-lg-4">
                                                    <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                                        <i class="la la-plus"></i> Add
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 2-->

                        <!--begin: Form Wizard Step 3-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-form__section kt-form__section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">

{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Process</label>--}}
{{--                                                <select name="process_id" class="form-control">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($processes as $item)--}}
{{--                                                    <option  {{ ($employeeJourney->process->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}


{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Process Segment</label>--}}
{{--                                                <select name="process_segment_id" class="form-control">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Process Joining Date</label>--}}
{{--                                                <div class="input-group date">--}}
{{--                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="process_doj" value="{{ $employeeJourney->process_doj }}"/>--}}
{{--                                                    <div class="input-group-append">--}}
{{--                                                        <span class="input-group-text">--}}
{{--                                                            <i class="la la-calendar-check-o"></i>--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Process Last Working Day</label>--}}
{{--                                                <div class="input-group date">--}}
{{--                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="process_lwd"  value="{{ $employeeJourney->process_lwd }}"/>--}}
{{--                                                    <div class="input-group-append">--}}
{{--                                                        <span class="input-group-text">--}}
{{--                                                            <i class="la la-calendar-check-o"></i>--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-xl-12">--}}
{{--                                            <hr class="bg-info">--}}
{{--                                        </div>--}}



                                        <div class="col-xl-6 center-division-item">
                                            <div class="form-group ">
                                                <label>Division</label>
                                                <select id="division" name="division_id" class="form-control division" required>
                                                    <option value="">Select Division</option>
                                                    @foreach ($divisions as $item)
                                                        {{-- <option {{ (($employee->divisionCenters()->where('is_main', 1)->count()) && $employee->divisionCenters()->where('is_main', 1)->first()->division_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" {{ (old('division_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option> --}}
                                                        <option {{ (($employee->divisionCenters->count()) && $employee->divisionCenters->first()->division_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" {{ (old('division_id') == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 center-division-item">
                                            <div class="form-group ">
                                                <label>center</label>
                                                <select id="center" name="center_id" class="form-control center" required>
                                                    <option value="">Select Center</option>
                                                    @foreach ($centers as $item)
                                                        {{-- <option {{ (($employee->divisionCenters()->where('is_main', 1)->count()) && $employee->divisionCenters()->where('is_main', 1)->first()->center_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" {{ (old('center_id') == $item->id) ? 'selected' : '' }}>{{ $item->center }}</option> --}}
                                                        <option {{ (($employee->divisionCenters->count()) && $employee->divisionCenters->first()->center_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" {{ (old('center_id') == $item->id) ? 'selected' : '' }}>{{ $item->center }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Job Role</label>
                                                <select name="job_role_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($jobRoles as $item)
                                                    <option {{ (($employeeJourney->jobRole) && $employeeJourney->jobRole->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>New Role Joining Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="new_role_doj" value="{{ $employeeJourney->new_role_doj }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <hr class="bg-info">
                                        </div>


{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Department</label>--}}
{{--                                                <select name="department_id" class="form-control">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($departments as $item)--}}
{{--                                                    <option {{ (($employeeJourney->department) && $employeeJourney->department->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <select name="designation_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($designations as $item)
                                                        <option {{ (($employeeJourney->designation) && $employeeJourney->designation->name == $item->name) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Employment Type</label>
                                                <select name="employment_type_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($employmentTypes as $item)
                                                    <option {{ ($employeeJourney->employmentType && $employeeJourney->employmentType->type == $item->type) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Employee Status</label>
                                                <select name="employee_status_id" id="employee_status_id" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach ($employeeStatuses as $item)
                                                    <option {{ ($employeeJourney->employeeStatus && $employeeJourney->employeeStatus->status == $item->status) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Separation Reason </label>
                                                <select name="separation_id" id="separation_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach (\App\Utils\EmployeeClosing::SeparationReason as $key => $item)
                                                        <option {{ ($employeeJourney->separation_type && $employeeJourney->separation_type == $item) ? 'selected' : '' }} value="{{ $item }}">{{ _lang('employee-closing.separationReason.'.$item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <hr class="bg-info">
                                        </div>
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Supervisor 1</label>--}}

{{--                                                <select name="sup1" class="form-control kt-selectpicker" data-live-search="true" data-size="5">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($employeeList as $item)--}}
{{--                                                    <option {{ ($employeeJourney->sup1 == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" data-tokens="{{ $item->first_name }} {{ $item->last_name }}">{{ $item->first_name }} {{ $item->last_name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Supervisor 2</label>--}}

{{--                                                <select name="sup2" class="form-control  kt-selectpicker" data-live-search="true" data-size="5">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($employeeList as $item)--}}
{{--                                                    <option {{ ($employeeJourney->sup2 == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" data-tokens="{{ $item->first_name }} {{ $item->last_name }}">{{ $item->first_name }} {{ $item->last_name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-xl-6">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label>Head of Department</label>--}}


{{--                                                <select name="hod" class="form-control kt-selectpicker" data-live-search="true" data-size="5">--}}
{{--                                                    <option value="">Select</option>--}}
{{--                                                    @foreach ($employeeList as $item)--}}
{{--                                                    <option {{ ($employeeJourney->hod == $item->id) ? 'selected' : '' }} value="{{ $item->id }}" data-tokens="{{ $item->first_name }} {{ $item->last_name }}">{{ $item->first_name }} {{ $item->last_name }}</option>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}


{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Date of Join</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="doj" value="{{ $employeeJourney->doj }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Contract Start</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="contract_start_date" value="{{ $employeeJourney->contract_start_date }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Contract End</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="contract_end_date" value="{{ $employeeJourney->contract_end_date }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Probation Start Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="probation_start_date"  value="{{ $employeeJourney->probation_start_date }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Probation Period</label>
                                                <input type="number" class="form-control" name="probation_period" placeholder="Probation Period (months)" value="{{ $employeeJourney->probation_period }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Probation Remarks</label>
                                                <textarea class="form-control" id="exampleTextarea" rows="3" name="probation_remarks">{{ $employeeJourney->probation_remarks }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Confirmation Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="permanent_doj" value="{{ $employeeJourney->permanent_doj }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Last Working Day</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select date" id="kt_datepicker_3" name="lwd" value="{{ $employeeJourney->lwd }}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <hr class="bg-info">
                                        </div>
                                        @if($employeeJourney->employee)
                                        {{-- fixed office time --}}
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                                    <input type="checkbox" {{ ($employeeJourney->is_fixed_officetime) ? "checked" : "" }} class="is_fixed_officetime" name="is_fixed_officetime" > Is Fixed Office Time?
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="fixed_office_time_input">
                                            {{-- Sunday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Sunday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[0]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[0]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[0]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Sunday" > Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Monday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Monday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[1]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[1]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[1]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Monday" > Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Tuesday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Tuesday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[2]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[2]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[2]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Tuesday"> Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Wednesday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Wednesday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[3]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[3]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[3]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]"  value="Wednesday"> Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Thursday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Thursday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[4]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[4]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[4]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Thursday"> Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Friday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Friday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[5]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[5]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[5]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Friday"> Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Saturday --}}
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Day</label>
                                                        <input type="text" name="day[]" placeholder="Day" value="Saturday" readonly class="form-control week-day fixed-time-form" aria-describedby="day-error" aria-invalid="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster Start</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_start[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[6]->roster_start : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Roster End</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control time-picker fixed-time-form" readonly required placeholder="Select time" name="roster_end[]" value="{{ ($employeeJourney->employee->fixedOfficeTime->count()) ? $employeeJourney->employee->fixedOfficeTime[6]->roster_end : null }}"/>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-clock-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-5">
                                                            <input type="checkbox" {{ ($employeeJourney->employee->fixedOfficeTime->count() && $employeeJourney->employee->fixedOfficeTime[6]->is_offday) ? 'checked' : null }} class="is_offday fixed-time-form" name="is_offday[]" value="Saturday"> Is Offday?
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 3-->

                        <!--begin: Form Wizard Step 4-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-form__section kt-form__section--first">
                                <div class="kt-wizard-v1__form">
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" name="contact_number" placeholder="Contact Number" value="{{ $employee->contact_number }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Alt. Contact Number</label>
                                                <input type="text" class="form-control" name="alt_contact_number" placeholder="Alt Contact Number" value="{{ $employee->alt_contact_number }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Pool Phone Number</label>
                                                <input type="text" class="form-control" name="pool_phone_number" placeholder="Pool Phone Number" value="{{ $employee->pool_phone_number }}">
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <hr class="bg-info">
                                        </div>


                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Emergency Contact Person</label>
                                                <input type="text" class="form-control" name="emergency_contact_person" placeholder="Name" value="{{ $employee->emergency_contact_person }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Emergency Contact Person's Number</label>
                                                <input type="text" class="form-control" name="emergency_contact_person_number" placeholder="Emergency Contact Person's Number" value="{{ $employee->emergency_contact_person_number }}">
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Relation With Employee</label>
                                                <input type="text" class="form-control" name="relation_with_employee" placeholder="Relation With Employee" value="{{ $employee->relation_with_employee }}">
                                            </div>
                                        </div>


                                        <div class="col-xl-12">
                                            <hr class="bg-info">
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Present Address</label>
                                                <textarea class="form-control" id="exampleTextarea" rows="3" name="present_address">{{ $employee->present_address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Permanent Address</label>
                                                <textarea class="form-control" id="exampleTextarea" rows="3" name="permanent_address">{{ $employee->permanent_address }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end: Form Wizard Step 4-->



                        <!--begin: Form Actions -->
                        <div class="kt-form__actions">
                            <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                Previous
                            </div>
                            <button type="submit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                                Submit
                            </button>
                            <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                                Next Step
                            </div>
                        </div>

                        <!--end: Form Actions -->
                    </form>

                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- end:: Content -->
@endsection

@push('css')
<link href="{{ asset('assets/css/demo1/pages/general/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script> --}}
     <script src="{{ asset('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
     <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/typeahead.js/dist/typeahead.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/handlebars/dist/handlebars.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery-validation/dist/additional-methods.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/jquery-validation.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/dompurify/dist/purify.js') }}" type="text/javascript"></script>
@endpush

@push('js')

    <script src="{{ asset('assets/js/demo1/pages/wizard/wizard-1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-multipleselectsplitter.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    {{-- @include('layouts.partials.includes.division-center') --}}

@endpush

@push('js')

<script>
    $(".division").on('change', function () {
        let divisionID = $(this).val();
        let url = '{{ route("get.center",':divisionID' ) }}';
        url = url.replace(':divisionID', divisionID);
        let that = $(this);
        axios.get(url)
            .then(function (response) {
                // handle success
                $(".center").empty();
                $(".center").append('<option value="">Select Center</option>');
                $.each(response.data, function(id, value){
                    $(".center").append('<option value="'+ value.id +'">'+ value.center +'</option>')
                });
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                $(".center").empty();
                $(".center").append('<option value="">Select Center</option>')
            })
    });


    /* Requied separation type by select employee type */
    // Default
    $(document).ready(function(){
        let employeeType = $('#employee_status_id').val();
        if(employeeType == 1){
            $('#separation_id').removeAttr('required');
        }else{
            $('#separation_id').attr('required',true);
        }
    });
    // Onchange
    $('#employee_status_id').on('change', function() {
        let employeeType = $(this).val();
        if(employeeType == 1){
            $('#separation_id').removeAttr('required');
        }else{
            $('#separation_id').attr('required',true);
        }
    });

</script>
<script>

    $(document).ready(function(){

        let path = "{{ route('find.institute') }}";
        $('input.kt_typeahead_1').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $('.time-picker').timepicker({minuteStep:1,defaultTime:"",showSeconds:!0,showMeridian:!1,snapToStep:!0});

        $('.is_offday').on('change', function () {
            if($(this).is(":checked")){
                $(this).closest('.col-sm-3').siblings().find('.time-picker').removeAttr('required').val(null);
            }else{
                $(this).closest('.col-sm-3').siblings().find('.time-picker').prop('required',true).prop('disabled', false);
            }
        });

        if($('.is_fixed_officetime').is(":checked")){
            $('#fixed_office_time_input').find('.fixed-time-form').prop('disabled', false);
            $('#fixed_office_time_input').find('.fixed-time-form:not(.is_offday,.week-day)').prop('required',true);
            $('#fixed_office_time_input').show();

        }else{
            $('#fixed_office_time_input').find('.fixed-time-form').prop('disabled', true);
            $('#fixed_office_time_input').find('.fixed-time-form').removeAttr('required');
            $('#fixed_office_time_input').hide();
        }

        $('.is_fixed_officetime').on('change', function() {
            if($(this).is(":checked")){
                $('#fixed_office_time_input').find('.fixed-time-form').prop('disabled', false);
                $('#fixed_office_time_input').find('.fixed-time-form:not(.is_offday,.week-day)').prop('required',true);
                $('#fixed_office_time_input').show();

            }else{
                $('#fixed_office_time_input').find('.fixed-time-form').prop('disabled', true);
                $('#fixed_office_time_input').find('.fixed-time-form').removeAttr('required');
                $('#fixed_office_time_input').hide();

            }
        });

        // let divisionCenter = (_=>_)({!! json_encode(($employee) ? $employee->divisionCenters()->where('is_main', 1)->first() : null) !!});
        // console.log(divisionCenter);

        // $(".center").each(function() {
        //     let division = $(this).closest('.center-division-item').prev().find('.division');
        //     if(division.val()){
        //         let url = '{{ route("get.center",':divisionID') }}';
        //         url = url.replace(':divisionID', division.val());
        //         let that = division;
        //         axios.get(url).then(function (response) {
        //             that.closest('.center-division-form').children().find(".center").empty();
        //             that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>');
        //             $.each(response.data, function(id, value){
        //                 let selected = ((divisionCenter.center_id == value.id) ? "selected" : "");
        //                 that.closest('.center-division-form').children().find(".center").append('<option '+selected+' value="'+ value.id +'">'+ value.center +'</option>')
        //             });
        //         })
        //         .catch(function (error) {
        //             that.closest('.center-division-form').children().find(".center").empty();
        //             that.closest('.center-division-form').children().find(".center").append('<option value="">Select Center</option>')
        //         })
        //     }
        // });

        $(document).on("keyup change blur", '#employer_id', function (e) {
            var employer_id = $(this).val();
            var id = '{{ $employee->id }}';
            $.ajax({
                type: "POST",
                url: '{{route('check.id')}}',
                data: {
                    id: id,
                    employer_id:employer_id
                },
                dataType: "json",
                success: function(res) {
                    var validator = $( "#kt_form" ).validate();
                    if(res.exists){
                        validator.showErrors({
                            "employer_id": "Employee ID is already taken."
                        });
                    }else{

                    }
                },
                error: function (jqXHR, exception) {
                    console.log(exception)
                }
            });
        });
    });


{{--    $(document).ready(function(){--}}

{{--        @if($employeeJourney->process_id)--}}
{{--        let processID = $("select[name='process_id']").val();--}}
{{--        let url = '{{ route("employee.get.processSegment",':processID' ) }}';--}}
{{--        url = url.replace(':processID', processID);--}}
{{--        if(processID){--}}
{{--            $.ajax({--}}
{{--                url: url,--}}
{{--                type: "GET",--}}
{{--                dataType: "json",--}}
{{--                success: function(data){--}}
{{--                    console.log(data);--}}
{{--                    $('select[name="process_segment_id"]').empty();--}}
{{--                    $.each(data, function(index, value){--}}


{{--                        let selected = "";--}}
{{--                        let processsSegmentId = (_=>_) {{ $employeeJourney->process_segment_id }};--}}

{{--                        if(processsSegmentId == value.id){--}}
{{--                            selected = 'selected';--}}
{{--                        }--}}

{{--                        $('select[name="process_segment_id"]').append('<option '+ selected +' value="'+ value.id +'">'+ value.name +'</option>')--}}
{{--                        selected = "";--}}
{{--                    })--}}

{{--                }--}}
{{--            })--}}
{{--        }--}}
{{--        else--}}
{{--        {--}}
{{--            $('select[name="process_segment_id"]').empty();--}}
{{--        }--}}

{{--        @endif--}}

{{--        $("select[name='process_id']").on('change', function(){--}}
{{--            let processID = $(this).val();--}}
{{--            let url = '{{ route("employee.get.processSegment",':processID' ) }}';--}}
{{--            url = url.replace(':processID', processID);--}}
{{--            if(processID){--}}
{{--                $.ajax({--}}
{{--                    url: url,--}}
{{--                    type: "GET",--}}
{{--                    dataType: "json",--}}
{{--                    success: function(data){--}}
{{--                        console.log(data);--}}
{{--                        $('select[name="process_segment_id"]').empty();--}}
{{--                        $.each(data, function(index, value){--}}
{{--                            $('select[name="process_segment_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>')--}}
{{--                        })--}}

{{--                    }--}}
{{--                })--}}
{{--            }--}}
{{--            else--}}
{{--           {--}}
{{--              $('select[name="process_segment_id"]').empty();--}}
{{--           }--}}
{{--        });--}}


        // $('#kt_form').validate({
        //     rules: {
        //         email: {
        //             required: false,
        //             email: true,
        //         }
        //     }
        // });


{{--    })--}}


</script>
@endpush
