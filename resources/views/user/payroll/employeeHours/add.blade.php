<form class="kt-form" action="{{ route('update.salary.employee.hours') }}" method="POST">
    @csrf    
    @if(isset($hour_info))
        <input type="hidden" name="id" value="{{ $hour_info->id }}" />
    @endif
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Employee ID</label>
                <input {{ isset($hour_info) ? 'disabled' : '' }} type="text" class="form-control" autocomplete="off" required placeholder="Enter text" name="employee_id" value="{{ isset($hour_info) ? $hour_info->employee_id : '' }}"/>
            </div>
            <div class="col-sm-4">
                <label>Date</label>
                <input type="date" class="form-control" max="12" autocomplete="off" required placeholder="" {{ isset($hour_info) ? 'disabled' : '' }} name="date" value="{{ isset($hour_info) ? $hour_info->date : '' }}"/>
            </div>

            <div class="col-sm-4">
                <label>Hour Type</label>
                <select name="hour_type" class="form-control" {{ isset($hour_info) ? 'disabled' : '' }} id="">
                    <option value="0" {{ isset($hour_info) ? $hour_info->type == 0 ? 'selected':'':'' }}>Regular</option>
                    <option value="1" {{ isset($hour_info) ? $hour_info->type == 1 ? 'selected':'':'' }}>Adjusted</option>
                    <option value="2" {{ isset($hour_info) ? $hour_info->type == 2 ? 'selected':'':'' }}>Overtime</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Ready Hour</label>
                <input type="time" class="form-control" autocomplete="off" required placeholder="" name="ready_hour" value="{{ isset($hour_info) ? $hour_info->ready_hour : '' }}"/>
            </div>
            <div class="col-sm-4">
                <label>Lag Hour</label>
                <input type="time" class="form-control" autocomplete="off" required placeholder="" name="lag_hour" value="{{ isset($hour_info) ? $hour_info->lag_hour : '' }}"/>
            </div>
        </div>

        @if(isset($hour_info))
            <div class="form-group row">
                <div class="col-sm-12">
                    <label>Remarks</label>
                    <div class="input-group">
                        <textarea name="remarks" required class="form-control" id="" cols="30" rows="2">{{ isset($hour_info) ? $hour_info->remarks : '' }}</textarea>
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