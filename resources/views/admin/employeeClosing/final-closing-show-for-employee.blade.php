<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('user.request.clearance.hr.final.approval.change.status', ['id'=>$id]) }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-12">
                <p>
                    {!! $closingApplication->application !!}
                </p>
            </div>
        </div>

        <div class="form-group row">
            <div class="form-group">
                <label class="kt-checkbox kt-checkbox--tick kt-radio--success"><input
                        type="checkbox" checked="checked" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['final']['true'] }}" name="approval_status" class="is_fixed_officetime">
                    Are You Sure ?
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-4">
                    <button type="submit"
                            class="btn btn-primary">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


