<form class="kt-form" action="{{ route('settings.manage.center.update.department', ['id'=>$id]) }}" method="POST">
    <input name="_method" type="hidden" value="PUT">

    @csrf

    <div class="kt-portlet__body row">
        <div class="col-xl-6">
            <div class="form-group">

                <label for="team_lead_id">Department</label>
                <select id="team_lead_id" name="department[]" class="form-control kt-selectpicker" multiple>
                    @foreach ($departments as $department)
                        <option {{ in_array($department->id, $selectDepartment) ? 'selected':'' }} value="{{$department->id}}" data-tokens="{{ $department->name }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <button type="submit" class="btn btn-outline-success">Save</button>
            <button type="reset" class="btn btn-outline-info">Reset</button>
        </div>
    </div>
</form>


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    {{--    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>--}}
@endpush


