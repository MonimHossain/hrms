 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('payroll.salary.hold.store') }}">
        {{ csrf_field() }}
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Employee</label>
                    <div class="custom-file">
                        <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($emoloyees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
             </div>

             <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Salary Hold Reason</label>
                    <div class="custom-file">
                        <select name="hold_reason" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach(\App\Utils\Payroll::SALARYHOLDREASON as $key=>$value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
             </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Month</label>
                    <div class="custom-file">
                        <input readonly autocomplete="off" type="text" name="month" value="" class="form-control month-pick">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Remarks </label>
                    <div class="custom-file">
                        <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <br>

        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="form-group col-md-8">
                        <button type="submit" class="btn btn-brand">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
