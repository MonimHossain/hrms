<form class="kt-form" action="{{ route('employee.hierarchy.save') }}" method="POST">
     @csrf
    <div class="form-group validated">
        <label for="inputWarning" class="form-control-label">Employee Name:</label>
        <input type="hidden" name="parent_id" value="{{ $id }}">
        <div class="input-group">
            <select name="employee_id" id="inputWarning" class="form-control select2-container--bootstrap">
                <option value="">Select</option>
                @foreach ($employees as $employee)
                <option value="{{$employee->id}}">{{ $employee->first_name }} {{ $employee->first_name }}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="modal-footer">
        <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
    </div>
</form>
