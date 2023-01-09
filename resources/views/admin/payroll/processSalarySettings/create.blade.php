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
                                            Upload KPI from CSV file
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                        <span style="margin-top:5px;" class="float-right">
                            <a href="#" class="">KPI Format Download&nbsp;<i class="fa fa-download" aria-hidden="true"></i>
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
                                        <input type="text" class="form-control" id="kt_datepicker_3" name="file">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="">KPI File Upload</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                               onchange="getFilePath()" name="file">
                                        <label class="custom-file-label selected" for="customFile" id=""></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-brand">Upload</button>
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
    </script>

@endpush
