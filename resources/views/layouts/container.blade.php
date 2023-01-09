@extends('layouts.app')

@section('content-main')

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            @if(auth()->user()->hasAnyRole('Super Admin|Admin'))
                <a href="{{ route('dashboard') }}">
                    <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}" />
                </a>
            @endif
            @if(!auth()->user()->hasAnyRole('Super Admin|Admin'))
                <a href="{{ route('user.dashboard') }}">
                    <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}" />
                </a>
            @endif
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
            <!-- <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button> -->
            <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
        </div>
    </div>

    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            {{-- include sidebar --}}
            @include('layouts.sidebar')

            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                {{-- include header --}}
                @include('layouts.header')
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
                    {{-- <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content"> --}}
                    {{-- include subheader --}}
                    {{-- @include('layouts.subheader') --}}
                    {{-- content goes here --}}
                    @yield('content')
                    {{-- </div> --}}
                </div>
                {{-- include footer --}}
                {{-- @include('layouts.footer') --}}
            </div>
        </div>
    </div>


    <!-- begin::Global Config(global config for global JS sciprts) -->
    {{--<script>--}}
    {{--    var KTAppOptions = {--}}
    {{--        "colors": {--}}
    {{--            "state": {--}}
    {{--                "brand": "#782B90",--}}
    {{--                "light": "#ffffff",--}}
    {{--                "dark": "#782B90",--}}
    {{--                "primary": "#782B90",--}}
    {{--                "success": "#34bfa3",--}}
    {{--                "info": "#36a3f7",--}}
    {{--                "warning": "#ffb822",--}}
    {{--                "danger": "#fd3995"--}}
    {{--            },--}}
    {{--            "base": {--}}
    {{--                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],--}}
    {{--                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]--}}
    {{--            }--}}
    {{--        }--}}
    {{--    };--}}
    {{--</script>--}}

    <!-- end::Global Config -->

@endsection



@push('css')
    <link href="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #kt_footer {
            position: absolute;
            bottom: 0;
            right: 0;
        }
    </style>
@endpush

@push('js')
    @include('layouts.partials.includes.division-center')
    {{--<script src="{{ asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>--}}

    {{--<script src="{{ asset('assets/js/demo1/pages/dashboard.js') }}" type="text/javascript"></script>--}}

    <script>
        // footer bottom fixed and width adjustment
        // $(function(){
        //     let width = $(window).width();
        //     width = width - $('#kt_aside_menu_wrapper').width();
        //     $('#kt_footer').css('width', width);

        //     $( window ).resize(function() {
        //         if($(window).width()>1024){
        //             let width = $(window).width();
        //             width = width - $('#kt_aside_menu_wrapper').width();
        //             $('#kt_footer').css('width', width);
        //         }else{
        //             $('#kt_footer').css('width', "100%");
        //         }

        //     });
        // });


        // Global modal script
        jQuery(document).ready(function ($) {
            $(document).on('click', '.globalModal', function () {
                var size_attr = $(this).attr('form-size');
                var form_width = (typeof size_attr !== typeof undefined && size_attr !== false) ? $(this).attr("form-size") : 'modal-lg';
                var form_title = $(this).attr("title");
                var form_url = $(this).attr("action");
                var form_method = "GET";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: form_url,
                    type: form_method,
                    cache: false,
                    success: function (returnhtml) {
                        $('.modal-dialog').addClass(form_width);
                        $('.modal-title').text(form_title);
                        $(".modal-body").html(returnhtml);

                        /*for text area.*/
                        $('.textarea').ckeditor();

                        //selectpicker search init
                        var KTBootstrapSelect = function () {
                            // Private functions
                            var demos = function () {
                                // minimum setup
                                $('.kt-selectpicker').selectpicker();
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
                                $('.kt_datepicker_3').datepicker({
                                    rtl: KTUtil.isRTL(),
                                    todayBtn: "linked",
                                    clearBtn: true,
                                    todayHighlight: true,
                                    orientation: "bottom left",
                                    templates: arrows,
                                    format: 'yyyy-mm-dd',
                                });

                                $('.month-pick').datepicker({
                                    rtl: KTUtil.isRTL(),
                                    todayBtn: "linked",
                                    clearBtn: true,
                                    todayHighlight: true,
                                    orientation: "bottom left",
                                    templates: arrows,
                                    format: 'yyyy-mm',
                                    viewMode: 'months',
                                    minViewMode: 'months'
                                });
                            };
                            return {
                                // public functions
                                init: function () {
                                    demos();
                                }
                            };
                        }();

                        jQuery(document).ready(function () {
                            KTBootstrapSelect.init();
                        });


                    }
                });
            });
        });

    </script>
    // <script>
                
    //     $("body").setShortcutKey( ALT, G , function() {
    //         // $(location).attr('href', '{{ route('employee.team') }}')            
    //     } );
    //     $("body").setShortcutKey( ALT , T , function() {
    //         $(location).attr('href', '{{ route('employee.team') }}')
    //     } );
    // </script>
@endpush


