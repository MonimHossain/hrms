
<form class="kt-form" action="{{ route('loam.application.update',['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PATCH" />

    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Select Loan Type</label>
                <select class="form-control kt-selectpicker" data-live-search="true" id="loan_type" name="loan_type" required>
                    <option value="">Select</option>
                    @foreach($loanTypes as $type)
                        <option {{ ($rowField->loan_type == $type->id) ? 'selected="selected"':'' }} value="{{ $type->id }}">{{ $type->loan_type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4">
                <label for="team_lead_id">Set Interval (Month)</label>
                <select class="form-control" data-live-search="true" id="interval"
                        name="interval" required>
                        <option selected="selected" value="{{ $rowField->interval }}">{{ $rowField->interval }}</option>
                </select>
            </div>


        </div>


        <div class="form-group row">
            <div class="col-sm-4">
                <label>Amount</label>
                <div class="input-group">
                    <input type="text" class="form-control" autocomplete="off" required placeholder="Enter Amount" name="amount"
                           value="{{ $rowField->amount }}"/>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <label>Remarks</label>
                <div class="input-group">
                    <textarea name="remarks" required class="form-control" id="" cols="30" rows="2">{{ $rowField->remarks }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <div class="kt-radio-inline">
                    <label class="kt-checkbox">
                        <input type="checkbox" name="terms" value="" required> I have read loan's terms and condition
                        <span></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <span id="termAndCondition" style="color:#2dbdb6"></span>
            </div>
        </div>

        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>
</form>

