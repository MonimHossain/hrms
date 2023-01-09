<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('user.closing.approval.status.change', ['id'=>$id, 'flag'=>$flag]) }}" method="POST"  enctype="multipart/form-data">
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
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" checked="checked" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'] }}" name="approval_status" class="is_fixed_officetime">
                    Approved
                    <span></span>
                </label>
                <br>
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['rejected'] }}"  name="approval_status" class="is_fixed_officetime">
                    Rejected
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
                            class="btn btn-primary">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
