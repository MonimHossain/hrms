
 <form class="kt-form kt-form--label-right" enctype="multipart/form-data" method="POST"
 action="{{ route('admin.hiring.request.update', [$id]) }}">
    <div class="kt-portlet__body">
    <div class="row">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group col-md-12">
            <label class="">Status</label>
            <div class="custom-file">
                <select name="status" id="" class="form-control">
                    <option value="">Select</option>
                    <option value="1">Processing</option>
                    <option value="2">Reject</option>
                    <option value="3">Done</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label class="">Remarks</label>
            <div class="custom-file">
                <textarea name="remarks" id="" class="form-control" cols="100" rows="2"></textarea>
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
