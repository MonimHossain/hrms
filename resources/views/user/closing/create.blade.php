<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="{{ route('user.closing.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">

    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-lg-12">
                <label class="">Please fill up :</label>
                <textarea name="textarea" id="textarea" cols="30"
                          rows="3" class="form-control textarea" placeholder="" required>
                    {{ $rows->clearance_application_template ?? null }}
                </textarea>
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
