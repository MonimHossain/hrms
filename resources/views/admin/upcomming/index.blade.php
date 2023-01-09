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
                                Upcomming Events
                            </h3>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="kt-portlet__body">
                                    <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-success"
                                        role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->all()) ? '' : 'active' }} {{ (request()->get('pending')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_1" role="tab">Birthday</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->get('approved')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_2" role="tab">Work Anniversary</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->get('rejected')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_3" role="tab">Events</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->get('cancelled')) ? 'active' : ''  }}" data-toggle="tab" href="#kt_tabs_6_4" role="tab">Holiday</a>
                                        </li>
                                    </ul>
                                    <!-- Birthday -->
                                    <div class="tab-content">
                                        <div class="tab-pane {{ (request()->all()) ? '' : 'active' }} {{ (request()->get('pending')) ? 'active' : ''  }}" id="kt_tabs_6_1" role="tabpanel">


                                            <!-- start -->
                                            @include('user.upcomming.birthday')
                                            <!-- end -->


                                        </div>

                                        <!-- Work Anniversary -->
                                        <div class="tab-pane {{ (request()->get('approved')) ? 'active' : ''  }}" id="kt_tabs_6_2" role="tabpanel">

                                            <!-- start -->
                                            @include('user.upcomming.anniversary')
                                            <!-- end -->

                                        </div>

                                        <!-- Events -->
                                        <div class="tab-pane {{ (request()->get('rejected')) ? 'active' : ''  }}" id="kt_tabs_6_3" role="tabpanel">

                                            @include('user.upcomming.event')

                                        </div>

                                        <!-- Holiday -->
                                        <div class="tab-pane {{ (request()->get('cancelled')) ? 'active' : ''  }}" id="kt_tabs_6_4" role="tabpanel">

                                            @include('user.upcomming.event')

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Form-->

                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>
@endsection



@push('library-js')
    <script
        src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>

    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}"
            type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}"
            type="text/javascript"></script>
@endpush

@push('css')
    <style>
    @import "compass/css3";

    .calendar {
    padding: 1em;
    background: white;
    font-family: arial, helvetica, san-serif;
    box-shadow: 0 0 0.1em rgba(0,0,0, 0.5);
    border-radius: 0.2em;
    }

    .event {
        color: #333;
        display: block;
        padding: 0.1em;
        transition: all 0.25s ease;
        margin-bottom: 0.5em;
    }
        /* &:hover {
        background: darken(#EEE, 10%);
        text-decoration: none;
        color: black;
        } */

    .event_icon {
        width: 3em;
        float: left;
        margin-right: 0.75em;
    }
    .event_month, .event_day {
        text-align: center;
    }
    .event_month {
        padding: 0.1em;
        margin-bottom: 0.15em;
        background: #C00000;
        font-size: 0.75em;
        color: white;
        border-top-left-radius: 0.3em;
        border-top-right-radius: 0.3em;
    }
    .event_day {
        border: 1px solid #999;
        background: white;
        color: black;
        font-size: 1.25em;
        font-weight: bold;
        border-bottom-left-radius: 0.1em;
        border-bottom-right-radius: 0.1em;
    }


    /* events */
    .profile-cart {
            height: 300px;
            box-shadow: 0 0 5px 1px rgba(52, 52, 52, 0.224);
            position: relative;
            border-radius: 4px;
            z-index: 33;
            margin-bottom: 30px;
        }

        .profile-cart:hover {
            /* box-shadow: 0 0 15px 1px rgba(52, 52, 52, 0.25) */
        }

        .profile-cart::after {
            content: " ";
            /* background-image: linear-gradient(135deg, #6300a9 10%, #22bdb6 100%); */
            clip-path: circle(50% at 50% 1%);
            display: block;
            height: 300px;
            border-radius: 4px;
        }

        .profile-cart:hover::after {
            content: " ";
            clip-path: circle(100% at 50% 186%);
            display: block;
            height: 300px;
            border-radius: 4px;
        }

        .profile-cart img {
            width: 50px !important;
            height: 50px !important;
            position: absolute;
            top: 30px;
            left: 37%;
            z-index: 99999999;
            border-radius: 100%;
        }

        .profile-cart:hover img {
            transform: scale(2.3) translateY(5px);
            transition: 1s;
        }

        h5 {
            width: 100%;
            font-family: "poppins bold";
            color: rgba(30, 29, 29, 0.85);
            letter-spacing: 2px;
            padding-left: 10px;
        }

        h6 {
            padding-left: 10px;
        }

        .social-area {
            position: absolute;
            bottom: 15px;
            z-index: 999;
            justify-content: left;
            width: 100%;
        }
    </style>
@endpush
