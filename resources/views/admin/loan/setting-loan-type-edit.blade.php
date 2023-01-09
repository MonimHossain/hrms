<form class="kt-form" action="{{ route('admin.loan.setting.type.update',['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PATCH" />

    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Loan Type</label>
                <input type="text" class="form-control" autocomplete="off" required placeholder="Enter text" name="loan_type" value="{{ $loanTypes->loan_type }}"/>
            </div>
            <div class="col-sm-4">
                <label>Interval</label>
                <input type="number" class="form-control" max="12" autocomplete="off" required placeholder="Enter max interval" name="interval" value="{{ $loanTypes->interval }}"/>
            </div>

            <div class="col-sm-4">
                <label>Max Amount</label>
                <input type="number" class="form-control" max="500000" autocomplete="off" required placeholder="Enter max amount" name="max_amount" value="{{ $loanTypes->max_amount }}"/>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-12">
                <label>Terms and Conditions</label>
                <div class="input-group">
                    <textarea name="terms_and_condition" required class="form-control" id="" cols="30" rows="2">{{ $loanTypes->content }}</textarea>
                </div>
            </div>
        </div>

        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>

    </div>
</form>
