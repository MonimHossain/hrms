<form class="kt-form" action="{{ route('upload.salary.employee.attendance.clearance.update') }}" method="POST">
    @csrf
    <div class="kt-portlet__body">

        <div class="form-group row">
            <input type="hidden" name="startDate" value="{{ $startDate }}">
            <input type="hidden" name="endDate" value="{{ $endDate }}">
            <div class="col-sm-12">
                <label>Remarks</label>
                <textarea name="remarks" id="" cols="30" rows="2" class="form-control"></textarea>
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


<script>

    $('.timepicker').datetimepicker({
        format: 'HH:mm'
    });
</script>
