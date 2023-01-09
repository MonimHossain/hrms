@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            KPI csv upload
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                        <span style="margin-top:5px;" class="float-right">
                            <a href="{{ asset('hrmsDocs/csv/sample-kpi.csv') }}" class="">KPI Format Download&nbsp;<i class="fa fa-download" aria-hidden="true"></i>
                            </a>
                        </span>
                        </div>
                    </div>



                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
                          action="{{ route('kpi.setting.store') }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                {{ csrf_field() }}
                                <div class="form-group col-md-2">
                                    <label class="">Month/Year</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="month-pick" required autocomplete="off" name="monthly_date">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">KPI File Upload</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file">
                                        <label class="custom-file-label selected" for="customFile" id=""></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-md-8">
                                        <button id="uploadData" type="submit" class="btn btn-brand">Upload</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->

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


                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
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
        $('#month-pick').datepicker({
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
    </script>

    <script>
        $( document ).ready(function() {
            $('#uploadData').on('click', function(){
                $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false}, "show");
            })
        });
    </script>

@endpush
