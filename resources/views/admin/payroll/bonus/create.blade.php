 <!--begin::Form-->
    <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
          action="{{ route('payroll.bonus.store') }}">
        {{ csrf_field() }}
        <div class="kt-portlet__body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Employment Type</label>
                    <div class="custom-file">
                        <select name="employmentType" class="form-control kt-selectpicker" id="" data-live-search="true">
                            <option value="">Select</option>
                            @foreach($emoloymentTypes as $emoloymentType)
                                <option value="{{ $emoloymentType->id }}">{{ $emoloymentType->type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Bonus Name</label>
                    <div class="custom-file">
                        <input type="text" name="name" class="form-control" id="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Bonus Month</label>
                    <div class="custom-file">
                        <input type="text" name="month" class="form-control month-pick">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Amount</label>
                    <div class="custom-file">
                        <input type="number" name="amount" class="form-control">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="">&nbsp;</label> <br>
                    <div class="kt-radio-inline">
                        <label class="kt-radio"><input type="radio" value="{{ \App\Utils\Payroll::BONUS['type']['Percentage'] }}" name="type" class="bonusType">{{ _lang('payroll.bonus.type', \App\Utils\Payroll::BONUS['type']['Percentage']) }}<span></span></label>
                        <label class="kt-radio"><input type="radio" value="{{ \App\Utils\Payroll::BONUS['type']['Fixed'] }}" checked="checked" name="type" class="bonusType">{{ _lang('payroll.bonus.type', \App\Utils\Payroll::BONUS['type']['Fixed']) }}<span></span></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label class="">Remarks</label>
                    <div class="custom-file">
                        <textarea name="remarks" id="" class="form-control" cols="30" rows="2"></textarea>
                    </div>
                </div>
             </div>
            <br>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-brand">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


