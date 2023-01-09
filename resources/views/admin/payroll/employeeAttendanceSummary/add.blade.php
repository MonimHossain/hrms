<form class="kt-form" action="{{ route('update.salary.employee.hours') }}" method="POST">
    @csrf    
    @if(isset($attendance_info))
        <input type="hidden" name="id" value="{{ $attendance_info->id }}" />
    @endif
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Employee ID</label>
                <input {{ isset($attendance_info) ? 'disabled' : '' }} type="text" class="form-control" autocomplete="off" required placeholder="Enter text" name="employee_id" value="{{ isset($attendance_info) ? $attendance_info->employee_id : '' }}"/>
            </div>
            <div class="col-sm-4">
                <label>Month</label>
                <input type="month" class="form-control" max="12" autocomplete="off" required placeholder="" {{ isset($attendance_info) ? 'disabled' : '' }} name="date" value="{{ isset($attendance_info) ? $attendance_info->date : '' }}"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <label>Present</label>
                <input type="time" class="form-control" autocomplete="off" required placeholder="" name="present" value="{{ isset($attendance_info) ? $attendance_info->ready_hour : '' }}"/>
            </div>
            <div class="col-sm-2">
                <label>Holiday</label>
                <input type="time" class="form-control" autocomplete="off" required placeholder="" name="lag_hour" value="{{ isset($attendance_info) ? $attendance_info->lag_hour : '' }}"/>
            </div>
        </div>

        {{-- <div class="form-group">
            <div class="input-group date timepicker"
                data-date-format="HH:mm"
                data-date-useseconds="false"
                data-date-pickDate="false">

                <input type="text" name="" />
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
            </div>
        </div> --}}

        @if(isset($attendance_info))
            <div class="form-group row">
                <div class="col-sm-12">
                    <label>Remarks</label>
                    <div class="input-group">
                        <textarea name="remarks" required class="form-control" id="" cols="30" rows="2">{{ isset($attendance_info) ? $attendance_info->remarks : '' }}</textarea>
                    </div>
                </div>
            </div>
        @endif

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