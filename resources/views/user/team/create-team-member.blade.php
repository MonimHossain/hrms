


            <!--begin::Form-->
            <form class="kt-form" action="{{ route('user.team.member.save') }}" method="POST">

                @csrf
                <div class="kt-portlet__body">
                    <div class="form-group">
                        <input type="hidden" name="team_id" value="{{ $id }}">

                        <label for="team_lead_id">Team Member</label>
                        <select id="team_lead_id" name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                            <option value="">Select</option>
                            @foreach ($employees as $employee)
                            <option value="{{$employee->id}}" data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                            @endforeach
                        </select>
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
                <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
            @endpush

            @push('js')
            <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
            @endpush







