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
                            <div class="kt-widget__head kt-widget__media">
                                <form method="post" id="imageUploadForm" action="javascript:void(0)" enctype="multipart/form-data">
                                    @csrf
                                    <div class="kt-avatar kt-avatar--outline kt-avatar--circle- " id="kt_apps_user_add_avatar">
                                        <img class="kt-widget__img kt-hidden- img-fluid" id="pro-pic"
                                             src="{{ ($employee->profile_image) ? asset('/storage/employee/img/'.$employee->profile_image) : (($employee->gender == 'Male') ? asset('assets/media/users/default_male.png') : asset('assets/media/users/default_female.png'))}} "
                                             alt="image">
                                        <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                            <i class="fa fa-pen"></i>
                                            <input type="file" name="profile_pic" id="profile-pic" accept=".png, .jpg, .jpeg">
                                        </label>
                                        <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                            <i class="fa fa-times"></i>
                                        </span>
                                    </div>
                                </form>
                                {{-- <div class="kt-widget__media">
                                    <img class="kt-widget__img kt-hidden-" src="{{ asset('/storage/employee/img/'.$employee->profile_image) }}" alt="image">
                                    <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
                                        JD
                                    </div>
                                </div> --}}
                                <div class="kt-widget__content">
                                    <div class="kt-widget__section">
                                        <a href="javascript: void(0);" class="kt-widget__username">
                                            {{ $employee->FullName }}
                                        </a>
                                        <div class="kt-widget__button">
                                            <span
                                                class="btn {{ ($employee->employeeJourney->employeeStatus->status =='Active') ? 'btn-label-success' : (($employee->employeeJourney->employeeStatus->status =='Inactive') ? 'btn-label-danger' : 'btn-label-warning' ) }} btn-sm">{{ $employee->employeeJourney->employeeStatus->status }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__body">
                                <div class="kt-widget__content mb-5">
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Employee ID:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->employer_id }}</a>
                                    </div>

                                    @if ($employee->login_id)
                                        <div class="kt-widget__info">
                                            <span class="kt-widget__label">Login ID:</span>
                                            <a href="#" class="kt-widget__data pull-right">{{ $employee->login_id ?? null }}</a>
                                        </div>
                                    @endif

                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Email:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->email }}</a>
                                    </div>
                                    <div class="clear-fix"></div>
                                    <br>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Phone:</span>
                                        <a href="#" class="kt-widget__data pull-right">{{ $employee->contact_number ?? null }}</a>
                                    </div>
                                    <div class="clear-fix"></div>
                                    <br>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Division:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->divisionCenters[0]->division->name ?? null }}</span>
                                    </div>
                                    <div class="clear-fix"></div>
                                    <br>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Center:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->divisionCenters[0]->center->center ?? null }}</span>
                                    </div>
                                    <div class="clear-fix"></div>
                                    <br>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Nearby Location:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->nearbyLocation->nearby ?? null }}</span>
                                    </div>
                                    <div class="clear-fix"></div>
                                    <br>
                                    <div class="kt-widget__info">
                                        <span class="kt-widget__label">Blood Group:</span>
                                        <span class="kt-widget__data pull-right">{{ $employee->bloodGroup->name ?? null }}</span>
                                    </div>
                                </div>


                                <div class="kt-widget__items">
                                    @if ($employee->userDetails)
                                        <a href="#" class="kt-widget__item " id="profile">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24"
                                                     version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path
                                                            d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path
                                                            d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                            fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Profile
                                            </span>
                                        </span>
                                        </a>


                                        <a href="#" class="kt-widget__item " id="changePassword">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24"
                                                     version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <mask fill="white">
                                                            <use xlink:href="#path-1"/>
                                                        </mask>
                                                        <g/>
                                                        <path
                                                            d="M15.6274517,4.55882251 L14.4693753,6.2959371 C13.9280401,5.51296885 13.0239252,5 12,5 C10.3431458,5 9,6.34314575 9,8 L9,10 L14,10 L17,10 L18,10 C19.1045695,10 20,10.8954305 20,12 L20,18 C20,19.1045695 19.1045695,20 18,20 L6,20 C4.8954305,20 4,19.1045695 4,18 L4,12 C4,10.8954305 4.8954305,10 6,10 L7,10 L7,8 C7,5.23857625 9.23857625,3 12,3 C13.4280904,3 14.7163444,3.59871093 15.6274517,4.55882251 Z"
                                                            fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Change Password
                                            </span>
                                        </span>
                                        </a>


                                        <a href="{{ route('user.update.profile.view') }}" class="kt-widget__item ">
                                        <span class="kt-widget__section">
                                            <span class="kt-widget__icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24"
                                                     version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect opacity="0.200000003" x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M4.5,7 L9.5,7 C10.3284271,7 11,7.67157288 11,8.5 C11,9.32842712 10.3284271,10 9.5,10 L4.5,10 C3.67157288,10 3,9.32842712 3,8.5 C3,7.67157288 3.67157288,7 4.5,7 Z M13.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L13.5,18 C12.6715729,18 12,17.3284271 12,16.5 C12,15.6715729 12.6715729,15 13.5,15 Z"
                                                            fill="#000000" opacity="0.3"/>
                                                        <path
                                                            d="M17,11 C15.3431458,11 14,9.65685425 14,8 C14,6.34314575 15.3431458,5 17,5 C18.6568542,5 20,6.34314575 20,8 C20,9.65685425 18.6568542,11 17,11 Z M6,19 C4.34314575,19 3,17.6568542 3,16 C3,14.3431458 4.34314575,13 6,13 C7.65685425,13 9,14.3431458 9,16 C9,17.6568542 7.65685425,19 6,19 Z"
                                                            fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            <span class="kt-widget__desc">
                                                Update Profile
                                            </span>
                                        </span>
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                        <!--end::Widget -->

                        <br><br>
                        {{--                        <div class="kt-section__content kt-section__content--solid">--}}
                        {{--                            @if ($employee->userDetails)--}}
                        {{--                                <a href="{{ route('user.update.profile.view') }}" class="btn btn-label btn-label-brand btn-sm btn-bold col-12" style="margin-top: 10px;"><i--}}
                        {{--                                        class="la la-gears"></i> Update Profile </a>--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                    </div>
                </div>

                <!--end:: Widgets/Applications/User/Profile4-->

            </div>

            <!--End:: App Aside-->


            <!--Begin:: App Content-->
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row" id="user-content">
                    {{-- User Details accordion --}}
                    @if(!session()->exists('user-profile-active') || session('user-profile-active') == 'profile-details')
                        @include('user.user-profile.user-details')
                    @elseif(session('user-profile-active') == 'change-password')
                        @include('user.user-profile.user-change-password')
                    @endif

                </div>
            </div>

            <!--End:: App Content-->
        </div>

        <!--End::App-->
    </div>

    <!-- end:: Content -->
@endsection


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/custom/apps/user/profile.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script>

        $(document).ready(function (e) {
            $('#profile-pic').on('change', (function (e) {

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });

                e.preventDefault();

                var formData = new FormData();
                formData.append('profile_pic', $('#profile-pic')[0].files[0]);

                $.ajax({

                    type: 'POST',

                    url: "{{ route('user.profilePic.upload')}}",

                    data: formData,

                    cache: false,

                    contentType: false,

                    processData: false,

                    success: function (data) {
                        $('#pro-pic').attr('src', '{{ asset("storage/employee/img") }}/' + data);
                        $('.header-user-image').attr('src', '{{ asset("storage/employee/img/thumbnail") }}/' + data);

                        console.log('uploaded');


                    },
                    error: function (data) {
                        location.reload();
                        // console.log(data);
                    }

                });
            }));


            $('#profile').on('click', (function (e) {
                e.preventDefault();
                $('#user-content').empty();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('user.details')}}",
                    success: function (data) {
                        $('#user-content').html(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }));

            $('#changePassword').on('click', (function (e) {
                e.preventDefault();
                $('#user-content').empty();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('user.change.password')}}",
                    success: function (data) {
                        $('#user-content').html(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }));
        });

    </script>
@endpush

