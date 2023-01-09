@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">



<!--begin::Form-->
{{-- <input type="hidden" id="salary-breakdown-settings" value="{{ $salary_breakdown_settings }}"> --}}
{{-- <input type="hidden" id="tax-settings" value="{{ $tax_settings }}"> --}}
{{-- <input type="hidden" id="pf-settings" value="{{ $pf_settings }}"> --}}

<form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('manage.salary.update') }}">
    @csrf

    <input type="hidden" name="employee_id" value="{{ $employee_id }}">
    <input type="hidden" name="salary_id" value="{{ $salary_id }}">
    {{--                     Salary--}}
    <div class="row">

        <div class="col-sm-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h3 style="float: left;" class="kt-portlet__head-title">
                                        Bank Infos
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
{{--                    <span class="pull-right"><a href="{{ route('add.new.bank') }}" class="btn btn-outline-success" style="position: relative; top: 12px;">Add New Bank</a></span>--}}
                </div>


                <div class="kt-portlet__body ">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Name:</label>
                                <select id="bank" name="bank_info_id" class="form-control" >
                                    <option value="">Select</option>
                                    @foreach($banks as $bank)
                                        <option {{ ($salaryInfo->bank_info_id == $bank->id) ? 'selected' : '' }} value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>branch Name:</label>
                                <select id="branch" name="bank_branch_id" class="form-control" >
                                    <option value="">Select</option>
                                    @foreach($branches as $item)
                                        <option {{ ($salaryInfo->bank_branch_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->bank_branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Routing:</label>
                                <input class="form-control" type="text" value="{{ ($branch) ? $branch->bank_routing : '' }}" id="bank-routing" name="" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Account Type:</label>
                                <select name="bank_account_type" class="form-control" >
                                    <option value="">Select</option>
                                    <option {{ ($salaryInfo->bank_account_type == 1) ? 'selected' : '' }} value="1">Prepaid/Payroll</option>
                                    <option {{ ($salaryInfo->bank_account_type == 2) ? 'selected' : '' }} value="2">Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Account:</label>
                                <input class="form-control" type="text" value="{{ $salaryInfo->bank_account }}" id="" name="bank_account" >
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Applicable Form:</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" autocomplete="off" required placeholder="Select date" id="kt_datepicker_3" name="applicable_from" value="{{ $salaryInfo->applicable_from }}"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->


        <div class="col-sm-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h3 style="float: left;" class="kt-portlet__head-title">
                                        Salary Details
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


                <div class="kt-portlet__body">

                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Hourly Rate:</label>
                                <input class="form-control" type="text" value="{{ $salaryInfo->hourly_rate }}" name="hourly_rate" {{ ($isEditable) ? 'readonly' : '' }}  required>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{ $salaryInfo->type }}">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Payment Type:</label>
                                <select name="payment_type_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($payment_types as $item)
                                        <option {{ ($salaryInfo->payment_type_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Overtime:</label>
                                <select  name="overtime_status" class="form-control" required>
                                    <option {{ ($salaryInfo->overtime_status == 0) ? 'selected' : '' }} value="0">Not applicable</option>
                                    <option {{ ($salaryInfo->overtime_status == 1) ? 'selected' : '' }} value="1">Applicable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>KPI:</label>
                                <select id="kpi_status" name="kpi_status" class="form-control" required>
                                    <option {{ ($salaryInfo->kpi_status == 0) ? 'selected' : '' }} value="0">Not applicable</option>
                                    <option {{ ($salaryInfo->kpi_status == 1) ? 'selected' : '' }} value="1">Applicable</option>
                                </select>
                            </div>
                        </div>

                        @if($employmentType == 'Permanent')
                            <input type="hidden" name="pay_cycle_id" value="2">
                        @else
                            <input type="hidden" name="pay_cycle_id" value="1">
                        @endif

                        {{-- <div class="col-sm-3">
                            <div class="form-group">
                                <label>Pay Cycle:</label>
                                <select id="bank" name="pay_cycle_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($pay_cycles as $item)
                                        <option {{ ($salaryInfo->pay_cycle_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }} ({{ $item->start_date }} - {{ $item->end_date }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-3">
                            <div class="form-group">
                                <label></label>
                                <button type="submit"
                                        class="btn btn-primary" style="margin-top: 1.9rem !important;">
                                    <i class="la la-edit"></i>
                                    Update Details
                                </button>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="offset-sm-9 col-sm-3 d-none kpiratediv">
                            <div class="form-group">
                                <label>KPI Rate:</label>
                                <input class="form-control" type="text" value="{{ $salaryInfo->kpi_rate }}" id="kpirate" name="kpi_rate">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- other allowance --}}
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h3 style="float: left;" class="kt-portlet__head-title">
                                        Other Allowances
                                    </h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="hidden" name="pay_cycle_id" value="1">
                                {{-- <label>Pay Cycle:</label>
                                <select  name="pay_cycle_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($pay_cycles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->start_date }} - {{ $item->end_date }})</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="kt-portlet__body">
                    <div id="kt_repeater_2">
                        <div class="form-group form-group-last row" id="kt_repeater_2">

                            <div data-repeater-list="other_allowance" class="col-lg-12">
                                @if($salaryInfo->individualOtherAllowances->count())
                                    @forelse ($salaryInfo->individualOtherAllowances as $key => $allowance)
{{--                                        {{dd($allowance->adjustment_type_id)}}--}}
                                        <div data-repeater-item class="form-group row align-items-center repeater-item">

                                        <div class="col-sm-3">
                                            <div class="kt-form__label">
                                                <label>Adjustment:</label>
                                            </div>
                                            <div class="kt-form__control">
                                                <select  name="other_allowance[{{ $key }}][adjustment_type_id]" class="form-control" >
                                                    <option value="">Select</option>
                                                    @foreach($adjustment_types as $item)
                                                        <option {{ ($allowance->adjustment_type_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 type">
                                            <div class="kt-form__label">
                                                <label>Type:</label>
                                            </div>
                                            <div class="kt-form__control">
                                                <select  name="other_allowance[{{ $key }}][type]" class="form-control other-allowance-type" >
                                                    <option value="">Select</option>
                                                    <option {{ ($allowance->type == 'addition') ? 'selected' : '' }} value="addition"> Addition </option>
                                                    <option {{ ($allowance->type == 'deduction') ? 'selected' : '' }} value="deduction"> Deduction </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 amount">
                                            <div class="kt-form__group--inline other-allowance-amount-c">
                                                <div class="kt-form__label">
                                                    <label>Amount:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <input type="text" class="form-control other-allowance-amount " placeholder="Amount" name="other_allowance[{{ $key }}][amount]" value="{{ $allowance->amount }}" >
                                                </div>
                                            </div>
                                            <div class="d-md-none kt-margin-b-10"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Remarks:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <textarea class="form-control" id="exampleTextarea" rows="3" spellcheck="false" name="other_allowance[{{ $key }}][remarks]">{{ $allowance->remarks }}</textarea>
                                                </div>
                                            </div>
                                            <div class="d-md-none kt-margin-b-10"></div>
                                        </div>


                                        <div class="col-md-3">
                                            <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold delete-allowance">
                                                <i class="la la-trash-o"></i>

                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div data-repeater-item class="form-group row align-items-center repeater-item">

                                        <div class="col-sm-3">
                                            <div class="kt-form__label">
                                                <label>Adjustment:</label>
                                            </div>
                                            <div class="kt-form__control">
                                                <select  name="adjustment_type_id" class="form-control" >
                                                    <option value="">Select</option>
                                                    @foreach($adjustment_types as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 type">
                                            <div class="kt-form__label">
                                                <label>Type:</label>
                                            </div>
                                            <div class="kt-form__control">
                                                <select  name="type" class="form-control other-allowance-type" >
                                                    <option value="">Select</option>
                                                    <option value="addition"> Addition </option>
                                                    <option value="deduction"> Deduction </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 amount">
                                            <div class="kt-form__group--inline d-none other-allowance-amount-c">
                                                <div class="kt-form__label">
                                                    <label>Amount:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <input type="text" class="form-control other-allowance-amount " placeholder="Amount" name="amount" value="" >
                                                </div>
                                            </div>
                                            <div class="d-md-none kt-margin-b-10"></div>
                                        </div>

                                        <div class="col-md-6 remarks">
                                            <div class="kt-form__group--inline">
                                                <div class="kt-form__label">
                                                    <label>Remarks:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <textarea class="form-control" id="remarks" rows="3" spellcheck="false" name="remarks"></textarea>
                                                </div>
                                            </div>
                                            <div class="d-md-none kt-margin-b-10"></div>
                                        </div>


                                        <div class="col-md-3">
                                            <a href="javascript:;" style="margin-top: 25px;" data-repeater-delete="" class="btn-sm btn btn-label-danger btn-bold delete-allowance">
                                                <i class="la la-trash-o"></i>

                                            </a>
                                        </div>
                                    </div>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group form-group-last row">
                            <div class="col-lg-4">
                                <a href="javascript:;" data-repeater-create="" class="btn btn-bold btn-sm btn-label-brand">
                                    <i class="la la-plus"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions pull-right">
                        <button type="submit"
                                class="btn btn-primary" style="">
                            <i class="la la-edit"></i>
                            Submit Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <!--end::Portlet-->
</form>
<!--end::Form-->




            </div>
        </div>
    </div>
@endsection


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>
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
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('change', "#bank", function () {
                let bankID = $(this).val();
                let url = '{{ route("get.branch",':bankID' ) }}';
                url = url.replace(':bankID', bankID);
                let that = $(this);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        // that.empty();
                        $("#branch").empty();
                        $("#bank-routing").val(null);
                        $("#branch").append('<option value="">Select</option>')
                        $.each(response.data, function(id, value){
                            $('#branch').append('<option value="'+ value.id +'">'+ value.bank_branch_name +'</option>')
                        });
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        $("#branch").empty();
                        $("#bank-routing").val(null);
                        $("#branch").append('<option value="">Select</option>')
                    })
            });

            $(document).on('change', "#branch", function () {
                let branchID = $(this).val();
                let url = '{{ route("get.branchByBranchId",':branchID' ) }}';
                url = url.replace(':branchID', branchID);
                let that = $(this);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        // that.empty();
                        $("#bank-routing").val(null);
                        $('#bank-routing').val(response.data.bank_routing);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        $("#bank-routing").val(null);
                    })
            });
        })
    </script>

{{--    <script>--}}
{{--        $(document).ready(function () {--}}

{{--            var grossSalary = 0;--}}
{{--            var totalDiduction = 0;--}}
{{--            var netSalary = 0;--}}
{{--            salaryCalcualation(parseInt($('input[name="gross_salary"]').val()), totalDiduction, netSalary);--}}
{{--            $(document).on('keyup', '#gross-salary', function () {--}}
{{--                if (/\D/g.test(this.value))--}}
{{--                {--}}
{{--                    // Filter non-digits from input value.--}}
{{--                    this.value = this.value.replace(/[^\d.]/g, '');--}}

{{--                }--}}
{{--                grossSalary = this.value;--}}
{{--                salaryCalcualation(grossSalary, totalDiduction, netSalary);--}}
{{--            })--}}
{{--        })--}}

{{--        function salaryCalcualation(grossSalary, totalDiduction, netSalary) {--}}
{{--            var salaryBreakdownSettings = JSON.parse($('#salary-breakdown-settings').val());--}}
{{--            var taxSettings = JSON.parse($('#tax-settings').val());--}}
{{--            var pfSettings = JSON.parse($('#pf-settings').val());--}}
{{--            var employmentType = $('#employment-type').val();--}}

{{--            var allowances_percentage = $('input[name="allowances_percentage[]"]');--}}
{{--            if (allowances_percentage.length > 0){--}}
{{--                allowances_percentage.each(function () {--}}
{{--                    let value = grossSalary * ($(this).val()/100);--}}
{{--                    $(this).closest('.col-sm-4').siblings('.col-sm-8').children('input[name="allowances_amount[]"]').val(Number(value).toFixed((2)));--}}
{{--                });--}}
{{--                var basicSalary = $('input[name="allowances_amount[]"]')[0].value;--}}
{{--            }--}}
{{--            var yearlyBasicSalary = basicSalary*12;--}}
{{--            var tax = 0;--}}
{{--            taxSettings.forEach(function (e) {--}}
{{--                if(yearlyBasicSalary >= e.min ){--}}
{{--                    tax = e.amount;--}}
{{--                }--}}
{{--            });--}}
{{--            var taxDiduction = basicSalary*(tax/100);--}}
{{--            totalDiduction = parseInt(totalDiduction) + parseInt(taxDiduction);--}}
{{--            $('input[name="tax_percentage"]').val(tax);--}}
{{--            $('input[name="tax_percentage"]').closest('.col-sm-4').siblings('.col-sm-8').children('input[name="tax"]').val(Number(taxDiduction).toFixed((2)));--}}

{{--            $('input[name="pf_percentage"]').val(pfSettings.amount);--}}
{{--            $('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-8').children('input[name="pf"]').val(Number(basicSalary*(pfSettings.amount/100)).toFixed((2)));--}}
{{--            totalDiduction = totalDiduction + parseInt($('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-8').children('input[name="pf"]').val());--}}
{{--            console.log(totalDiduction)--}}

{{--            netSalary = grossSalary - totalDiduction;--}}
{{--            $('#total-gross').val(grossSalary);--}}
{{--            $('#total-diduction').val(totalDiduction);--}}
{{--            $('#net-salary').val(netSalary);--}}


{{--        }--}}
{{--    </script>--}}

    <script>
        $(document).ready(function () {

            // $(document).find('#kt_repeater_2').repeater({
            //     initEmpty: false,

            //     defaultValues: {
            //         'text-input': 'foo'
            //     },

            //     show: function() {
            //         $(this).slideDown();
            //     },

            //     hide: function(deleteElement) {
            //         // if(confirm('Are you sure you want to delete this element?')) {
            //             $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val('');
            //             $(this).slideUp(deleteElement);
            //             salaryForm();
            //         // }
            //         // $(this).slideUp(deleteElement);
            //     }
            // });
            $('#kt_datepicker_3').datepicker({
                rtl: KTUtil.isRTL(),
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                format: 'yyyy-mm-dd',
            });


            salaryForm()
        });

        function salaryForm() {
            // var grossSalary = 0;
            {{--pfStatus = (_=>_)({{ $salaryInfo->pf_status }});--}}
            {{--taxStatus = (_=>_)({{ $salaryInfo->tax_status }});--}}


            var grossSalary = ($(document).find('#gross-salary').val()) ? $(document).find('#gross-salary').val() : 0;
            var pfStatus = ($(document).find('#pf-status').is (':checked')) ? pfStatus = 0 : pfStatus = 1;
            var taxStatus = ($(document).find('#tax-status').is (':checked')) ? taxStatus = 0 : taxStatus = 1;


            let result = otherAllowance();
            calculateSalary(parseInt($('input[name="gross_salary"]').val()), pfStatus, taxStatus, result.addition, result.deduction);
            $(document).on('keyup', '#gross-salary', function () {
                if (/\D/g.test(this.value))
                {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/[^\d.]/g, '');
                }
                grossSalary = this.value;

                ($(document).find("#pf-status").is (':checked')) ? pfStatus = 0 : pfStatus = 1;
                ($(document).find("#tax-status").is (':checked')) ? taxStatus = 0 : taxStatus = 1;
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);

            })

            $(document).on('change', "#tax-status", function() {
                (this.checked) ? taxStatus = 0 : taxStatus = 1;
                ($(document).find("#pf-status").is (':checked')) ? pfStatus = 0 : pfStatus = 1;
                grossSalary = parseInt($('input[name="gross_salary"]').val());
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });
            $(document).on('change', "#pf-status", function() {
                (this.checked) ? pfStatus = 0 : pfStatus = 1;
                ($(document).find("#tax-status").is (':checked')) ? taxStatus = 0 : taxStatus = 1;
                grossSalary = parseInt($('input[name="gross_salary"]').val());
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });

            $(document).on('keyup', '.other-allowance-amount', function () {
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });

            // $(document).on('click', '.delete-allowance', function () {
            //     $(this).parent().siblings('.amount').find('.other-allowance-amount').val('');
            //     salaryForm();
            // });

            $(document).on('change', '.other-allowance-type', function () {
                if ($(this).val()){
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount-c').removeClass('d-none')
                } else {
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val('');
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount-c').addClass('d-none');
                }
                var grossSalary = ($(document).find('#gross-salary').val()) ? $(document).find('#gross-salary').val() : 0;
                var pfStatus = ($(document).find('#pf-status').is (':checked')) ? pfStatus = 0 : pfStatus = 1;
                var taxStatus = ($(document).find('#tax-status').is (':checked')) ? taxStatus = 0 : taxStatus = 1;
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
                // salaryForm();
            });
        }

        function calculateSalary(grossSalary, pfStatus, taxStatus, addition, deduction) {
            var totalDiduction = 0;
            var netSalary = 0;
            var salaryBreakdownSettings = JSON.parse($('#salary-breakdown-settings').val());
            var taxSettings = JSON.parse($('#tax-settings').val());
            var pfSettings = JSON.parse($('#pf-settings').val());
            var employmentType = $('#employment-type').val();

            var allowances_percentage = $('input[name="allowances_percentage[]"]');
            if (allowances_percentage.length > 0){
                allowances_percentage.each(function () {
                    let value = grossSalary * ($(this).val()/100);
                    $(this).closest('.col-sm-4').siblings('.col-sm-8').children('input[name="allowances_amount[]"]').val(Number(value).toFixed((2)));
                });
                var basicSalary = $('input[name="allowances_amount[]"]')[0].value;
            }
            var yearlyBasicSalary = basicSalary*12;
            var tax = 0;
            taxSettings.forEach(function (e) {
                if(yearlyBasicSalary >= e.min ){
                    tax = e.amount;
                }
            });
            // var taxDiduction = basicSalary*(tax/100); // calculate with basic
            var taxDiduction = grossSalary*(tax/100); // calculate with gross

            $('input[name="tax_percentage"]').val(tax);
            $('input[name="tax_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').find('input[name="tax"]').val(Number(taxDiduction).toFixed((2)));

            $('input[name="pf_percentage"]').val(pfSettings.amount);
            $('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').find('input[name="pf"]').val(Number(basicSalary*(pfSettings.amount/100)).toFixed((2)));


            if(taxStatus){
                totalDiduction = parseInt(totalDiduction) + parseInt(taxDiduction);
            }
            if(pfStatus){
                totalDiduction = totalDiduction + parseInt($('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').children('input[name="pf"]').val());
            }

            if (deduction){
                totalDiduction = totalDiduction + parseInt(deduction);
            }

            netSalary = grossSalary - totalDiduction;


            if(addition){
                netSalary = netSalary + parseInt(addition);
            }

            $('#total-gross').val(grossSalary);
            $('#total-diduction').val(totalDiduction);
            $('#net-salary').val(netSalary);
        }

        function otherAllowance(){
            var other_allowances = $(document).find('.other-allowance-amount');
            var addition = 0;
            var deduction = 0;
            if (other_allowances.length > 0){
                other_allowances.each(function () {
                    let type = $(this).closest('.amount').siblings('.type').find('.other-allowance-type').val();
                    if (type == 'addition'){
                        addition += parseInt($(this).val());
                    } else {
                        deduction += parseInt($(this).val());
                    }
                });
            }
            return {
                addition: addition,
                deduction: deduction
            };
        }
    </script>

    <script>
        $(document).on('change', '#kpi_status', function () {
            if ($(this).val() == 1){
                $(document).find('.kpiratediv').removeClass('d-none');

                $(document).find('#kpirate').prop('required', true);
                $(document).find('#kpirate').prop('disabled', false);

            } else {
                $(document).find('.kpiratediv').addClass('d-none');

                $(document).find('#kpirate').prop('required', false);

                $(document).find('#kpirate').prop('disabled', true);

            }

        });

        $(document).ready(function () {
            if ($('#kpi_status').val() == 1){
                $(document).find('.kpiratediv').removeClass('d-none');

                $(document).find('#kpirate').prop('required', true);
                $(document).find('#kpirate').prop('disabled', false);

            } else {
                $(document).find('.kpiratediv').addClass('d-none');

                $(document).find('#kpirate').prop('required', false);

                $(document).find('#kpirate').prop('disabled', true);

            }

        });
    </script>

@endpush
