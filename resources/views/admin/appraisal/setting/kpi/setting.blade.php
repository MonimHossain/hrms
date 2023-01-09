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
                                            Appraisal KPI Percentage Setting
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->

                    <form class="kt-form" action="{{ route('kpi.percentage.update', ['id'=>1]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">

                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                        <label style="text-align: right">KPI Permanent Percentage (%)</label>
                                            <label>
                                                <input type="text" class="form-control" name="permanent_percentage" placeholder="Enter Provident Fund"
                                                       value="{{ $appraisalKpi->permanent_percentage ?? 0 }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label style="text-align: right">KPI Hourly Percentage (%)</label>
                                            <label>
                                                <input type="text" class="form-control" name="hourly_percentage" placeholder="Enter Provident Fund"
                                                       value="{{ $appraisalKpi->hourly_percentage ?? 0 }}">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

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

        $(document).on('change', '#reward', function () {
            if($("#reward option:selected" ).val() != '-1'){
                $('#other').hide();
            }else{
                $('#other').show();
            }
        });

    </script>

@endpush
