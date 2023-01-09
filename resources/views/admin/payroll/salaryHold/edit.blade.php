 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('payroll.salary.hold.update', ['id'=>$id]) }}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="put">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Employee</label>
                    <div class="custom-file">
                        <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($emoloyees as $employee)
                                <option {{ ($employee->id == $rows->employee_id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
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
                                <option {{ ($value == $rows->hold_reason)? 'selected="selected"':'' }} value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
             </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Month</label>
                    <div class="custom-file">
                        <input type="text" name="month" value="{{ \Carbon\Carbon::parse($rows->month)->format('Y-m') }}" class="form-control month-pick" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Remarks </label>
                    <div class="custom-file">
                        <textarea name="remarks" class="form-control" id="" cols="30" rows="2">{{ $rows->remarks }}</textarea>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Status</label>
                    <div class="custom-file">
                        <select name="status" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach(\App\Utils\Payroll::SALARYHOLD['status'] as $key=>$value)
                                <option {{ ($value == $rows->status)? 'selected="selected"':'' }} value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
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



