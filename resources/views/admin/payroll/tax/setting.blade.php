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
                                            Tax List
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <br>
                        &nbsp;<a style="float:right; margin-right: 10px" href="#" title="Add New Tax" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.tax.setting.add') }}" class="btn btn-outline-primary custom-btn globalModal">Add
                            New Tax
                        </a>&nbsp;&nbsp;
                        <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                            <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Rate (%)</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($taxs as $key=> $tax)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $tax->amount }}</td>
                                    <td>{{ $tax->min }}</td>
                                    <td>{{ $tax->max }}</td>
                                    <td>
                                        <a href="#" title="Edit Tax" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.tax.setting.edit', ['id'=>$tax->id]) }}" class="custom-btn globalModal">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        |
                                        <a href="#" redirect="payroll.tax.setting" modelName="TaxSetting" id="{{ $tax->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>



                    <!--begin::Form-->


                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@include('layouts.lookup-setup-delete')

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
