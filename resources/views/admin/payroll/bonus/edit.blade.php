 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('payroll.bonus.update', ['id'=>$id]) }}">
        {{ csrf_field() }}

        <input type="hidden" name="_method" value="put">
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-8">
                    <div class="custom-file">
                        <span>Name: {{ $rows->employee->FullName }}</span> <br>
                        <span>Designation: {{ $rows->employee->employeeJourney->designation->name }}</span> <br>
                        <span>Employment Type: {{ $rows->employee->employeeJourney->employmentType->type }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Bonus Name</label>
                    <div class="custom-file">
                        <input type="text" name="name" class="form-control" id="" value="{{ $rows->name }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Bonus Month</label>
                    <div class="custom-file">
                        <input type="text" name="month" class="form-control month-pick" value="{{ \Carbon\Carbon::parse($rows->month)->format('Y-m') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Amount</label>
                    <div class="custom-file">
                        <input type="number" name="amount" class="form-control" value="{{ $rows->amount }}">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">&nbsp;</label> <br>
                    <div class="kt-radio-inline">
                        <label class="kt-radio"><input type="radio" value="{{ \App\Utils\Payroll::BONUS['type']['Percentage'] }}" {{ ($rows->type === \App\Utils\Payroll::BONUS['type']['Percentage'])? 'checked="checked"':'' }} name="type" class="bonusType">{{ _lang('payroll.bonus.type', \App\Utils\Payroll::BONUS['type']['Percentage']) }}<span></span></label>
                        <label class="kt-radio"><input type="radio" value="{{ \App\Utils\Payroll::BONUS['type']['Fixed'] }}" {{ ($rows->type === \App\Utils\Payroll::BONUS['type']['Fixed'])? 'checked="checked"':'' }} name="type" class="bonusType">{{ _lang('payroll.bonus.type', \App\Utils\Payroll::BONUS['type']['Fixed']) }}<span></span></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Remarks</label>
                    <div class="custom-file">
                        <textarea name="remarks" id="" class="form-control" cols="30" rows="2">{{ $rows->remarks }}</textarea>
                    </div>
                </div>
             </div>
            <br>
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





