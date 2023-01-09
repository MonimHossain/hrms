<form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST" action="{{ route('payroll.tax.store') }}">
    @csrf
    <div class="kt-portlet__body">
        <div class="row">
           <div class="form-group col-md-12">
                <label class="">File Select</label>
                <input type="file" name="file" class="form-control">
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-brand">Upload</button>
                </div>
            </div>
        </div>
    </div>
</form>
