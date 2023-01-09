<!--begin::Form-->


<input type="hidden" id="salary-breakdown-settings" value="{{ $salary_breakdown_settings }}">
<input type="hidden" id="tax-settings" value="{{ $tax_settings }}">
<input type="hidden" id="pf-settings" value="{{ $pf_settings }}">

<form class="kt-form kt-form--label-right" id="salary-form" enctype="multipart/form-data" method="POST" action="{{ route('manage.salary.employee.create') }}">
    @csrf

    <input type="hidden" name="employee_id" value="{{ $employee_id }}">
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
                    {{-- <span class="pull-right"><a href="{{ route('add.new.bank') }}" class="btn btn-outline-success" style="position: relative; top: 12px;">Add New Bank</a></span> --}}
                </div>


                <div class="kt-portlet__body ">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Name:</label>
                                <select id="bank" name="bank_info_id" class="form-control" >
                                    <option value="">Select</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Branch Name:</label>
                                <select id="branch" name="bank_branch_id" class="form-control" >
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Routing:</label>
                                <input class="form-control" type="text" value="" id="bank-routing" name="" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Account Type:</label>
                                <select name="bank_account_type" class="form-control" >
                                    <option value="">Select</option>
                                    <option value="1">Prepaid/Payroll</option>
                                    <option value="2">Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Bank Account:</label>
                                <input class="form-control" type="text" value=""  name="bank_account" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Applicable Form:</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control kt_datepicker_3" autocomplete="off" required placeholder="Select date" id="" name="applicable_from" value=""/>
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
                                <label>Gross Salary:</label>
                                <input class="form-control" type="text" value="" id="gross-salary" name="gross_salary" required>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{ $salary_type }}">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Payment Type:</label>
                                <select  name="payment_type_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($payment_types as $item)
                                        <option value="{{ $item->id }}">{{ $item->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Overtime:</label>
                                <select  name="overtime_status" class="form-control" required>
                                    <option selected value="0">Not applicable</option>
                                    <option value="1">Applicable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>KPI:</label>
                                <select id="kpi_status" name="kpi_status" class="form-control" required>
                                    <option selected value="0">Not applicable</option>
                                    <option value="1">Applicable</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                @if($employmentType == 'Permanent')
                                    <input type="hidden" name="pay_cycle_id" value="2">
                                @else
                                    <input type="hidden" name="pay_cycle_id" value="1">
                                @endif
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
                    <div class="row">
                        <div class="offset-sm-9 col-sm-3 d-none kpiratediv">
                            <div class="form-group">
                                <label>KPI Rate:</label>
                                <input class="form-control" type="text" value="" id="kpirate" name="kpi_rate">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end::Portlet-->


        {{--                         Allowances--}}

        <div class="col-sm-6">
            @if($employmentType == 'Permanent')
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Fixed Allowances
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="kt-portlet__body">
                        @foreach($salary_breakdown_settings as $item)
                            <div class="form-group row">
                                <label class="col-sm-12 text-left">{{ $item->name }}:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="" name="allowances_amount[]" readonly>
                                    <input class="form-control" type="hidden" value="{{ $item->name }}" name="allowances_name[]">
                                    <input class="form-control" type="hidden" value="{{ $item->is_basic }}" name="allowances_is_basic[]">
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control " type="text" value="{{ $item->percentage }}" name="allowances_percentage[]" readonly>
                                </div>
{{--                                <div class="col-sm-1"><span title="Percentage" style="font-size: 16px; margin: -15px; ">%</span></div>--}}
                            </div>

                        @endforeach
                    </div>
                </div>
            @endif

                {{-- other allowance --}}
                <div class="kt-portlet">
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
                        </div>
                    </div>


                    <div class="kt-portlet__body">
                        <div id="kt_repeater_2">
                            <div class="form-group form-group-last row" id="kt_repeater_2">

                                <div data-repeater-list="other_allowance" class="col-lg-12">
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
                </div>
        </div>
        <!--end::Portlet-->

        <div class="col-sm-6">

            {{--                             Diduction--}}
            @if($employmentType == 'Permanent')

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Diduction
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label class="col-sm-12 text-left">Provident Fund Deduction:</label>
                            <div class="col-sm-4">
                                <input class="form-control " type="text" value="" name="pf">
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control " type="text" value="" name="pf_percentage">
                            </div>
                            <div class="col-md-2">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-2">
                                        <input type="checkbox" id="pf-status" name="pf_status"> Disable
                                        <span></span>
                                    </label>
                                </div>
                                <div class="d-md-none kt-margin-b-10"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 text-left">Tax Deduction:</label>
                            <div class="col-sm-4">
                                <input class="form-control " type="text" value="" name="tax">
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control " type="text" value="" name="tax_percentage">
                            </div>
                            <div class="col-md-2">
                                <div class="kt-checkbox-list">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success mt-2">
                                        <input type="checkbox" id="tax-status" name="tax_status"> Disable
                                        <span></span>
                                    </label>
                                </div>
                                <div class="d-md-none kt-margin-b-10"></div>
                            </div>
                        </div>

                    </div>

                </div>
            @endif



            {{--                             Salary Details--}}

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <div class="row">
                            <div class="col-sm-12">
                                <div>
                                    <h3 style="float: left;" class="kt-portlet__head-title">
                                        Total Salary Details
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="kt-portlet__body">
                    <div class="form-group row">
                        <label class="col-sm-12 text-left">Gross Salary:</label>
                        <div class="col-sm-12">
                            <input class="form-control " id="total-gross" type="text" value="" name="" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 text-left">Total Deduction:</label>
                        <div class="col-sm-12">
                            <input class="form-control " id="total-diduction" type="text" value="" name="total_deduction" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 text-left">Net Salary:</label>
                        <div class="col-sm-12">
                            <input class="form-control " id="net-salary" type="text" value="" name="payable" readonly>
                        </div>
                    </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit"
                                        class="btn btn-primary pull-right">
                                    <i class="la la-edit"></i>
                                    Update Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end::Portlet-->
</form>
<!--end::Form-->



