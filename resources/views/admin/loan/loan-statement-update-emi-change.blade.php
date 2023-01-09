<form action="{{ route('admin.loan.statement.update.emi.change', ['id'=>$id]) }}" method="post">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Ref No</label>
                <div class="input-group">
                    <span> <b>{{ $findAppHistory->loan->reference_id }}</b> </span>
                </div>
            </div>

            <div class="col-sm-4">
                <label>EMI Amount</label>
                <input type="text" name="emi_amount" class="form-control" id="emi_amount" value="{{ ($findAppHistory->amount) }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label><b>Employee's Requested Message</b></label>
                <p>{{ $findAppHistory->loan->loanGeneralApp->content }}</p>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <label>Remarks</label>
                <textarea name="remarks" required class="form-control" id="" cols="30" rows="2"></textarea>
            </div>
        </div>

            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <button type="submit" id="emi_update" class="btn btn-primary">Update</button>
                </div>
            </div>
    </div>
</form>




