<!--begin::Form-->
<form class="kt-form" action="{{ route('employee.team.member.save') }}" method="POST">

    @csrf

    <div class="kt-portlet__body row">
        <div class="col-xl-6">
        <div class="form-group">
            <input type="hidden" name="team_id" value="{{ $id }}">

            <label for="team_lead_id">Team Member</label>
            <select id="team_lead_id" name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                <option value="">Select</option>
                @foreach ($employees as $employee)
                    <option value="{{$employee->id}}"
                            data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }}
                        - {{ $employee->FullName }}
{{--                        @if($employee->teamMember)--}}
{{--                            @foreach($employee->teamMember as $team)--}}
{{--                            <span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">--}}
{{--                                    {{ $team->name  }}--}}
{{--                            </span>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                    </option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label>Team Join Date</label>
                <div class="input-group date">
                    <input type="text" class="form-control kt_datepicker_3" autocomplete="off" required placeholder="Team Join Date"  name="created_at"
                           value="{{old('created_at')}}"/>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
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







