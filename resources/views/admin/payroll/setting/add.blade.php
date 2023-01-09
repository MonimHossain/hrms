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
                                            Add KPI
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!--begin::Form-->

                    @if("add" === $flag)
                    <form class="kt-form" action="{{ route('kpi.setting.save') }}" method="POST">
                    @else
                    <form class="kt-form" action="{{ route('kpi.setting.update', ['id'=>$id]) }}" method="POST">
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
                                                <input type="text" class="form-control" name="employee_id" autocomplete="off" placeholder="Enter Employee ID"
                                                       value="{{ $rows->employer_id ?? '' }}">
                                            </label>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Month</label>
                                            <label>
                                                <input type="text" autocomplete="off" class="form-control" id="month-pick" name="monthly_date" placeholder="Select Date"
                                                       value="{{ date('Y-m', strtotime($rows->monthly_date)) ?? '' }}">
                                            </label>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Grade</label>
                                            <label>
                                                <select class="form-control" name="grade" id="" style="width:280px">
                                                    <option>Select</option>
                                                    <option {{ ($rows->grade == 'A+' ) ? "selected='selected'":"" }} value="A+">A+</option>
                                                    <option {{ ($rows->grade == 'A' ) ? "selected='selected'":"" }} value="A">A</option>
                                                    <option {{ ($rows->grade == 'A-' ) ? "selected='selected'":"" }} value="A-">A-</option>
                                                    <option {{ ($rows->grade == 'B+' ) ? "selected='selected'":"" }} value="B+">B+</option>
                                                    <option {{ ($rows->grade == 'B' ) ? "selected='selected'":"" }} value="B">B</option>
                                                    <option {{ ($rows->grade == 'B-' ) ? "selected='selected'":"" }} value="B-">B-</option>
                                                    <option {{ ($rows->grade == 'C+' ) ? "selected='selected'":"" }} value="C+">C+</option>
                                                    <option {{ ($rows->grade == 'C' ) ? "selected='selected'":"" }} value="C">C</option>
                                                    <option {{ ($rows->grade == 'C-' ) ? "selected='selected'":"" }} value="C-">C-</option>
                                                    <option {{ ($rows->grade == 'D' ) ? "selected='selected'":"" }} value="D">D</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Amount</label>
                                            <label>
                                                <input type="text" class="form-control" name="amount" placeholder="Enter Amount"
                                                       value="{{ $rows->amount ?? '' }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Reward</label>
                                            <label>
                                                <select class="form-control" name="reward" id="reward" style="width:280px">
                                                    <option {{ ($rows->reward == '-1' ) ? "selected='selected'":"" }} value="-1">Select</option>
                                                    <option {{ ($rows->reward == 'Start performer Rank 1' ) ? "selected='selected'":"" }} value="Start performer Rank 1">Start performer Rank 1</option>
                                                    <option {{ ($rows->reward == 'Start performer Rank 2' ) ? "selected='selected'":"" }} value="Start performer Rank 2">Start performer Rank 2</option>
                                                    <option {{ ($rows->reward == 'Start performer Rank 3' ) ? "selected='selected'":"" }} value="Start performer Rank 3">Start performer Rank 3</option>
                                                    <option {{ ($rows->reward == 'Best Team Lear' ) ? "selected='selected'":"" }} value="Best Team Lear">Best Team Lear</option>
                                                    <option {{ ($rows->reward == 'Best Team Trainer' ) ? "selected='selected'":"" }} value="Best Team Trainer">Best Team Trainer</option>
                                                    <option {{ ($rows->reward == 'Best Team QA' ) ? "selected='selected'":"" }} value="Best Team QA">Best Team QA</option>
                                                    <option {{ ($rows->reward == 'Quality Champion Rank 1' ) ? "selected='selected'":"" }} value="Quality Champion Rank 1">Quality Champion Rank 1</option>
                                                    <option {{ ($rows->reward == 'Quality Champion Rank 2' ) ? "selected='selected'":"" }} value="Quality Champion Rank 2">Quality Champion Rank 2</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">&nbsp;</label>
                                            <label>
                                                <input type="text" class="form-control" name="others" id="other" style="display: {{ ($rows->reward != '-1')? 'none':'block' }}" placeholder="Enter reward"
                                                       value="{{ $rows->others }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2" style="text-align: right">Reword and Recognition</label>
                                        <div class="col-sm-8">
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio"><input type="radio" value="1" {{ ($rows->r_and_r == 1)? 'checked="checked"':"" }} name="r_and_r" class="targetEmployee">
                                                    Yes
                                                    <span></span></label>
                                                <label class="kt-radio"><input type="radio" value="2" {{ ($rows->r_and_r == 2)? 'checked="checked"':"" }} name="r_and_r" class="targetEmployee">
                                                    No
                                                    <span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Employee ID</label>
                                            <label>
                                                <input type="text" class="form-control" name="employee_id" placeholder="Enter Employee ID"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Month</label>
                                            <label>
                                                <input type="text" class="form-control" id="month-pick" name="monthly_date" placeholder="Select Date"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Grade</label>
                                            <label>
                                                <select class="form-control" name="grade" id="" style="width:280px">
                                                    <option>Select</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A">A</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B">B</option>
                                                    <option value="B-">B-</option>
                                                    <option value="C+">C+</option>
                                                    <option value="C">C</option>
                                                    <option value="C-">C-</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Amount</label>
                                            <label>
                                                <input type="text" class="form-control" name="amount" placeholder="Enter Amount"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">Reward</label>
                                            <label>
                                                <select class="form-control" name="reward" id="reward" style="width:280px">
                                                    <option value="-1">Select</option>
                                                    <option value="Start performer Rank 1">Start performer Rank 1</option>
                                                    <option value="Start performer Rank 2">Start performer Rank 2</option>
                                                    <option value="Start performer Rank 3">Start performer Rank 3</option>
                                                    <option value="Best Team Lear">Best Team Lear</option>
                                                    <option value="Best Team Trainer">Best Team Trainer</option>
                                                    <option value="Best Team QA">Best Team QA</option>
                                                    <option value="Quality Champion Rank 1">Quality Champion Rank 1</option>
                                                    <option value="Quality Champion Rank 2">Quality Champion Rank 2</option>
                                                 </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label class="col-md-2" style="text-align: right">&nbsp;</label>
                                            <label>
                                                <input type="text" class="form-control" name="others" id="other" placeholder="Enter reward"
                                                       value="">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2" style="text-align: right">Reword and Recognition</label>
                                        <div class="col-sm-8">
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio"><input type="radio" value="1" checked="checked" name="r_and_r" class="targetEmployee">
                                                    Yes
                                                    <span></span></label>
                                                <label class="kt-radio"><input type="radio" value="2" name="r_and_r" class="targetEmployee">
                                                    No
                                                    <span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>


                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <label for="" class="offset-1">
                                    <button type="submit" class="btn btn-primary">Save</button>
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
