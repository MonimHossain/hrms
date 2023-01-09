<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('user.request.clearance.hr.change.status', ['id'=>$id]) }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="kt-portlet__body">
        <div class="form-group">
            <div class="row">
                <div class="form-group"><label>Last Working Day</label>
                    <div class="input-group date"><input required type="text" readonly="readonly" placeholder="Select date" id=""
                                                         name="lwd" value="" class="form-control kt_datepicker_3"
                                                         aria-invalid="false">
                        <div class="input-group-append"><span class="input-group-text"><i
                                    class="la la-calendar-check-o"></i></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <p>
                {!! $closingApplication->application !!}
            </p>
        </div>
        <br>

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


