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
                                            @if("add" === $flag)
                                                Add New
                                                    @else
                                                Update
                                            @endif
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!--begin::Form-->


                    @if("add" === $flag)
                        <form class="kt-form" action="{{ route('payroll.tax.create') }}" method="POST">
                    @else
                        <form class="kt-form" action="{{ route('payroll.tax.update', ['id'=>$id]) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                    @endif

                        @csrf
                        <div class="col-md-12">
                            <div class="kt-portlet__body">
                                @if($rows)
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Employee ID</label>
                                            <label>
                                                <input type="text" class="form-control" readonly required name="employee_id" placeholder="Enter Employee ID"
                                                       value="{{ $rows->employee_id }}">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Month</label>
                                            <label>
                                                <input type="text" class="form-control"  required id="month-pick" name="month" placeholder="Select Date"
                                                       value="{{ date('Y-m', strtotime($rows->month)) ?? '' }}">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Amount</label>
                                            <label>
                                                <input type="text" class="form-control" required name="amount" placeholder="Enter Amount"
                                                       value="{{ $rows ->amount }}">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">&nbsp;Remarks</label>
                                            <label>
                                                <textarea class="form-control" required name="remarks">{{ $rows->remarks }}</textarea>
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Employee ID</label>
                                            <label>
                                                <input type="text" class="form-control" required name="employee_id" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Month</label>
                                            <label>
                                                <input type="text" class="form-control"  required id="month-pick" name="month" placeholder="Select Date"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Amount</label>
                                            <label>
                                                <input type="text" class="form-control" required name="amount" placeholder="Enter Amount"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">&nbsp;Remarks</label>
                                            <label>
                                                <textarea class="form-control" required name="remarks"></textarea>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <label for="" class="offset-1">
                                    <button type="submit" class="btn btn-primary">
                                        @if("add" === $flag)
                                        Save
                                    @else
                                        Update
                                    @endif
                                    </button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </label>
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
