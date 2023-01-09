 <!--begin::Form-->

    <div class="row">
        <div class="paper col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning"><i
                                    class="fas fa-money-bill text-theme-2"></i></div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers"><p class="card-category">Gross Salary</p>
                                <p class="card-title">{{ $salary->gross_salary }}</p>
                                <p></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="paper col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning"><i
                                    class="fas fa-money-bill text-theme-2"></i></div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers"><p class="card-category">Payable Amount</p>
                                <p class="card-title" id="payableAmount">{{ $salary->payable_amount }}</p>
                                <p></p>
                                <input type="hidden" id="originalPayableAmount" value="{{ $salary->payable_amount }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label class="">Reason</label>
            <div class="custom-file">
                {{ $salaryHoldData['resoan'] ?? '' }}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="">Remarks</label>
            <div class="custom-file">
                {{ $salaryHoldData['remarks'] ?? '' }}
            </div>
        </div>
    </div>
    
    
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('salary.hold.release.update', [$id]) }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="">Employee</label>
                    <div class="custom-file">
                        {{ $salary->employee->employer_id }} - {{ $salary->employee->FullName }}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Adjustment Category</label>
                    <div class="custom-file">
                        <select name="adjustment_type" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($adjustmentType as  $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">Type</label>
                    <div class="custom-file">
                        <select name="type" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach(\App\Utils\Payroll::ADJUSTMENT['type'] as $key=> $value)
                                <option  value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label class="">Amount</label>
                    <div class="custom-file">
                        <input onkeyup="myFunction(this.value)" maxlength="8" type="number" name="amount" class="form-control" id="amount" value="" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group col-md-8">
                    <label class="">Remarks </label>
                    <div class="custom-file">
                        <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-brand">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->


