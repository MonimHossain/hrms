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
                                Employee Attendance
                            </h3>
                        </div>
                        <div class="float-right">
                        <span style="margin-top:5px;" class="float-right text-right">
                            <a href="{{ asset('hrmsDocs/csv/employee_attendance_sample_data.csv') }}" class="">Employee Attendance Format Download&nbsp;<i class="fa fa-download" aria-hidden="true"></i></a> <br>
{{--                            <a href="{{ asset('hrmsDocs/csv/employee-adj-attendance.csv') }}" class="">Employee Adjusted Hours Format Download&nbsp;<i class="fa fa-download" aria-hidden="true"></i></a>--}}
                        </span>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('upload.salary.employee.attendance') }}">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row form-group-marginless kt-margin-t-20">
                                
                            
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label >Upload File (.csv)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" onchange="getFilePath()" name="excel_file">
                                        <label class="custom-file-label selected" style="text-align: left" for="customFile" id="customFileLabel"></label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-9 col-sm-12">
                                    <button id="uploadData" type="submit" class="btn btn-brand" style="position: relative; top: 25px">Submit</button>
                                </div>

                            </div>
                        </div>
                    </form>

                     <!-- Modal -->
                     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <p>                                        
                                        <img class="loaderCog" src="{{ asset('hrmsDocs/images/loader.gif') }}"> Uploading data...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->

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
    <script>
        $( document ).ready(function() {            
            $('#uploadData').on('click', function(){
                $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false}, "show");
            })
        });
    </script>
@endpush
