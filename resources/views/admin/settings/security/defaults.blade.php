<!DOCTYPE html>
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
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body style="background-image: url({{ asset('assets/media/demos/demo4/header.jpg') }}); background-position: center top; background-size: 100% 80px;"
      class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

<!-- begin::Page loader -->

<!-- end::Page Loader -->

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="app">
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="/dashboard">
                <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"/>
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
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
                        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                <ul class="kt-menu__nav ">


                                </ul>
                            </div>
                        </div>


                        <!-- end: Header Menu -->

                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar kt-grid__item">

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
                                        </div>
                                    </div>

                                    <!--end: Head -->

                                    <!--begin: Navigation -->
                                    <div class="kt-notification">
                                        <a href="{{route('employee.profile', ['id' => auth()->user()->id])}}" class="kt-notification__item">
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

                    <div class="container pt-5">
                        <div class="row justify-content-md-center">
                            <div class="col-md-3">
                                <form class="center-division-form" action="{{ route('set.default.center.division') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="division">Choose Default Division</label>
                                        <select class="form-control division" id="" name="division_id" required>
                                            <option value="">Select Division</option>
                                            @foreach($divisions as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('division_id')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="center">Choose Default Center</label>
                                        <select class="form-control center" id="" name="center_id" required>
                                            <option value="">Select Center</option>
                                        </select>
                                        @error('center_id')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Set Default" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- begin:: Footer -->
                <div class="kt-footer  kt-footer--extended  kt-grid__item" id="kt_footer"
                     style="position :absolute;bottom: 0;width: 100%; background-image: url('{{ asset("assets/media/bg/footer.jpg")}}');">
                    <div class="kt-footer__bottom">
                        <div class="kt-container">
                            <div class="kt-footer__wrapper">
                                <div class="kt-footer__logo">
                                    <a class="kt-header__brand-logo" href="/">
                                        <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2-white.png') }}" width="140" class="kt-header__brand-logo-sticky">
                                    </a>
                                    <div class="kt-footer__copyright text-white">
                                        2019&nbsp;&copy;&nbsp;
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
    </div>
</div>
<!-- end:: Page -->

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<!-- Scripts -->

<script src="{{ asset('js/app.js') }}"></script>

<!--begin:: Global Mandatory Vendors -->
{{--		<script src="{{ asset('assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>--}}
<script src="{{ asset('assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.j') }}s" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>


<!--end:: Global Mandatory Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->

<script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/demo4/pages/dashboard.js') }}" type="text/javascript"></script>
<!--end::Page Scripts -->
@include('layouts.partials.includes.division-center')

<script>
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

        ul.icon_buttons li.ibtn a .icon i.fa.fa-calendar, ul.icon_buttons li.ibtn a .icon i.fa.fa-lightbulb-o, ul.icon_buttons li.ibtn a .icon i.fa.fa-comments {
            position: relative;
            top: -4px
        }
    </style>
@endpush


