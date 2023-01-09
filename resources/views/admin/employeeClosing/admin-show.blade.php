<?php echo $checklist->questions; ?>
<br>
<br>


<form class="kt-form" action="{{ route('request.clearance.admin.approved', ['id'=>$id]) }}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-xl-12">
            <div class="form-group">
                <label>Remarks</label>
                <div class="input-group">
                    <textarea name="remarks" class="form-control" id="" cols="30" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="form-group">
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" checked="checked" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'] }}" name="approval_status" class="is_fixed_officetime"> Is
                    Approved
                    <span></span>
                </label>
                <br>
                <label class="kt-radio kt-radio--tick kt-radio--success"><input
                        type="radio" value="{{ \App\Utils\EmployeeClosing::ApprovedFrom['approval']['rejected'] }}"  name="approval_status" class="is_fixed_officetime"> Is
                    Rejected
                    <span></span>
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="kt-form__actions">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


