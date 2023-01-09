<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- begin::Head -->

<head>

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="/">

    <!--end::Base Path -->
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
{{--    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>--}}

    <script src="{{asset('fonts/webfont.js')}}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });

    </script>

    <!--end::Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    @stack('css')



    <!--end::Page Vendors Styles -->

    <!--begin:: Global Mandatory Vendors -->
    <link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/general/socicon/css/socicon.css" rel="stylesheet') }}" type="text/css" />
    <link href="{{ asset('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/custom/vendors/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/vendors/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />

    {{--
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery-asPieProgress@0.4.7/dist/css/asPieProgress.min.css">
    --}}
    <link href="{{ asset('assets/vendors/general/jquery-asPieProgress/dist/css/asPieProgress.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!--end:: Global Mandatory Vendors -->

    <!--start:: google chart -->
    <script type="text/javascript" src="{{asset('charts/loader.js')}}"></script>


    <!--Morris -->
    <link href="{{ asset('assets/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />


    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/css/demo4/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-datepicker.css') }}">
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

</head>

<!-- end::Head -->

<!-- begin::Body -->

<body
    style="background-image: url({{ asset('assets/media/demos/demo4/header.jpg') }}); background-position: center top; background-size: 100% 80px;"
    class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

    <div id="app">
        <!-- begin::Page loader -->

        <!-- end::Page Loader -->

        <!-- begin:: Page -->

        <!-- begin:: Header Mobile -->
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                @if (request()
        ->session()
        ->get('validateRole') == 'Admin')
                    <a href="{{ route('dashboard') }}">
                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}" />
                    </a>
                @endif
                @if (request()
        ->session()
        ->get('validateRole') == 'User')
                    <a href="{{ route('user.dashboard') }}">
                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}" />
                    </a>
                @endif
            </div>
            <div class="kt-header-mobile__toolbar">
                <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                        class="flaticon-more-1"></i></button>
            </div>
        </div>

        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                    <!-- begin:: Header -->
                    <div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
                        <div class="kt-container">

                            <!-- begin:: Brand -->
                            <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                                @if (request()
        ->session()
        ->get('validateRole') == 'Admin')
                                    <a class="kt-header__brand-logo" href="{{ route('dashboard') }}">
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}"
                                            width="140" class="kt-header__brand-logo-default" />
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"
                                            width="140" class="kt-header__brand-logo-sticky" />
                                    </a>
                                @endif
                                @if (request()
        ->session()
        ->get('validateRole') == 'User')
                                    <a class="kt-header__brand-logo" href="{{ route('user.dashboard') }}">
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}"
                                            width="140" class="kt-header__brand-logo-default" />
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"
                                            width="140" class="kt-header__brand-logo-sticky" />
                                    </a>
                                @endif
                            </div>

                            <!-- end:: Brand -->

                            <!-- begin: Header Menu -->
                            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                                    class="la la-close"></i></button>
                            <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid"
                                id="kt_header_menu_wrapper">
                                <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                    <ul class="kt-menu__nav ">


                                    </ul>
                                </div>
                            </div>


                            <!-- end: Header Menu -->

                            <!-- begin:: Header Topbar -->
                            <div class="kt-header__topbar kt-grid__item">

                                {{-- notification component
                                --}}
                                <notification :userid="(_=>_)({{ auth()->user()->id }})"
                                    :unreads="(_=>_)({{ auth()->user()->unreadNotifications }})"
                                    :reads="(_=>_)({{ auth()->user()->readNotifications }})"></notification>

                                <!--begin: User bar -->
                                <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown"
                                        data-offset="10px,0px">
                                        <span class="kt-header__topbar-welcome">Hi,</span>
                                        <span
                                            class="kt-header__topbar-username">{{ auth()->user()->employee_id ? auth()->user()->employeeDetails->first_name : 'Admin' }}</span>
                                        <img class="header-user-image" alt="Pic"
                                            src="{{ auth()->user()->employeeDetails ? (auth()->user()->employeeDetails->profile_image ? asset('/storage/employee/img/thumbnail/' . auth()->user()->employeeDetails->profile_image) : (auth()->user()->employeeDetails->gender == 'Male' ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png') }}" />
                                        <img alt="Pic" src="{{ asset('assets/media/users/300_21.jpg') }}"
                                            class="kt-hidden" />
                                    </div>
                                    <div
                                        class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                        <!--begin: Head -->
                                        <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                            style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                                            <div class="kt-user-card__avatar">
                                                <img class="kt-hidden" alt="Pic"
                                                    src="{{ asset('assets/media/users/300_25.jpg') }}" />

                                                <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                                <img class="header-user-image" alt="Pic"
                                                    src="{{ auth()->user()->employeeDetails ? (auth()->user()->employeeDetails->profile_image ? asset('/storage/employee/img/thumbnail/' . auth()->user()->employeeDetails->profile_image) : (auth()->user()->employeeDetails->gender == 'Male' ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png') }}" />

                                            </div>
                                            <div class="kt-user-card__name">
                                                {{ auth()->user()->employee_id ? auth()->user()->employeeDetails->FullName : 'Admin' }}
                                            </div>
                                        </div>

                                        <!--end: Head -->

                                        <!--begin: Navigation -->
                                        <div class="kt-notification">
                                            <a href="javascript: void(0);" class="kt-notification__item">
                                                <div class="kt-notification__item-details">
                                                    <div class="kt-notification__item-title kt-font-bold">
                                                        Last Login :
                                                        {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() }}
                                                    </div>
                                                    <div class="kt-notification__item-time">
                                                        Last Login IP: {{ auth()->user()->last_login_ip }}
                                                    </div>
                                                </div>
                                            </a>
                                            @if (!auth()
        ->user()
        ->hasAnyRole('Super Admin'))
                                                <a href="{{ route('user.home') }}" class="kt-notification__item">
                                                    <div class="kt-notification__item-icon">
                                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                                    </div>
                                                    <div class="kt-notification__item-details">
                                                        <div class="kt-notification__item-title kt-font-bold">
                                                            My Profile
                                                        </div>
                                                        <div class="kt-notification__item-time">
                                                            Account settings and more
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif

                                            <div class="kt-notification__custom kt-space-between">
                                                @if (Auth::user()->isImpersonating())
                                                    <a href="{{ route('stopImpersonate') }}"
                                                        class="btn btn-label btn-label-brand btn-sm btn-bold">Stop
                                                        Impersonate</a>
                                                @else
                                                    @if (auth()
        ->user()
        ->hasAnyRole('Super Admin|Admin') &&
    request()
        ->session()
        ->get('validateRole') == 'User')
                                                        <a href="" data-toggle="modal" data-target="#admin_login_pass"
                                                            class="btn btn-label btn-label-brand btn-sm btn-bold">Login
                                                            as Admin</a>
                                                    @elseif(auth()->user()->hasRole('User') &&
                                                        request()->session()->get('validateRole') == 'Admin')
                                                        <a href="{{ route('user.loginAsAdmin') }}"
                                                            class="btn btn-label btn-label-brand btn-sm btn-bold">Login
                                                            as User</a>
                                                    @endif
                                                @endif
                                                <a href="{{ route('logout') }}" target="_blank"
                                                    class="btn btn-label btn-label-brand btn-sm btn-bold"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log
                                                    Out</a>
                                            </div>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>

                                        <!--end: Navigation -->
                                    </div>
                                </div>

                                <!--end: User bar -->
                            </div>

                            <!-- end:: Header Topbar -->
                        </div>
                    </div>

                    <!--begin::Modal-->
                    <div class="modal fade" id="admin_login_pass" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Switch Account:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form action="{{ route('user.loginAsAdmin') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="employee_id" value="{{ auth()->user()->id }}">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">Password:</label>
                                            <input type="password" class="form-control" id="password" autofocus
                                                name="password">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-outline-danger col-12"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-outline-primary col-12">Login as
                                                    Admin</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->

                    <div class="container hidden">
                        <div class="row pt-5 d-flex justify-content-center">
                            <div class="col-md-2 text-center">
                                <img alt="Logo" class="medals" src="{{ asset('assets/media/misc/medals.png') }}" />
                                <br>
                                <span class="award_name"><strong>
                                        Star performer
                                    </strong></span> <br>
                                <span class="award_month">Feb 2019</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <img alt="Logo" class="medals" src="{{ asset('assets/media/misc/medals.png') }}" />
                                <br>
                                <span class="award_name"><strong>
                                        Quality Auditor
                                    </strong></span> <br>
                                <span class="award_month">Mar 2019</span>
                            </div>
                        </div>
                    </div>

                    <!-- card section start -->
                    {{-- <div class="container">--}}
                        {{-- <div class="row">--}}
                            {{-- <div class="col-md-3">--}}
                                {{-- <div class="dbox dbox--color-3">
                                    --}}
                                    {{-- <div class="dbox__body">
                                        --}}
                                        {{-- <span
                                            class="dbox__count">0</span>--}}
                                        {{-- <span
                                            class="dbox__title bold">Present</span>--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                                {{-- </div>--}}
                            {{-- <div class="col-md-3">--}}
                                {{-- <div class="dbox dbox--color-3">
                                    --}}
                                    {{-- <div class="dbox__body">
                                        --}}
                                        {{-- <span
                                            class="dbox__count">{{ $total_absent }}</span>--}}
                                        {{-- <span
                                            class="dbox__title bold">Absent</span>--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                                {{-- </div>--}}
                            {{-- <div class="col-md-3">--}}
                                {{-- <div class="dbox dbox--color-3">
                                    --}}
                                    {{-- <div class="dbox__body">
                                        --}}
                                        {{-- <span
                                            class="dbox__count">{{ $total_late_entry }}</span>--}}
                                        {{-- <span class="dbox__title bold">Late
                                            Entry</span>--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                                {{-- </div>--}}
                            {{-- <div class="col-md-3">--}}
                                {{-- <div class="dbox dbox--color-3">
                                    --}}
                                    {{-- <div class="dbox__body">
                                        --}}
                                        {{-- <span
                                            class="dbox__count">{{ $total_early_leave }}</span>--}}
                                        {{-- <span class="dbox__title bold">Early
                                            Leave</span>--}}
                                        {{-- </div>--}}
                                    {{-- </div>--}}
                                {{-- </div>--}}
                            {{-- </div>--}}
                        {{-- </div>--}}
                    <!-- card section end -->


                    <!-- end:: Header -->
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
                        <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body" style="padding: 30px;">
                            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">


                                <!-- end:: Subheader -->

                                <!-- begin:: Content -->
                                <div class="container">

                                    <!--Begin::Dashboard 4-->


                                    <!--Begin::Section-->
                                    <div class="row">


                                        <div class="col-md-3 ">
                                            <div class="widget mt-0">
                                                <div class="avatar ">
                                                    <a href="{{ route('user.home') }}">
                                                        <img src="{{ auth()->user()->employeeDetails ? (auth()->user()->employeeDetails->profile_image ? asset('/storage/employee/img/' . auth()->user()->employeeDetails->profile_image) : (auth()->user()->employeeDetails->gender == 'Male' ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png') }}"
                                                            alt="User Img" />
                                                    </a>
                                                </div>
                                            </div>


                                            <!--Begin::Portlet-->
                                            {{-- <div class="kt-portlet ">
                                                --}}
                                                {{-- <div class="kt-portlet__head">
                                                    --}}
                                                    {{-- <div
                                                        class="kt-portlet__head-label">--}}
                                                        {{-- <h4
                                                            class="kt-portlet__head-title">
                                                            --}}
                                                            {{-- Profile
                                                            Completion--}}
                                                            {{-- </h4>
                                                        --}}
                                                        {{-- </div>
                                                    --}}
                                                    {{-- </div>
                                                --}}
                                                {{-- <div class="kt-portlet__body">
                                                    --}}
                                                    {{-- <div class="pieProgress"
                                                        role="progressbar" data-goal="{{ $percentage }}"
                                                        aria-valuemin="0" data-step="2" aria-valuemax="100"
                                                        style="width:100%; margin: auto">
                                                        --}}
                                                        {{-- <div
                                                            class="pie_progress__content"><span
                                                                class="pie_progress__number"></span></div>
                                                        --}}
                                                        {{-- </div>
                                                    --}}
                                                    {{-- </div>
                                                --}}
                                                {{-- </div>
                                            --}}
                                            <!--End::Portlet-->




                                            {{-- <div
                                                class="rating-summary-section d-flex justify-content-center">
                                                --}}
                                                {{-- <div class="evaluation-circle">
                                                    --}}
                                                    {{-- <h3>
                                                        --}}
                                                        {{-- <i class="fa fa-star"></i>
                                                        <br>--}}
                                                        {{--
                                                        0--}}
                                                        {{-- </h3>
                                                    --}}
                                                    {{-- <span>Last evaluation
                                                        rate</span>--}}
                                                    {{-- </div>
                                                --}}
                                                {{-- </div>
                                            --}}

                                            <div class="rating-summary-section widget">
                                                <div class="well">
                                                    {{-- <span>Account
                                                        Completed</span>--}}
                                                    <div class="progress">
                                                        <div class="progress-bar dbox--color-3 bold" role="progressbar"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100" style="width: {{ $percentage }}%;">
                                                            Account Completed - {{ $percentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="well">
                                                    {{-- <span>Performance Point</span>
                                                    --}}
                                                    <p>
                                                        <a href="#" id="showMissingFields">Click</a> to see the missing
                                                        <span class="text-danger">*</span>fields
                                                    </p>
                                                    <p style="display: none" id="missingData">
                                                        {{--
                                                        {{ implode(',', $missing_data) }}
                                                        --}}
                                                        @foreach ($missing_data as $missing)
                                                            {{-- <li>{{ $missing }}</li>
                                                            --}}
                                                            <span
                                                                class="badge badge-secondary mar-5">{{ $missing }}</span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="rating-summary-section widget">
                                                <div class="well" id="puchBox">
                                                    <h2 outTime="{{ $outTime }}" inTime="{{ $inTime }}" status="{{ isset($attendance_status) ? $attendance_status->count % 2 : 0}}" id="timer"></h2>
                                                    <p class="text-center">
                                                        @if($inTime)
                                                            <i class="fas fa-sign-in-alt"></i> {{ date('Y-m-d h:i A', strtotime($inTime)) }} <br>
                                                        @else
                                                            <p class="text-center">You forgot to check-in today</p>
                                                        @endif
                                                        @if($outTime && isset($attendance_status) && ($attendance_status->count % 2) == 0)
                                                            <i class="fas fa-sign-out-alt"></i> {{ date('Y-m-d h:i A', strtotime($outTime)) }} <br>
                                                        @endif
                                                        <form action="{{ route('user.attendance.checkin.out') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="lat" id="lat">
                                                            <input type="hidden" name="lon" id="lon">
                                                            <button type="submit" class="btn btn-sm btn-primary btn-block">
                                                                <i class="fa fa-check-in"></i> Check {{ (isset($attendance_status) && ($attendance_status->count % 2) == 1) ? 'Out' : 'In' }}
                                                            </button>
                                                        </form>
                                                    </p>
                                                </div>

                                                <div class="well" id="punchBoxError">
                                                    <p class="danger">
                                                        Please enable your browser's geo location service and reload page.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="list-group-hover sidebar-widget-1 widget">
                                                <h6 class="bold">Quick Links</h6>
                                                <ul class="list-unstyled">
                                                    <li><a href="{{ route('user.home') }}"
                                                            class="list-group-item bold"><i class="la la-user bold"></i>
                                                            My Profile</a></li>
                                                    <li><a href="{{ route('user.team.list.view') }}"
                                                            class="list-group-item bold"><i
                                                                class="la la-users bold"></i> My Team</a></li>
                                                    {{-- <li><a
                                                            href="{{ route('user.roster.revise.view') }}"
                                                            class="list-group-item bold"><i
                                                                class="flaticon-calendar-2 bold"></i> My Roster</a></li>
                                                    --}}
                                                    <li><a
                                                            href="{{ route('leave.dashboard') }}"
                                                            class="list-group-item bold"><i
                                                                class="flaticon-calendar-3 bold"></i> Attendance</a>
                                                    </li>
                                                    <li><a href="{{ route('leave.list') }}"
                                                            class="list-group-item bold"><i
                                                                class="flaticon-logout bold"></i> Leave</a></li>
                                                    {{-- <li><a href="{{ route('employee.documents.history') }}"
                                                            class="list-group-item bold"><i class="fas fa-hdd bold"></i>
                                                            Letter & Documents</a>
                                                    </li>
                                                    <li><a href="{{ route('user.closing.list') }}"
                                                            class="list-group-item bold"><i
                                                                class="fas fa-user-times bold"></i> Employee Closing</a>
                                                    </li>
                                                    <li><a href="{{ route('appraisal.history.list') }}"
                                                            class="list-group-item bold"><i
                                                                class="fas fa-chart-pie bold"></i> Performance
                                                            Review</a>
                                                    <li><a href="{{ route('manage.salary.employee.history') }}"
                                                            class="list-group-item bold"><i
                                                                class="fas fa-money-bill-alt bold"></i> Payroll</a>
                                                    </li> --}}
                                                    <li><a href="{{ route('upcomming.index') }}"
                                                           class="list-group-item bold"><i
                                                                class="fas fa-calendar-day bold"></i> Upcoming</a>
                                                    </li>
                                                    {{-- <li><a href="#" data-toggle="modal" data-target="#financialModal"
                                                            class="list-group-item bold"><i
                                                                class="fas fa-credit-card bold"></i>
                                                            Financial statement</a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="card o-hidden profile-greeting">
                                                <div class="card-body">
                                                    <div class="media">
                                                        <div class="badge-groups w-100">
                                                            <div class="badge f-12">
                                                                {{-- <svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-clock mr-1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                                </svg>--}}
                                                                    {{-- <span id="txt"><i class="fa fa-clock"></i>
                                                                    {{ date('h:i a') }}</span> --}}
                                                                </div>
                                                            {{-- <div class="badge f-12">
                                                                <i class="fa fa-spin fa-cog f-14"></i></div>
                                                            --}}
                                                        </div>
                                                    </div>
                                                    <div class="greeting-user text-center">
                                                        {{-- <div class="profile-vector">
                                                            <img class="img-fluid"
                                                                src="{{ auth()->user()->employeeDetails ? (auth()->user()->employeeDetails->profile_image ? asset('/storage/employee/img/' . auth()->user()->employeeDetails->profile_image) : (auth()->user()->employeeDetails->gender == 'Male' ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png') }}"
                                                                alt="" data-original-title="" title=""></div>
                                                        --}}
                                                        <h4 class="f-w-600">
                                                            <span id="greeting">
                                                                @php
                                                                $hour = date('H');
                                                                $dayTerm = ($hour > 17) ? "Evening" : (($hour > 12) ?
                                                                "Afternoon" : "Morning");
                                                                echo "Good " . $dayTerm .' '.
                                                                auth()->user()->employeeDetails->first_name;
                                                                @endphp
                                                            </span>
                                                            <span class="right-circle"><i
                                                                    class="fa fa-check-circle f-14 middle"></i></span>
                                                        </h4>
                                                        {{-- <p><span> You have done 57.6%
                                                                more sales today. Check your new badge in your
                                                                profile.</span></p>--}}
                                                        {{-- <div class="whatsnew-btn"><a
                                                                href="{{ route('user.home') }}" class="btn btn-primary"
                                                                data-original-title="" title="">Go to Profile</a></div>
                                                        --}}
                                                        {{-- <div class="left-icon"><i
                                                                class="fa fa-bell"> </i></div>
                                                        --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card browser-widget widget">
                                                <h5 class="pt-4 text-center">Leave Balance Remaining</h5>
                                                <div class="media card-body">

                                                    @if ($leave->count())
                                                        @php
                                                        // dd($leave);
                                                        $earnLeaveService = new
                                                        \App\Services\EarnLeaveService(auth()->user()->employeeDetails);
                                                        @endphp
                                                        {{-- <div class="media-img"><img
                                                                src="../assets/images/dashboard/chrome.png" alt=""
                                                                data-original-title="" title=""></div>
                                                        --}}

                                                        <div class="media-body align-self-center {{ (auth()->user()->employeeDetails->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION) ? "column2" : '' }}">

                                                            @foreach ($leave as $leave_type)
                                                                @if (auth()->user()->employeeDetails->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                                        @if ($leave_type->leave_type_id == \App\Utils\LeaveStatus::CASUAL || $leave_type->leave_type_id == \App\Utils\LeaveStatus::SICK)

                                                                            <div>
                                                                                <p>{{ $leave_type->leaveType->leave_type }}</p>
                                                                                <h4>


                                                                                    <span class="counter">
                                                                                        {{-- @if ($leave_type->leave_type_id == \App\Utils\LeaveStatus::EARNED)
                                                                                            {{ str_replace('.0', '', $leave_type->remain) }} --}}
                                                                                        @if($leave_type->leave_type_id == \App\Utils\LeaveStatus::CASUAL)
                                                                                            {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                                                                        @elseif($leave_type->leave_type_id == \App\Utils\LeaveStatus::SICK)
                                                                                            {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                                                                        @endif
                                                                                    </span>

                                                                                </h4>
                                                                            </div>
                                                                        @endif


                                                                @else
                                                                    @if ($leave_type->leave_type_id == \App\Utils\LeaveStatus::CASUAL || $leave_type->leave_type_id == \App\Utils\LeaveStatus::SICK || $leave_type->leave_type_id == \App\Utils\LeaveStatus::EARNED)
                                                                        <?php
                                                                            $earnLeaveService = new App\Services\EarnLeaveService(auth()->user()->employeeDetails);
                                                                        ?>
                                                                        <div>
                                                                            {{-- <p>{{ $leave_type->leaveType->leave_type }}</p> --}}
                                                                            <h4>

                                                                                <span class="counter bold">
                                                                                    {{-- {{ str_replace('.0', '', $leave_type->remain) }} --}}
                                                                                    @if($leave_type->leave_type_id == \App\Utils\LeaveStatus::CASUAL)
                                                                                        <small>{{ $leave_type->leaveType->leave_type }}</small> <br>
                                                                                        {{ str_replace('.0', '', $leave_type->remain) }}
                                                                                    @elseif($leave_type->leave_type_id == \App\Utils\LeaveStatus::SICK)
                                                                                        <small>{{ $leave_type->leaveType->leave_type }}</small> <br>
                                                                                        {{ str_replace('.0', '', $leave_type->remain) }}
                                                                                    @elseif($leave_type->leave_type_id == \App\Utils\LeaveStatus::EARNED)
                                                                                        <small>{{ $leave_type->leaveType->leave_type }}</small> <br>
                                                                                        {{ str_replace('.0', '', ($leave_type->total + $earnLeaveService->calculateEarnLeaveBalance() - $leave_type->used))  }}
                                                                                    @endif
                                                                                </span>

                                                                            </h4>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning" role="alert">
                                                            Your leave information has not been created yet. Communicate
                                                            with your team lead.
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="card widget">
                                                <div class="card-body p-0">
                                                    {{-- <div class="mb-5 card-title">Activity</div> --}}
                                                    <h5 class="mb-4">Events</h5>
                                                    @if($events->count())

                                                    <ul class="verti-timeline list-unstyled">
                                                        @foreach ($events as $event)
                                                        <li class="event-list">
                                                            <div class="event-timeline-dot"><i
                                                                    class="far fa-arrow-alt-circle-right font-size-18"></i>
                                                            </div>
                                                            <div class="media">
                                                                <div class="mr-3 mt-2 ">
                                                                    <h6 class="font-size-14">{{ \Carbon\Carbon::parse($event->event_date)->format('d M y') }} <i
                                                                            class="fas fa-long-arrow-alt-right font-size-16 text-primary align-middle ml-2"></i>
                                                                    </h6>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="mt-2 "><a href="{{ route('employee.notice.board') }}">{{ $event->title }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @else
                                                        No event available
                                                    @endif
                                                    <div class="text-center mt-4"><a style="color: #1b55e2;" href="{{ route('employee.notice.board') }}"
                                                        class="btn bold">View All <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-chevron-down">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg></a>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="card browser-widget widget">
                                                <h5 class="pt-4 text-center">Attendance ({{ now()->format('M')}})</h5>
                                                <div class="media card-body">
                                                        {{-- <div class="media-img"><img
                                                                src="../assets/images/dashboard/chrome.png" alt=""
                                                                data-original-title="" title=""></div>
                                                        --}}
                                                        <div class="media-body align-self-center">
                                                                    <div>
                                                                        <p>Presents</p>
                                                                        <h4>
                                                                            <span class="counter bold">{{ $total_present }}</span>
                                                                        </h4>
                                                                    </div>

                                                                    <div>
                                                                        <p>Absents</p>
                                                                        <h4>
                                                                            <span class="counter bold">{{ $total_absent }}</span>
                                                                        </h4>
                                                                    </div>

                                                                    <div>
                                                                        <p>Half Days</p>
                                                                        <h4>
                                                                            <span class="counter bold">{{ $half_day }}</span>
                                                                        </h4>
                                                                    </div>

                                                        </div>

                                                </div>
                                            </div>




                                        </div>

                                        <div class="col-md-4">
                                            <!--Begin::Portlet-->
                                            {{-- <div
                                                class="kt-portlet kt-portlet--height-fluid">
                                                --}}
                                                {{-- <div class="kt-portlet">
                                                    --}}
                                                    {{-- <div class="kt-portlet__head">
                                                        --}}
                                                        {{-- <div
                                                            class="kt-portlet__head-label">
                                                            --}}
                                                            {{-- <h4
                                                                class="kt-portlet__head-title notice-title">
                                                                --}}
                                                                {{-- Notice &
                                                                Events--}}
                                                                {{-- </h4>
                                                            --}}
                                                            {{-- </div>
                                                        --}}
                                                        {{-- </div>
                                                    --}}
                                                    {{-- <div
                                                        class="kt-portlet__body notice-body">
                                                        --}}
                                                        {{--
                                                        <!--Begin::Timeline 3 -->--}}
                                                        {{-- <div class="kt-timeline-v2">
                                                            --}}
                                                            {{-- <div
                                                                class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                                                                --}}

                                                                {{-- @foreach ($calendarDataset as $notice)
                                                                    --}}

                                                                    {{-- <div
                                                                        class="kt-timeline-v2__item">
                                                                        --}}
                                                                        {{-- <span
                                                                            class="kt-timeline-v2__item-time"
                                                                            --}}
                                                                            {{--
                                                                            style="font-size: 10px">{{ \Carbon\Carbon::parse($notice->event_date)->format('d/m/Y') }}</span>--}}
                                                                        {{-- <div
                                                                            class="kt-timeline-v2__item-cricle">
                                                                            --}}
                                                                            {{-- <i
                                                                                class="fa fa-genderless kt-font-primary"></i>--}}
                                                                            {{-- </div>
                                                                        --}}
                                                                        {{-- <div
                                                                            class="kt-timeline-v2__item-text  kt-padding-top-5"
                                                                            style="font-size: 10px">
                                                                            --}}
                                                                            {{-- <a
                                                                                href="{{ route('employee.notice.board') }}">{{ $notice->title }}</a>--}}
                                                                            {{-- </div>
                                                                        --}}
                                                                        {{-- </div>
                                                                    --}}

                                                                    {{-- </beautify
                                                                    end="@endfor">each--}}

                                                                {{-- </div>
                                                            --}}
                                                            {{-- </div>
                                                        --}}
                                                        {{--
                                                        <!--End::Timeline 3 -->--}}
                                                        {{-- </div>
                                                    --}}
                                                    {{-- </div>
                                                --}}
                                                <!--End::Portlet-->

                                                <div class="cal-datepicker">
                                                    <div class="datepicker-here float-right" data-language="en"></div>
                                                </div>

                                                <div class="layout-spacing">

                                                    <div class="widget widget-activity-four">

                                                        <div class="widget-heading">
                                                            <h5 class="">Notice</h5>
                                                        </div>

                                                        <div class="widget-content">

                                                            <div class="mt-container mx-auto ps ps--active-y">
                                                                <div class="timeline-line">

                                                                    @php
                                                                    $classes = ['success', 'dark', 'danger', 'warning',
                                                                    'secondary', 'primary'];
                                                                    @endphp
                                                                    @if($notices->count())
                                                                    @foreach ($notices as $notice)
                                                                        <div
                                                                            class="item-timeline timeline-{{ $classes[array_rand($classes)] }}">
                                                                            <div class="t-dot" data-original-title=""
                                                                                title="">
                                                                            </div>
                                                                            <div class="t-text">
                                                                                <p><span><a
                                                                                            href="{{ route('employee.notice.board') }}">{{ $notice->title }}</a></span>
                                                                                </p>
                                                                                <span
                                                                                    class="badge badge-dark">{{ \Carbon\Carbon::parse($notice->event_date)->format('d-m-Y') }}</span>
                                                                                <p class="t-time">
                                                                                    {{ \Carbon\Carbon::parse($notice->event_date)->diffForHumans() }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                    @else
                                                                        No notice available
                                                                    @endif

                                                                </div>
                                                                <div class="ps__rail-x"
                                                                    style="left: 0px; bottom: -256px;">
                                                                    <div class="ps__thumb-x" tabindex="0"
                                                                        style="left: 0px; width: 0px;"></div>
                                                                </div>
                                                                <div class="ps__rail-y"
                                                                    style="top: 256px; height: 272px; right: 0px;">
                                                                    <div class="ps__thumb-y" tabindex="0"
                                                                        style="top: 132px; height: 140px;"></div>
                                                                </div>
                                                            </div>

                                                            <div class="tm-action-btn">
                                                                <a href="{{ route('employee.notice.board') }}"
                                                                    class="btn">View All <svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-chevron-down">
                                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                                    </svg></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>






                                            </div>

                                            <!--End::Section-->







                                            <!--End::Dashboard 4-->
                                        </div>


                                        <!-- chart panel -->
                                    </div>


                                    <!-- end:: Content -->
                                </div>
                            </div>
                        </div>

                        <!-- begin:: Footer -->
                        <div class="kt-footer  kt-footer--extended  kt-grid__item" id="kt_footer"
                            style="background-image: url('{{ asset('assets/media/bg/footer.jpg') }}');">
                            <div class="kt-footer__bottom">
                                <div class="kt-container">
                                    <div class="kt-footer__wrapper">
                                        <div class="kt-footer__logo">
                                            <a class="kt-header__brand-logo" href="/">
                                                <img alt="Logo"
                                                    src="{{ asset('assets/media/company-logos/logo-2-white.png') }}"
                                                    width="140" class="kt-header__brand-logo-sticky">
                                            </a>
                                            <div class="kt-footer__copyright text-white">
                                                {{ Date('Y') }}&nbsp;&copy;&nbsp;
                                                <a class="text-white" href="https://www.genexinfosys.com/"
                                                    target="_blank">Genex Infosys Limited</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end:: Footer -->
                    </div>
                </div>
            </div>
            <!-- end:: Page -->

            <!-- end::Quick Panel -->

            <!-- begin::Scrolltop -->
            <div id="kt_scrolltop" class="kt-scrolltop">
                <i class="fa fa-arrow-up"></i>
            </div>

            <div class="modal fade" id="financialModal" tabindex="-1" role="dialog"
                aria-labelledby="financialModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="financialModalLabel">Financial Statement Summary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <table class="table">
                                <tr>
                                    <td>Tax deduction</td>
                                    <td>${{ isset($tax_amount) ? $tax_amount : '0' }}</td>
                                </tr>
                                <tr>
                                    <td>PF deduction</td>
                                    <td>${{ isset($pf_balance) ? $pf_balance : '0' }}</td>
                                </tr>
                                <tr>
                                    <td>EMI</td>
                                    <td>${{ $emi_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Other deduction</td>
                                    <td>${{ isset($deduction_amount) ? $deduction_amount : '0' }}</td>
                                </tr>
                                <tr>
                                    <td>Other addition</td>
                                    <td>${{ isset($addition_amount) ? $addition_amount : '0' }}</td>
                                </tr>
                                <tr>
                                    <td>Bonus</td>
                                    <td>${{ isset($bonus_amount) ? $bonus_amount : '0' }}</td>
                                </tr>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end::Scrolltop -->

        <!-- begin::Global Config(global config for global JS sciprts) -->

        <script src="{{ asset('js/app.js') }}"></script>
        <!--begin:: Global Mandatory Vendors -->
        {{-- <script src="{{ asset('assets/vendors/general/jquery/dist/jquery.js') }}"
            type="text/javascript"></script>--}}
        <script src="{{ asset('assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.j') }}s" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}"
            type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript">
        </script>
        <script src="{{ asset('assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
        {{-- <script src="http://admin.pixelstrap.com/cuba/assets/js/datepicker/date-picker/datepicker.js" type="text/javascript"></script> --}}
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"  type="text/javascript"></script>--}}
        <script src="{{asset('js/datepicker.min.js')}}"  type="text/javascript"></script>

        {{--<script
            src="https://cdn.jsdelivr.net/npm/jquery-asPieProgress@0.4.7/dist/jquery-asPieProgress.min.js"></script>
        --}}
        <script src="{{ asset('assets/vendors/general/jquery-asPieProgress/dist/jquery-asPieProgress.min.js') }}">
        </script>
        <!--Morris -->
        {{-- <script src="{{ asset('assets/vendors/general/morris.js/morris.js') }}"
            type="text/javascript"></script>--}}

        <!--end:: Global Mandatory Vendors -->

        <!--begin::Global Theme Bundle(used by all pages) -->

        {{--<script src="{{ asset('assets/js/demo4/scripts.bundle.js') }}"
            type="text/javascript"></script>--}}
        <script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>
        <!--end::Global Theme Bundle -->

        <script>
            // jQuery(function($) {
            $('.pieProgress').asPieProgress({
                namespace: '',
                classes: {
                    svg: 'pie_progress__svg',
                    element: 'pie_progress',
                    number: 'pie_progress__number',
                    content: 'pie_progress__content'
                },
                barcolor: '#782B90',
                barsize: '6',
                speed: 40, // speed of 1/100
                size: 160,
                easing: 'ease',
            });

            // });

            $(document).ready(function() {
                $('.pieProgress').asPieProgress('start');
                $('#showMissingFields').on('click', function(e) {
                    // alert('asd');
                    e.preventDefault();
                    $('#missingData').toggle();
                })


            });

            "use strict";
            ;(function ($) { $.fn.datepicker.language['en'] = {
                days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                daysShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                daysMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
                months: ['January','February','March','April','May','June', 'July','August','September','October','November','December'],
                monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                today: 'Today',
                clear: 'Clear',
                dateFormat: 'mm/dd/yyyy',
                timeFormat: 'hh:ii aa',
                firstDay: 0
            }; })(jQuery);

            "use strict";
            (function($) {
                "use strict";
            //Minimum and Maxium Date
                $('#minMaxExample').datepicker({
                    language: 'en',
                    minDate: new Date() // Now can select only dates, which goes after today
                })

            //Disable Days of week
                var disabledDays = [0, 6];

                $('#disabled-days').datepicker({
                    language: 'en',
                    onRenderCell: function (date, cellType) {
                        if (cellType == 'day') {
                            var day = date.getDay(),
                                isDisabled = disabledDays.indexOf(day) != -1;
                            return {
                                disabled: isDisabled
                            }
                        }
                    }
                })
            })(jQuery);

        </script>


        <script>

            if($('#timer').attr('inTime')){

                let inTime = $('#timer').attr('inTime');
                let outTime = $('#timer').attr('outTime');
                // Set the date we're counting down to
                var countDownDate = new Date(inTime).getTime();

                // Update the count down every 1 second
                var x = setInterval(function() {
                if($('#timer').attr('outTime')){
                    var now = new Date(outTime).getTime();
                } else {
                    // Get today's date and time
                    var now = new Date().getTime();
                }

                // Find the distance between now and the count down date
                var distance = now - countDownDate;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // alert($('#timer').attr('timer'));
                // Output the result in an element with id="demo"
                document.getElementById("timer").innerHTML = hours + "h "
                + minutes + "m " + seconds + "s ";

                }, 1000);
            }
        </script>

        <script>
            function showPosition(position) {
                // console.log(position);
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;
                document.getElementById('lat').value = lat;
                document.getElementById('lon').value = lon;
            }

            $(document).ready(function(){
                $('#punchBoxError').hide();
                navigator.geolocation.watchPosition(function(position) {
                    $('#punchBoxError').hide();
                    $('#puchBox').show();
                    if (navigator.geolocation.getCurrentPosition) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    }
                },
                function(error) {
                    if (error.code == error.PERMISSION_DENIED) {
                        $('#puchBox').hide();
                        $('#punchBoxError').show();
                    }

                });
            })
        </script>
</body>
@toastr_render
<!-- end::Body -->

</html>


@push('css')
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box
        }

        body {
            font-family: 'Open Sans Condensed', sans-serif;
            color: #111;
            margin: 24px 0;
            padding: 0;
            font-size: 12px;
            line-height: 18px
        }

        h1 {
            text-align: center;
        }

        ul.icon_buttons {
            list-style: none;
            margin: 0;
            text-align: center
        }

        ul.icon_buttons li {
            display: inline-block;
            margin: 0 12px;
            vertical-align: top;
            height: 112px;
            overflow: hidden
        }

        ul.icon_buttons li.ibtn {
            -webkit-border-radius: 12px;
            -moz-border-radius: 12px;
            -ms-border-radius: 12px;
            -o-border-radius: 12px;
            border-radius: 12px;
            border: 6px solid #fff;
            -webkit-transition: all 300ms linear;
            -moz-transition: all 300ms linear;
            -o-transition: all 300ms linear;
            -ms-transition: all 300ms linear;
            transition: all 300ms linear
        }

        ul.icon_buttons li.ibtn:hover {
            border: 6px solid rgba(255, 255, 255, .4)
        }

        ul.icon_buttons li.ibtn a {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADYAAAA3CAYAAABHGbl4AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxQjk2QjM3NDgyMDUxMUUzOTRENUU5MkFCQ0ZEMDZCMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4RjYxQTkzQzgyNzYxMUUzOTRENUU5MkFCQ0ZEMDZCMSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjFCOTZCMzcyODIwNTExRTM5NEQ1RTkyQUJDRkQwNkIxIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjFCOTZCMzczODIwNTExRTM5NEQ1RTkyQUJDRkQwNkIxIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+nI7OZQAAAqFJREFUeNrcmt1LFFEYxs+u+VEEpqWISaiQGlshgphKKhhoikrq39B/FZhJJhJ06Z144Y1eGEpYCBJeJ6JGWbk7Pq++B8ZtXWd3z5w98z7wXO04s795z5734xjzPO+1ulopOK6y6x88A3vKIcUL/JxUCj9Vjilu6D5dcKVEMNKU4fs5A3YD7pAIphjsjkQwvSRLJIKV8GYiDoz0GK6WCEaa5A1FHBjdu1ciGKkVrpEIRprgskscGD1jQCIYqQmukwhGGoPLJYLF4BcSwUj34QaJYKSXcIUNsDXLYLQkR2yAfYY/8OzClu7xThne2/M8z/8mE3CPRcA5+FfYYFq34VfwTQtgR7xarID567x+C3DL8I5NMNItTqxhT6Dewz9tgmk1h5xcT+B3yuDQNWge2+UH/wgJjPLao2JEzK8H8BDvoqY1Dx8XC0xxMTsYQnlk7BwgXzCtenjUcPTWuGgoKhipDO7jDcaUFuDDYoNp1cLjhgrrU16SKRfASDRu6+XkXqg24HVXwLTucllWaPQW4QOXwHT0OuEnBdwjyUsy6RKYVpW6mArne1DxBV51EUxXOB0q//Ozj/C+i2BaVExPqdxn+ilekqeuguno0WnMsxz/bodbHKNFsEnR29/kujCXccRDzpXORuzS8+E2+HnA6+nLvoX/uhix9C+6zY1mMuCLGHB1KWYSdc9v4O8Brm3k4tvppZhJlNC7A0R6Fv7jesT82oI/XdOTxbjZjVTE/C+dIpfIcs0SvBc1MH87NJGlmaVZzO8ogunotXBDm659Lrmc/41dldS/chuTqUVqjmrE/KLR+7D6/78RLp0DRBFMqyUtWR9zmRZ5MBINkuh8QR9JrcDfJID526FpbmbPzwGkgOmNsJ3z3pwkMC2KWuxMgAEAKS2xwpG5cnUAAAAASUVORK5CYII=) no-repeat top left;
            display: inline-block;
            width: 100px;
            height: 100px;
            line-height: 100px;
            text-decoration: none;
            -webkit-transition: all 300ms linear;
            -moz-transition: all 300ms linear;
            -o-transition: all 300ms linear;
            -ms-transition: all 300ms linear;
            transition: all 300ms linear;
            overflow: hidden;
            position: relative
        }

        ul.icon_buttons li.ibtn_events {
            background-color: #73c5ed
        }

        ul.icon_buttons li.ibtn_heroes {
            background-color: #b5dac8
        }

        ul.icon_buttons li.ibtn_resources {
            background-color: #8d83b7
        }

        ul.icon_buttons li.ibtn_blogs {
            background-color: #f09ba0
        }

        ul.icon_buttons li.ibtn_forums {
            background-color: #f5c887
        }

        ul.icon_buttons li.ibtn_news {
            background-color: #c8bc94
        }

        ul.icon_buttons li:active.ibtn_events {
            background-color: #5b9bba
        }

        ul.icon_buttons li:active.ibtn_heroes {
            background-color: #8aa698
        }

        ul.icon_buttons li:active.ibtn_resources {
            background-color: #675f85
        }

        ul.icon_buttons li:active.ibtn_blogs {
            background-color: #bd7b7f
        }

        ul.icon_buttons li:active.ibtn_forums {
            background-color: #c29d6b
        }

        ul.icon_buttons li:active.ibtn_news {
            background-color: #948b6d
        }

        ul.icon_buttons li.ibtn a .icon {
            display: inline-block;
            font-size: 54px;
            color: #fff;
            -webkit-transition: all 300ms linear;
            -moz-transition: all 300ms linear;
            -o-transition: all 300ms linear;
            -ms-transition: all 300ms linear;
            transition: all 300ms linear;
            width: 100px;
            height: 100px;
            overflow: hidden
        }

        ul.icon_buttons li.ibtn:hover a .icon {
            font-size: 0;
            transform: rotate(359deg);
            -moz-transform: rotate(359deg);
            -ms-transform: rotate(359deg);
            -webkit-transform: rotate(359deg);
            -o-transform: rotate(359deg);
            opacity: .8;
            filter: alpha(opacity=80)
        }

        ul.icon_buttons li.ibtn a .icon_text {
            display: block;
            width: 100px;
            height: 100px;
            position: absolute;
            top: 0;
            font-size: 0;
            font-family: 'Open Sans Condensed', sans-serif;
            color: #fff;
            text-transform: uppercase;
            font-weight: 700;
            -webkit-transition: all 300ms linear;
            -moz-transition: all 300ms linear;
            -o-transition: all 300ms linear;
            -ms-transition: all 300ms linear;
            transition: all 300ms linear
        }

        ul.icon_buttons li.ibtn:hover a .icon_text {
            font-size: 18px
        }

        ul.icon_buttons li.ibtn a .icon i.fa.fa-calendar,
        ul.icon_buttons li.ibtn a .icon i.fa.fa-lightbulb-o,
        ul.icon_buttons li.ibtn a .icon i.fa.fa-comments {
            position: relative;
            top: -4px
        }

    </style>
@endpush
