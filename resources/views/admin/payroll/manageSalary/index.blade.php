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
                                            Manage Salary
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" id="employee-list-form" enctype="multipart/form-data" method="POST" action="">
                        @csrf
                        <div class="kt-portlet__body">

                            <div class="form-group row">
                                {{-- <label class="col-sm-2 col-form-label">Select Employee:</label>
                                <div class="col-sm-3">
                                    <select id="employee_id" name="employee_id" class="form-control kt-selectpicker " data-live-search="true"
                                            data-placeholder="Select Employee">
                                    </select>
                                </div> --}}

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select Employee:</label>
                                        <select id="employee_id" name="employee_id" class="form-control kt-selectpicker " data-live-search="true"
                                            data-placeholder="Select Employee" required>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Salary Type:</label>
                                        <select id="salary_type" name="type" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="0">Hourly</option>
                                            <option value="1">Fixed</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label></label>
                                        <div class="kt-form__actions mt-2">
                                            <button type="submit" name="submit" value="apply_wild_leave" class="btn btn-outline-primary" style="margin-top: 0px">
                                                Load
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->



{{--                <salary-details></salary-details>--}}
                <div id="salary-details-form"></div>

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

        function addSelect2Ajax($element, $url, $changeCallback, data) {
            var placeHolder = $($element).data('placeholder');

            if (typeof $changeCallback == 'function') {
                $($element).change($changeCallback)
            }

            // $($element).hasClass('select2') && $($element).select2('destroy');

            return $($element).select2({
                allowClear: true,
                width: "resolve",
                ...data,
                placeholder: placeHolder,
                ajax: {
                    url: $url,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj, index) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }
                }
            });

        }

        addSelect2Ajax('#employee_id', "{{route('employee.all.by.type')}}");


    </script>

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
                if(!bankID){
                    $("#branch").empty().append('<option value="">Select</option>');
                    $("#bank-routing").val(null);
                }
                let url = '{{ route("get.branch",':bankID' ) }}';
                url = url.replace(':bankID', bankID);
                let that = $(this);
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        // that.empty();
                        console.log(response.data)
                        $.each(response.data, function(id, value){
                            $('#branch').append('<option value="'+ value.id +'">'+ value.bank_branch_name +'</option>')
                        });
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        $("#branch").empty();
                        $("#branch").append('<option value="">Select</option>');
                        $("#bank-routing").val(null);
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
                        // console.log(response.data[0].bank_routing)
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

    <script>
        $(document).ready(function () {

            $('#employee-list-form').on('submit', function (e) {
                e.preventDefault();
                var employee_id = $("#employee_id").val();
                var salary_type = $("#salary_type").val();
                if(employee_id && salary_type == 1){
                    $.ajax({
                        type: "GET",
                        url: "{{ route('manage.salary.load.form') }}",
                        data: {
                            "employee_id": employee_id,
                            "salary_type": salary_type
                        },
                        success: function (data) {
                            $('#salary-details-form').empty();
                            $('#salary-details-form').html(data);

                            $('.kt_datepicker_3').datepicker({
                                rtl: KTUtil.isRTL(),
                                todayBtn: "linked",
                                clearBtn: true,
                                todayHighlight: true,
                                orientation: "bottom left",
                                templates: arrows,
                                format: 'yyyy-mm-dd',
                            });

                            $(document).find('#kt_repeater_2').repeater({
                                initEmpty: false,

                                defaultValues: {
                                    'text-input': 'foo'
                                },

                                show: function() {
                                    $(this).slideDown();
                                },

                                hide: function(deleteElement) {
                                    if(confirm('Are you sure you want to delete this element?')) {
                                        console.log('b', $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val());
                                        // $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val('');
                                        $(this).closest('.repeater-item').find('.amount').find('.other-allowance-amount').val('');
                                        console.log('a', $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val());
                                        $(this).slideUp(deleteElement);
                                        salaryForm();
                                    }
                                    // $(this).slideUp(deleteElement);
                                }
                            });


                        },
                        error: function (data) {
                            $('#salary-details-form').empty();
                            console.log(data);
                        }
                    });
                }else if(employee_id && salary_type == 0){
                    $.ajax({
                        type: "GET",
                        url: "{{ route('manage.salary.load.form') }}",
                        data: {
                            "employee_id": employee_id,
                            "salary_type": salary_type
                        },
                        success: function (data) {
                            $('#salary-details-form').empty();
                            $('#salary-details-form').html(data);
                            $('.kt_datepicker_3').datepicker({
                                rtl: KTUtil.isRTL(),
                                todayBtn: "linked",
                                clearBtn: true,
                                todayHighlight: true,
                                orientation: "bottom left",
                                templates: arrows,
                                format: 'yyyy-mm-dd',
                            });
                            $(document).find('#kt_repeater_2').repeater({
                                initEmpty: false,

                                defaultValues: {
                                    'text-input': 'foo'
                                },

                                show: function() {
                                    $(this).slideDown();
                                },

                                hide: function(deleteElement) {
                                    if(confirm('Are you sure you want to delete this element?')) {
                                        console.log('b', $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val());
                                        // $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val('');
                                        $(this).closest('.repeater-item').find('.amount').find('.other-allowance-amount').val('');
                                        console.log('a', $(document).find('.other-allowance-type').closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val());
                                        $(this).slideUp(deleteElement);
                                        salaryForm();
                                    }
                                    // $(this).slideUp(deleteElement);
                                }
                            });
                        },
                        error: function (data) {
                            $('#salary-details-form').empty();
                            console.log(data);
                        }
                    });
                }
            });
            salaryForm();
        });

        function salaryForm() {
            // var grossSalary = 0;
            // var pfStatus = 1;
            // var taxStatus = 1;

            var grossSalary = ($(document).find('#gross-salary').val()) ? $(document).find('#gross-salary').val() : 0;
            var pfStatus = ($(document).find('#pf-status').is (':checked')) ? pfStatus = 0 : pfStatus = 1;
            var taxStatus = ($(document).find('#tax-status').is (':checked')) ? taxStatus = 0 : taxStatus = 1;
            // if($(document).is('#salary-form')){
            if($('#salary-form').length){
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            }

            console.log(grossSalary , pfStatus, taxStatus)

            $(document).on('keyup', '#gross-salary', function () {
                if (/\D/g.test(this.value))
                {
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/[^\d.]/g, '');
                }
                grossSalary = this.value;
                let result = otherAllowance();
                ($("#pf-status").checked) ? pfStatus = 0 : pfStatus = 1;
                ($("#tax-status").checked) ? taxStatus = 0 : taxStatus = 1;
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);

            })

            $(document).on('change', "#tax-status", function() {
                (this.checked) ? taxStatus = 0 : taxStatus = 1;
                ($("#pf-status").is (':checked')) ? pfStatus = 0 : pfStatus = 1;
                // grossSalary = $('#gross-salary').value;
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });
            $(document).on('change', "#pf-status", function() {
                (this.checked) ? pfStatus = 0 : pfStatus = 1;
                ($("#tax-status").is (':checked')) ? taxStatus = 0 : taxStatus = 1;
                // grossSalary = $('#gross-salary').value;
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });

            $(document).on("keyup change", '.other-allowance-amount', function () {
                if($(this).val()){
                    $(this).closest('.amount').siblings('.remarks').find('#remarks').prop('required', true);
                }else{
                    $(this).closest('.amount').siblings('.remarks').find('#remarks').prop('required', false);
                }
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
            });

            $(document).on('change', '.other-allowance-type', function () {
                if ($(this).val()){
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount-c').removeClass('d-none');
                    if($(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val()){
                        $(this).closest('.col-sm-3').siblings('.remarks').find('#remarks').prop('required', true);
                    }else{
                        $(this).closest('.col-sm-3').siblings('.remarks').find('#remarks').prop('required', false);
                    }
                } else {
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount').val('');
                    $(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount-c').addClass('d-none');
                    $(this).closest('.col-sm-3').siblings('.remarks').find('#remarks').prop('required', false);
                }
                var grossSalary = ($(document).find('#gross-salary').val()) ? $(document).find('#gross-salary').val() : 0;
                var pfStatus = ($(document).find('#pf-status').is (':checked')) ? pfStatus = 0 : pfStatus = 1;
                var taxStatus = ($(document).find('#tax-status').is (':checked')) ? taxStatus = 0 : taxStatus = 1;
                let result = otherAllowance();
                calculateSalary(grossSalary, pfStatus, taxStatus, result.addition, result.deduction);
                // salaryForm();
            });
        }

        function calculateSalary(grossSalary, pfStatus = 1, taxStatus = 1, addition, deduction) {
            console.log(addition)
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
            // console.log(taxDiduction);

            $('input[name="tax_percentage"]').val(tax);
            $('input[name="tax_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').find('input[name="tax"]').val(Number(taxDiduction).toFixed((2)));

            $('input[name="pf_percentage"]').val(pfSettings.amount);
            $('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').find('input[name="pf"]').val(Number(basicSalary*(pfSettings.amount/100)).toFixed((2)));

            if(taxStatus && !isNaN(taxStatus)){
                totalDiduction = parseInt(totalDiduction) + parseInt(taxDiduction);
                console.log('totalDiduction 1 ' +totalDiduction)
            }
            if(pfStatus && !isNaN(pfStatus)){
                if(!isNaN(parseInt($('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').children('input[name="pf"]').val()))){
                    totalDiduction = parseInt(totalDiduction) + parseInt($('input[name="pf_percentage"]').closest('.col-sm-4').siblings('.col-sm-4').children('input[name="pf"]').val());
                }
                console.log('totalDiduction 2 ' +totalDiduction)
            }


            if (deduction && !isNaN(deduction)){
                totalDiduction = parseInt(totalDiduction) + parseInt(deduction);
            }
            console.log('totalDiduction 3 ' +totalDiduction)

            netSalary = parseInt(grossSalary) - parseInt(totalDiduction);


            if(addition && !isNaN(addition)){
                netSalary = parseInt(netSalary) + parseInt(addition);
            }
            totalDiduction = isNaN(totalDiduction) ? 0 : totalDiduction;
            netSalary = isNaN(netSalary) ? grossSalary : netSalary;
            $('#total-gross').val(grossSalary);
            $('#total-diduction').val(totalDiduction);
            $('#net-salary').val(netSalary);

        }

        function otherAllowance(){
            // console.log($(this).closest('.col-sm-3').siblings('.amount').find('.other-allowance-amount-c').removeClass('d-none'))
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
    </script>

@endpush
