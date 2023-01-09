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
                            Attendance Upload
                        </h3>
                    </div>
                    <div class="float-right">
                        <span style="margin-top:5px;" class="float-right">
                            <a href="{{ asset('hrmsDocs/csv/attendence.csv') }}" class="">Attendence Format Download&nbsp;<i class="fa fa-download"
                                    aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                </div>

                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('attendence.save') }}">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group row form-group-marginless kt-margin-t-20">

                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control kt_datepicker_3" autocomplete="off" required placeholder="From" name="start_date"
                                           value=""/>
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <label>End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control kt_datepicker_3" autocomplete="off" required placeholder="To" name="end_date"
                                           value=""/>
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <label>Attendance File Upload</label>
                                {{--                                    <input type="file" name="excel_file" id="" class="form-control">--}}
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" onchange="getFilePath()" name="excel_file">
                                    <label class="custom-file-label selected" style="text-align: left" for="customFile" id="customFileLabel"></label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="">
                                    <button type="submit" class="btn btn-brand">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection
@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    {{--        <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>--}}

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
    </script>
    <script>
        function getFilePath() {
            // var input = document.getElementById("customFile");
            // var fReader = new FileReader();
            // fReader.readAsDataURL(input.files[0]);
            // fReader.onloadend = function(event){
            //     $("#customFileLabel").empty();
            //     $("#customFileLabel").append(event.target.result);
            // }
            $("#customFileLabel").empty();
            $("#customFileLabel").append(document.getElementById("customFile").files[0].name);
        }
    </script>
@endpush
