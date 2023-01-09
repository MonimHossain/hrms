@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--Begin::App-->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

            <!--Begin:: App Aside Mobile Toggle-->
            <button class="kt-app__aside-close" id="kt_user_profile_aside_close">
                <i class="la la-close"></i>
            </button>

            <!--End:: App Aside Mobile Toggle-->

            <!--Begin:: App Aside-->
            <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_user_profile_aside">

                <!--begin:: Widgets/Applications/User/Profile4-->
                <div class="kt-portlet kt-portlet--height-fluid-">
                    <div class="kt-portlet__body">

                        <!--begin::Widget -->
                        <div class="kt-widget kt-widget--user-profile-4 ">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <img class=" img-fluid"
                                         src="{{ ($employee->profile_image) ? asset('/storage/employee/img/'.$employee->profile_image) : (($employee->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))}}"
                                         alt="image">
                                    <div
                                        class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
                                        JD
                                    </div>
                                </div>
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="javascript: void(0);" class="kt-widget__username">
                                            {{ $employee->FullName }}
                                        </a>
                                        <div class="kt-widget__button">
                                        <span
                                            class="btn {{ ($employee->employeeJourney->employeeStatus->status =='Active') ? 'btn-label-success' : (($employee->employeeJourney->employeeStatus->status =='Inactive') ? 'btn-label-danger' : 'btn-label-warning' ) }} btn-sm">{{ $employee->employeeJourney->employeeStatus->status }}
                                        </span>
                                        @if(isset($employee->employeeJourney->separation_type) && ($employee->employeeJourney->employeeStatus->status !='Active'))
                                        <span
                                            class="btn {{ ($employee->employeeJourney->employeeStatus->status =='Active') ? 'btn-label-success' : (($employee->employeeJourney->employeeStatus->status =='Inactive') ? 'btn-label-danger' : 'btn-label-warning' ) }} btn-sm">{{ _lang('employee-closing.separationReason.'.$employee->employeeJourney->separation_type) }}
                                        </span>
                                        @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__body">
                                <div class="kt-widget__content">
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Employee ID:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->employer_id }}</a>
                                    </div>

                                    @if ($employee->login_id)
                                        <div class="kt-widget__info">
                                            <span class="kt-widget__label">Login ID:</span>
                                            <a href="#" class="kt-widget__data pull-right">{{ $employee->login_id }}</a>
                                        </div>
                                    @endif

                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Email:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->email }}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Phone:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->contact_number }}</a>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Division:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->divisionCenters->where('is_main',1)->first()->division->name ?? null }}</span>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Center:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->divisionCenters->where('is_main',1)->first()->center->center ?? null }}</span>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Nearby Location:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->nearbyLocation->nearby ?? null }}</span>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Blood Group:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->bloodGroup->name ?? null }}</span>
                                    </div>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Login Access:</span>
                                        <span
                                            class="kt-widget__data float-right font-weight-bold {{ ($employee->userDetails['employee_id']) ? 'text-success' : 'text-danger' }}">{{ ($employee->userDetails['employee_id']) ? 'Yes' : 'No' }}</span>
                                        {{-- <span class="kt-widget__data pull-right font-weight-bold {{ ($employee->userDetails->employee_id) ? 'text-success' : 'text-danger' }}">{{ ($employee->userDetails->employee_id) ? 'Yes' : 'No' }}</span>
                                        --}}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--end::Widget -->

                        <br><br>
                        <div class="kt-section__content kt-section__content--solid  row">
                            <div class="kt-section__content kt-section__content--solid">

                                @canany([_permission(\App\Utils\Permissions::EMPLOYEE_EDIT)])
                                <a href="{{ route('employee.update.view', ["id" => $employee->id]) }}" data-skin="dark" data-toggle="kt-tooltip" data-placement="top" data-original-title="Update Info" class="btn btn-outline-primary btn-elevate btn-icon" title=""><i class="flaticon-edit"></i></a>&nbsp;
                                @endcanany

                                <a href="{{ route('employee.journey', ["id" => $employee->id]) }}" data-skin="dark" data-toggle="kt-tooltip" data-placement="top" data-original-title="Journey"  class="btn btn-outline-primary btn-elevate btn-icon" title=""><i class="fa fa-route"></i></a>&nbsp;

                                @canany([_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE)])
                                    @if ($employee->userDetails)
                                     <a href="{{ route('employee.permissions.view', ["id" => $employee->id]) }}" class="btn btn-outline-primary btn-elevate btn-icon" data-skin="dark" data-toggle="kt-tooltip" data-placement="top" data-original-title="Role & Permission"  title=""><i class="la la-user-secret"></i></a>&nbsp;
                                    @endif
                                @endcanany

                                <button class="btn {{ ($employee->userDetails['employee_id']) ? 'btn-outline-primary' : 'btn-outline-danger' }}  btn-elevate btn-icon"  data-toggle="modal" data-target="#kt_modal_4" title="">
                                    <i data-skin="dark" data-toggle="kt-tooltip" data-placement="top" data-original-title="{{ ($employee->userDetails['employee_id']) ? 'Update Login' : 'Login Access' }}"  class="la la-sign-in"></i>
                                </button>&nbsp;
                            </div>
{{--                            <div class="col-sm-6">--}}
{{--                                <button type="button"--}}
{{--                                        class="col-sm-12 btn  {{ ($employee->userDetails['employee_id']) ? 'btn-outline-primary' : 'btn-outline-danger' }} "--}}
{{--                                        data-toggle="modal" data-target="#kt_modal_4">--}}
{{--                                    {{ ($employee->userDetails['employee_id']) ? 'Update Login' : 'Login Access' }}</button>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-6">--}}
{{--                                <a href="{{ route('employee.journey', ["id" => $employee->id]) }}"--}}
{{--                                   class="col-sm-12  btn btn-outline-primary"> Journey</a>--}}
{{--                            </div>--}}

{{--                            @canany([_permission(\App\Utils\Permissions::EMPLOYEE_EDIT)])--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    --}}{{-- <button type="button" class="btn btn-label btn-label-brand btn-sm btn-bold col-12" style="margin-top: 10px;"  data-toggle="modal" data-target="#role_permission"><i class="la la-user-secret"></i> Role & Permission</button> --}}
{{--                                    <a href="{{ route('employee.update.view', ["id" => $employee->id]) }}"--}}
{{--                                       class="btn btn-label btn-label-brand btn-sm btn-bold col-12"--}}
{{--                                       style="margin-top: 10px;"><i class="flaticon-edit"></i></a>--}}
{{--                                </div>--}}
{{--                            @endcanany--}}
{{--                            @canany([_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE)])--}}
{{--                                @if ($employee->userDetails)--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        --}}{{-- <button type="button" class="btn btn-label btn-label-brand btn-sm btn-bold col-12" style="margin-top: 10px;"  data-toggle="modal" data-target="#role_permission"><i class="la la-user-secret"></i> Role & Permission</button> --}}
{{--                                        <a href="{{ route('employee.permissions.view', ["id" => $employee->id]) }}"--}}
{{--                                           class="btn btn-label btn-label-brand btn-sm btn-bold col-12"--}}
{{--                                           style="margin-top: 10px;"><i class="la la-user-secret"></i> Role & Permission</a>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            @endcanany--}}
                        </div>

                        <!--begin::Modal-->
                        <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Login Credentials:</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <form action="{{ route('employee.loginAccess.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="employer_id" value="{{ $employee->employer_id }}">
                                        <input type="hidden" class="form-control" id="email" name="email"
                                               value="{{ $employee->email }}">
                                        <div class="modal-body">
                                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                            {{--                                        <div class="form-group">--}}
                                            {{--                                            <label for="email" class="form-control-label">Email:</label>--}}
                                            {{--                                            <input type="email" class="form-control" id="email" name="email"--}}
                                            {{--                                                value="{{ $employee->email }}">--}}
                                            {{--                                        </div>--}}
                                            <div class="form-group">
                                                <label for="password" class="form-control-label">Password:</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                            </div>
                                            {{--                                        <div class="form-group">--}}
                                            {{--                                            <label for="re-password" class="form-control-label">Retype Password:</label>--}}
                                            {{--                                            <input type="password" class="form-control" id="re-password"--}}
                                            {{--                                                name="repassword">--}}
                                            {{--                                        </div>--}}
                                            {{--                                        <div class="form-group">--}}
                                            {{--                                            <label for="exampleSelect1">Role</label>--}}
                                            {{--                                            <select class="form-control" id="exampleSelect1" name="role" required>--}}
                                            {{--                                                <option>Select</option>--}}
                                            {{--                                                @foreach ($roles as $item)--}}
                                            {{--                                                <option value="{{ $item->name }}">{{ $item->name }}</option>--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </select>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Enable Login Access</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <!--begin::Role & Permission Modal-->
                        {{-- <div class="modal fade" id="role_permission" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="role-name"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <form action="{{ route('employee.permissions') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="employee_id" name="employee_id"
                                               value="{{ $employee->id }}">
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>Give role to <span
                                                        class="text-bold">{{ $employee->FullName }}</span>:</label>
                                                <div class="kt-checkbox-inline">
                                                    @foreach ($roles as $item)
                                                        <label class="kt-checkbox kt-checkbox--info">
                                                            <input
                                                                {{ ($employee->userDetails && $employee->userDetails->hasRole($item)) ? 'checked' : '' }}
                                                                type="checkbox" name="roles[]" value="{{ $item->name }}">
                                                            {{ $item->name }}
                                                            <span></span>
                                                        </label>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Give extra permissions:</label>
                                                <div class="kt-checkbox-inline">
                                                    @foreach ($permissions as $item)
                                                        <label class="kt-checkbox kt-checkbox--info">
                                                            <input
                                                                {{ ($employee->userDetails && $employee->userDetails->hasPermissionTo($item)) ? 'checked' : '' }}
                                                                type="checkbox" name="permissions[]" value="{{ $item->name }}">
                                                            {{ $item->name }}
                                                            <span></span>
                                                        </label>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        <!--end::Modal-->
                    </div>
                </div>

                <!--end:: Widgets/Applications/User/Profile4-->

            </div>

            <!--End:: App Aside-->


            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">

                <div class="row">
                    <!--begin::Accordion-->
                    <div class="accordion  accordion-toggle-arrow" id="accordionExample4" style="width: 100%;">
                        <div class="card">
                            <div class="card-header" id="headingOne4">
                                <div class="card-title" data-toggle="collapse" data-target="#collapsethree4"
                                     aria-expanded="true" aria-controls="collapseOne4">
                                    <i class="flaticon2-layers-1"></i> Contact Info
                                </div>
                            </div>
                            <div id="collapsethree4" class="collapse show" aria-labelledby="headingOne"
                                 data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="card-content">
                                        <div class="row">
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contact Number:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->contact_number ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Corporate Number:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->pool_phone_number ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Alt. Number:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->alt_contact_number ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Emergency Contact:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->emergency_contact_person ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Emergency Number:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->emergency_contact_person_number ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Rel. with Employee:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->relation_with_employee ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Present Address:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->present_address ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Parmanent Address:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->parmanent_address  ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingOne4">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true"
                                     aria-controls="collapseOne4">
                                    <i class="flaticon2-layers-1"></i> Personal Info
                                </div>
                            </div>
                            <div id="collapseOne4" class="collapse " aria-labelledby="headingOne"
                                 data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Name:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->first_name }} {{ $employee->last_name }}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Login ID:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->login_id ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Email:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->email }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Gender:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->gender ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Date of Birth:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->date_of_birth ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">NID:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->nid ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Passport:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->passport ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Marital Status:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->marital_status ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Religion:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->religion ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">SSC. Reg:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->ssc_reg_num ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Location:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->location ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Nearby Location:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->nearby_location ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">

                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Father's Name:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->father_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Mother's Name:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->mother_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Spouse Name:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->spouse_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Spouse Birthday:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->spouse_dob ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Name 1:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child1_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Birthday 1:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child1_dob ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Name 2:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child2_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Birthday 2:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child2_dob ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Name 3:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child3_name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Child Birthday 3:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->child3_dob ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingfour4">
                                <div class="card-title" data-toggle="collapse" data-target="#collapsefour4" aria-expanded="true"
                                     aria-controls="collapsefour4">
                                    <i class="flaticon2-layers-1"></i> Employment Info
                                </div>
                            </div>
                            <div id="collapsefour4" class="collapse" aria-labelledby="headingfour"
                                 data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employee ID:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employer_id }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            @if ($employee->login_id)
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Login ID:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $employee->login_id ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                            @endif

                                            @if($employee->departmentProcess)
                                            <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Department:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">
                                                            @foreach($employee->departmentProcess->unique('department_id') as $item)
                                                                {{ $item->department->name ?? null }}@if(!$loop->last && $item->department) , @endif
                                                            @endforeach
                                                        </div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Process:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">
                                                            @foreach($employee->departmentProcess->unique('department_id') as $item)
                                                                {{ $item->process->name ?? null }}@if(!$loop->last && $item->process) , @endif
                                                            @endforeach
                                                        </div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Process Segment:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">
                                                            @foreach($employee->departmentProcess->unique('department_id') as $item)
                                                                {{ $item->processSegment->name ?? null }}@if(!$loop->last && $item->processSegment) , @endif
                                                            @endforeach
                                                        </div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                            @endif

                                        <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Designation:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->designation->name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Job Role:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->jobRole->name ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employment Type:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->employmentType->type ?? null }}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employee Status:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->employeeStatus->status ?? null }}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Team Lead: </label></div>
                                                    <!-- /.col-5 -->
                                                    <div
                                                        class="col-7">{{ $employee->teamMember()->wherePivot('member_type', \App\Utils\TeamMemberType::MEMBER)->first()->teamLead->FullName ?? null }}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Date of Joining:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->doj ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract Start:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->contract_start_date ?? null }}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract End:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->contract_end_date ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process Joining Date:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->process_doj ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process LWD:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->process_lwd ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Permanent DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->permanent_doj ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">New Role DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->employeeJourney->new_role_doj ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Nearby Location:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $employee->nearbyLocation->nearby ?? null }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold"></label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7"></div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.col-lg-6 -->
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-4"><label class="bold">Division:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-8">
                                                        <!--begin::Timeline 1-->
                                                        <div class="kt-list-timeline">
                                                            <div class="kt-list-timeline__items">
                                                                @foreach($employee->divisionCenters as $item)

                                                                    <div class="kt-list-timeline__item" style="width: auto;">
                                                                        <span class="kt-list-timeline__badge"></span>
                                                                        <span class="kt-list-timeline__text"
                                                                              style="padding: 0 0 0 15px;">{{ $item->division->name ?? null }} - {{ $item->center->center ?? null }}</span>

                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                        <!--end::Timeline 1-->
                                                        {{--                                                        {{ $employee->divisionCenters[0]->division->name ?? null }}--}}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-4"><label class="bold">Last Working Day:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-8">
                                                        <!--begin::Timeline 1-->
                                                        <div class="kt-list-timeline">
                                                            <div class="kt-list-timeline__items">
                                                                {{ (!is_null($employee->employeeJourney->lwd))? \Carbon\Carbon::parse($employee->employeeJourney->lwd)->format('d M, Y') : '' }}
                                                            </div>
                                                        </div>
                                                        <!--end::Timeline 1-->
                                                        {{--                                                        {{ $employee->divisionCenters[0]->division->name ?? null }}--}}
                                                    </div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>


                                            <!-- /.col-lg-6 -->
                                            <!-- /.col-lg-6 -->
                                            {{--                                            <div class="col-lg-6">--}}
                                            {{--                                                <div class="row">--}}
                                            {{--                                                    <div class="col-5"><label class="bold">Center:</label></div>--}}
                                            {{--                                                    <!-- /.col-5 -->--}}
                                            {{--                                                    <div class="col-7">{{ $employee->divisionCenters[0]->center->center ?? null }}</div>--}}
                                            {{--                                                    <!-- /.col-7 -->--}}
                                            {{--                                                </div>--}}
                                            {{--                                                <!-- /.row -->--}}
                                            {{--                                            </div>--}}


                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingfive5">
                                <div class="card-title" data-toggle="collapse" data-target="#collapsefive5" aria-expanded="true"
                                     aria-controls="collapsefive5">
                                    <i class="flaticon2-layers-1"></i> Academic Info
                                </div>
                            </div>
                            <div id="collapsefive5" class="collapse" aria-labelledby="headingfive"
                                 data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="card-content">
                                        @foreach ($employee->educations as $education)
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Level of Education:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->levelOfEducation->name ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Institute:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->institute ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Title of Degree/Exam:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->exam_degree_title ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Major:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->major ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Result:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->result ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Passing Year:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $education->passing_year ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->


                                            </div>
                                            <!-- /.row -->

                                            <div class="col-xl-12">
                                                <hr class="">
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingsix6">
                                <div class="card-title" data-toggle="collapse" data-target="#collapsesix6" aria-expanded="true"
                                     aria-controls="collapsesix6">
                                    <i class="flaticon2-layers-1"></i> Training Info
                                </div>
                            </div>
                            <div id="collapsesix6" class="collapse" aria-labelledby="headingsix"
                                 data-parent="#accordionExample4">
                                <div class="card-body">
                                    <div class="card-content">
                                        @foreach ($employee->trainings as $training)
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Level of Education:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->training_title ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Country:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->country ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Topics Covered:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->topics_covered ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Training Year:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->training_year ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Institute:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->institute ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Duration:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->duration ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Location:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ $training->location ?? null }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.col-lg-6 -->

                                            </div>
                                            <!-- /.row -->

                                            <div class="col-xl-12">
                                                <hr class="">
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @canany([\App\Utils\Permissions::EMPLOYEE_CREATE, \App\Utils\Permissions::EMPLOYEE_EDIT])
                    <!--end::Accordion-->
                        <div class="kt-portlet mt-5">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Manage Multiple Center Division
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <!--begin::Section-->
                                <div class="kt-section">
                                    <div class="kt-section__content">
                                        <div class="table-responsive">
                                            <form action="{{ route('employee.multi.division.center') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                                <input type="hidden" name="is_main" value="0">
                                                <table class="table table-bordered" id="lookup">
                                                    <thead>
                                                    <tr>
                                                        <th>Division</th>
                                                        <th>Center</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <select name="division_id" class="form-control division-id" aria-invalid="false" required>
                                                                    <option value="">Select</option>
                                                                    @foreach($divisions as $division)
                                                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <select name="center_id" class="form-control center-id" aria-invalid="false" required>
                                                                    <option value="">Select</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-primary mb-2">ADD</button>
                                                        </td>
                                                    </tr>


                                                    @foreach($employee->divisionCenters as $item)
                                                        <tr>
                                                            <td>{{ $item->division->name }} <span
                                                                    class="text-success font-weight-bold">{{ ($item->is_main) ? '(Primary)' : '' }}</span></td>
                                                            <td>{{ $item->center->center }} <span
                                                                    class="text-success font-weight-bold">{{ ($item->is_main) ? '(Primary)' : '' }}</span></td>
                                                            <td>
                                                                @if(!$item->is_main)
                                                                    <a href="#" redirect="employee.profile" getRouteId="{{ $employee->id }}" modelName="EmployeeDivisionCenter"
                                                                       id="{{ $item->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Form-->
                        </div>
                    @endcanany
                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->
@endsection

@include('layouts.lookup-setup-delete')

@push('js')
    {{-- <script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
    --}}
    <script src="{{ asset('assets/js/demo1/pages/custom/apps/user/profile.js') }}" type="text/javascript"></script>
    <script !src="">
        $(".division-id").on('change', function () {
            let divisionID = $(this).val();
            let url = '{{ route("get.center",':divisionID' ) }}';
            url = url.replace(':divisionID', divisionID);
            let that = $(this);
            axios.get(url)
                .then(function (response) {
                    // handle success
                    $(".center-id").empty();
                    $(".center-id").append('<option value="">Select</option>');
                    $.each(response.data, function (id, value) {
                        $(".center-id").append('<option value="' + value.id + '">' + value.center + '</option>')
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    $(".center-id").empty();
                    $(".center-id").append('<option value="">Select Center</option>')
                })
        });
    </script>
@endpush
