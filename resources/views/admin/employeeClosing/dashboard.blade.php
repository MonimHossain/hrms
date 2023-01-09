{{--<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- begin::Head -->
<head>

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="/">

    <!--end::Base Path -->
    <meta charset="utf-8"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            },
            active: function () {
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
    <link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/socicon/css/socicon.css" rel="stylesheet') }}" type="text/css"/>
    <link href="{{ asset('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/custom/vendors/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
    <!--end:: Global Mandatory Vendors -->

    <!--start:: google chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!--Morris -->
    <link href="{{ asset('assets/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css"/>


    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/css/demo4/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}"/>

    <!-- <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script> -->

    <style>
        canvas {
            height: 200px !important;
        }
    </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url({{ asset('assets/media/demos/demo4/header.jpg') }}); background-position: center top; background-size: 100% 235px;"
      class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<div id="app">
    <!-- begin::Page loader -->

    <!-- end::Page Loader -->

    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="/dashboard">
                <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"/>
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
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
                            <a class="kt-header__brand-logo" href="{{ route('dashboard') }}">
                                <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}" width="140" class="kt-header__brand-logo-default"/>
                                <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}" width="140" class="kt-header__brand-logo-sticky"/>
                            </a>
                        </div>

                        <!-- end:: Brand -->

                        <!-- begin: Header Menu -->
                        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                        <!-- end: Header Menu -->

                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar kt-grid__item">
                            --}}{{-- notification component --}}{{--
                            <notification :userid="(_=>_)({{ auth()->user()->id }})" :unreads="(_=>_)({{ auth()->user()->unreadNotifications }})"
                                          :reads="(_=>_)({{ auth()->user()->readNotifications }})"></notification>

                            <!--begin: User bar -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                    <span class="kt-header__topbar-welcome">Hi,</span>

                                    <span class="kt-header__topbar-username">{{ (auth()->user()->employee_id) ? auth()->user()->employeeDetails->first_name : 'Admin' }}</span>
                                    <img class="header-user-image" alt="Pic"
                                         src="{{ (auth()->user()->employeeDetails) ? ((auth()->user()->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.auth()->user()->employeeDetails->profile_image) : ((auth()->user()->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"/>
                                    <img alt="Pic" src="{{ asset('assets/media/users/300_21.jpg') }}" class="kt-hidden"/>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                    <!--begin: Head -->
                                    <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                         style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
                                        <div class="kt-user-card__avatar">
                                            <img class="kt-hidden" alt="Pic" src="{{ asset('assets/media/users/300_25.jpg') }}"/>

                                            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                            <img class="header-user-image" alt="Pic"
                                                 src="{{ (auth()->user()->employeeDetails) ? ((auth()->user()->employeeDetails->profile_image) ? asset('/storage/employee/img/thumbnail/'.auth()->user()->employeeDetails->profile_image) : ((auth()->user()->employeeDetails->gender == 'Male') ? asset('/assets/media/users/default_male.png') : asset('/assets/media/users/default_female.png'))) : asset('/assets/media/users/default_male.png')}}"/>

                                        </div>
                                        <div class="kt-user-card__name">
                                            {{ (auth()->user()->employee_id) ? auth()->user()->employeeDetails->FullName : 'Admin' }}
                                            <br>
                                            <span class="form-text text-muted">test</span>
                                        </div>
                                    </div>

                                    <!--end: Head -->

                                    <!--begin: Navigation -->
                                    <div class="kt-notification">
                                        <a href="javascript: void(0);" class="kt-notification__item">
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title kt-font-bold">
                                                    Last Login : {{ \Carbon\Carbon::parse(auth()->user()->last_login_at)->diffForHumans() }}
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    Last Login IP: {{ auth()->user()->last_login_ip }}
                                                </div>
                                            </div>
                                        </a>
                                        @role('Super Admin')
                                        <a href="{{ route('super.admin.change.password') }}" class="kt-notification__item">
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title kt-font-bold">
                                                    Change Super Admin Password
                                                </div>
                                            </div>
                                        </a>
                                        @endrole
                                        @if(!auth()->user()->hasAnyRole('Super Admin'))
                                            <a href="{{route('employee.profile', ['id' => auth()->user()->employee_id])}}" class="kt-notification__item">
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
                                            @if(auth()->user()->hasAnyRole('Super Admin|Admin') && request()->session()->get('validateRole') == 'User')
                                                <a href="" data-toggle="modal" data-target="#kt_modal_4" class="btn btn-label btn-label-brand btn-sm btn-bold">Login as Admin</a>
                                            @elseif(auth()->user()->hasRole('User') && request()->session()->get('validateRole') == 'Admin')
                                                <a href="{{ route('user.loginAsAdmin') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Login as User</a>
                                            @endif
                                            <a href="{{ route('logout') }}" target="_blank" class="btn btn-label btn-label-brand btn-sm btn-bold"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                                        </div>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                <!-- card section start -->
                <div class="container">
                    --}}{{--<div class="row">
                        <div class="col-md-3">
                            <div class="dbox dbox--color-3">
                                <div class="dbox__body">
                                    <span class="dbox__count">{{ $stat['total_employee'] }}</span>
                                    <span class="dbox__title">Total Employee</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dbox dbox--color-3">
                                <div class="dbox__body">
                                    <span class="dbox__count">{{ $stat['total_process'] }}</span>
                                    <span class="dbox__title">Business Processes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dbox dbox--color-3">
                                <div class="dbox__body">
                                    <span class="dbox__count">{{ $stat['total_new_joiner'] }}</span>
                                    <span class="dbox__title">New Joiner MTD</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dbox dbox--color-3">
                                <div class="dbox__body">
                                    <span class="dbox__count">{{ $stat['total_closing'] }}</span>
                                    <span class="dbox__title">Total Closing</span>
                                </div>
                            </div>
                        </div>
                    </div>--}}{{--
                </div>
                <!-- card section end -->

                <!-- end:: Header -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
                    <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">

                                <!-- chart panel -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        Gender Ratio
                                                    </h3>
                                                </div>
                                                <div class="kt-widget18__content">
                                                    {!! $genderRatio->container() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!--begin:: Widgets/Revenue Change-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        New Joiner
                                                    </h3>

                                                </div>
                                                <div class="kt-widget14__content">
                                                    {!! $departmentHeadCount->container() !!}
                                                </div>
                                            </div>
                                            <!--end:: Widgets/Revenue Change-->
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        Gender Ratio
                                                    </h3>
                                                </div>
                                                <div class="kt-widget18__content">
                                                    {!! $genderRatio->container() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!--begin:: Widgets/Revenue Change-->
                                        <div class="kt-portlet kt-portlet--height-fluid">
                                            <div class="kt-widget14">
                                                <div class="kt-widget14__header">
                                                    <h3 class="kt-widget14__title">
                                                        New Joiner
                                                    </h3>

                                                </div>
                                                <div class="kt-widget14__content">
                                                    {!! $departmentHeadCount->container() !!}
                                                </div>
                                            </div>
                                            <!--end:: Widgets/Revenue Change-->
                                        </div>
                                    </div>






                             </div>
                            <!-- End chart panel-->
                            </div>
                            <!-- end:: Content -->
                        </div>
                    </div>
                </div>

                <!-- begin:: Footer -->
                <div class="kt-footer  kt-footer--extended  kt-grid__item" id="kt_footer" style="background-image: url('{{ asset("assets/media/bg/footer.jpg")}}');">
                    <div class="kt-footer__bottom">
                        <div class="kt-container">
                            <div class="kt-footer__wrapper">
                                <div class="kt-footer__logo">
                                    <a class="kt-header__brand-logo" href="/">
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}" width="140" class="kt-header__brand-logo-sticky">
                                    </a>
                                    <div class="kt-footer__copyright text-white">
                                        {{ Date('Y') }}&nbsp;&copy;&nbsp;
                                        <a class="text-white" href="https://www.genexinfosys.com/" target="_blank">Genex Infosys Limited</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- end:: Footer -->
            </div>
        </div>


    <!-- end:: Page -->

    <!-- end::Quick Panel -->

    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

</div>

<!-- end::Scrolltop -->

<!-- begin::Global Config(global config for global JS sciprts) -->

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/JQuery.ShortcutKeys-1.0.0.js') }}" ></script>

<!--begin:: Global Mandatory Vendors -->
<script src="{{ asset('assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.j') }}s" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>

<!--Morris -->
--}}{{--        <script src="{{ asset('assets/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>--}}{{--

<!--end:: Global Mandatory Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->

--}}{{--<script src="{{ asset('assets/js/demo4/scripts.bundle.js') }}" type="text/javascript"></script>--}}{{--
<script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/demo4/pages/dashboard.js') }}" type="text/javascript"></script>
--}}{{--		<script src="{{ asset('assets/js/demo1/pages/components/charts/morris-charts.js') }}" type="text/javascript"></script>--}}{{--
<!--end::Page Scripts -->

--}}{{-- laravel charts scripts --}}{{--

{!! $genderRatio->script() !!}
{!! $departmentHeadCount->script() !!}



--}}{{--<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>--}}{{--




</body>
@toastr_render
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

        ul.icon_buttons li.ibtn a .icon i.fa.fa-calendar, ul.icon_buttons li.ibtn a .icon i.fa.fa-lightbulb-o, ul.icon_buttons li.ibtn a .icon i.fa.fa-comments {
            position: relative;
            top: -4px
        }
    </style>
@endpush--}}


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
                                Employee Closing Dashboard
                            </h3>
                        </div>
                        <span class="pull-right">
                    </span>
                    </div>

                    {{-- // TODO Leave Dashboard --}}

                    <form class="kt-form  p-5" action="" method="get">
                        {{-- @csrf --}}
                        {{--<div class="row">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>Month</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly placeholder="Select Month"
                                               id="month-pick" name="month" value="{{ $month }}" />
                                        <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>year</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly placeholder="Select Year"
                                               id="year-pick" name="year" value="{{ $year }}" />
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
                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </form>

                    <!-- card section start -->


                    <!-- card section end -->

                    <!-- chart panel -->
                    <div class="container">
                        <div class="pt-5 row">

                            <div class="col-sm-6">
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                Male vs Female Employee Seperation
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__text">
                                                {!! $genderRatio->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                Exit Interview
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget19__wrapper">
                                            <div class="kt-widget19__text">
                                                {!! $exitInterview->container() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <div class="pt-5 row">
                        <div class="col-sm-6">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Separation Type
                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="kt-widget19__wrapper">
                                        <div class="kt-widget19__text">
                                            {!! $separationType->container() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Reason for separation
                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="kt-widget19__wrapper">
                                        <div class="kt-widget19__text">
                                            {!! $separationReason->container() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>


                    <div class="pt-5 row">
                        <div class="col-sm-6">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Highest Mark parameter (5)
                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="kt-widget19__wrapper">
                                        <ol>
                                            @foreach($highestExitInterviewQuestion as $row)
                                            <li>{{ $row->name }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Lowest Mark parameter (5)
                                        </h3>
                                    </div>
                                </div>
                                <div class="kt-portlet__body">
                                    <div class="kt-widget19__wrapper">
                                        <div class="kt-widget19__text">
                                            <div class="kt-widget19__wrapper">
                                                <ol>
                                                    @foreach($lowestExitInterviewQuestion as $row)
                                                        <li>{{ $row->name }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}"
    rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script> --}}

@endpush

@push('js')

    <script>
        Chart.pluginService.register({
            beforeRender: function (chart) {
                if (chart.config.options.showAllTooltips) {
                    // create an array of tooltips
                    // we can't use the chart tooltip because there is only one tooltip per chart
                    chart.pluginTooltips = [];
                    chart.config.data.datasets.forEach(function (dataset, i) {
                        chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                            chart.pluginTooltips.push(new Chart.Tooltip({
                                _chart: chart.chart,
                                _chartInstance: chart,
                                _data: chart.data,
                                _options: chart.options.tooltips,
                                _active: [sector]
                            }, chart));
                        });
                    });

                    // turn off normal tooltips
                    chart.options.tooltips.enabled = false;
                }
            },
            afterDraw: function (chart, easing) {
                if (chart.config.options.showAllTooltips) {
                    // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
                    if (!chart.allTooltipsOnce) {
                        if (easing !== 1)
                            return;
                        chart.allTooltipsOnce = true;
                    }

                    // turn on tooltips
                    chart.options.tooltips.enabled = true;
                    Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                        tooltip.initialize();
                        tooltip.update();
                        // we don't actually need this since we are not animating tooltips
                        tooltip.pivot();
                        tooltip.transition(easing).draw();
                    });
                    chart.options.tooltips.enabled = false;
                }
            }
        });

    </script>

    {!! $genderRatio->script() !!}
    {!! $exitInterview->script() !!}
    {!! $separationType->script() !!}
    {!! $separationReason->script() !!}


    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script>
    --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript">
    </script>
    {{--        <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"
    type="text/javascript"></script>--}}

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

        // enable clear button
        $('.kt_datepicker_3').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            showOn: 'none',
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm-dd',
        });

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

