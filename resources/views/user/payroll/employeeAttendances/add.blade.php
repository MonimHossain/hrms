<form class="kt-form" action="{{ route('save.salary.employee.attendance') }}" method="POST">
    @csrf    
    <div class="kt-portlet__body">

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Employee ID</label>
                <input type="text" class="form-control" autocomplete="off" required placeholder="Enter text" name="employee_id" value=""/>
            </div>
            <div class="col-sm-4">
                <label>Date</label>
                <input type="date" class="form-control" max="12" autocomplete="off" required placeholder="" name="date" value="{{ isset($hour_info) ? $hour_info->date : '' }}"/>
            </div>

            <div class="col-sm-4">
                <label>Attendance Type</label>
                <select name="attendance_type" class="form-control" id="">
                    <option value="">All</option>

                    <option  value="P">P</option>
                    <option  value="A">A</option>
                    <option  value="HD">HD</option>
                    <option  value="HDP">HDP</option>
                    <option  value="GH">GH</option>
                    <option  value="ADO">ADO</option>
                    <option  value="LWP">LWP</option>
                    <option  value="L">L</option>
                    <option  value="W">W</option>
                    <option  value="Off">Off</option>
                  
                </select>
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


 /*Employee List*/
function addSelect2Ajax($element, $url, $changeCallback, data) {
    var placeHolder = $($element).data('placeholder');

    if (typeof $changeCallback == 'function') {
        $($element).change($changeCallback)
    }

    // $($element).hasClass('select2') && $($element).select2('destroy');

    return $($element).select2({
        allowClear: true,
        width: "resolve",
        ...data,
        placeholder: placeHolder,
        ajax: {
            url: $url,
            data: function (params) {
                return {
                    keyword: params.term,
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj, index) {
                        return {id: obj.id, text: obj.name};
                    })
                };
            }
        }
    });

}

addSelect2Ajax('#employees', "{{route('employee.all')}}");
</script>