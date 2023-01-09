<form class="kt-form kt-form--label-right " id="leaveApplication" novalidate="novalidate"
      action="#" method="POST"  enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="put">
    <div class="kt-portlet__body">

        <span class="btn btn-danger">Required All setting for fnf generate!</span>

    </div>

    <br>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-4">
                    <ol>
                        <li>Check Permanet Employee</li>
                        <li>Salary Setting</li>
                        {{-- <li></li>
                        <li></li>
                        <li></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
</form>


