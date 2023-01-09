@extends('layouts.container')

@section('content')



    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        Create New Team
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">


                <!--begin::Form-->
                <form class="kt-form center-division-form" action="{{ route('employee.team.save') }}" method="POST">
                    @csrf

                    <div class="kt-portlet__body">

                        <div class="form-group row @error('name') validated @enderror  @error('team_lead_id') validated @enderror">
                            <div class="col-sm-4">
                                <label>Team Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" aria-describedby="nameHelp" placeholder="Enter Team Name"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-4">

                                <label for="team_lead_id">Head of Team</label>
                                <select class="form-control kt-selectpicker @error('team_lead_id') validated @enderror" data-live-search="true" id="team_lead_id"
                                        name="team_lead_id" required>
                                    <option value="">Select</option>
                                </select>
                                @error('team_lead_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-sm-4">
                                <label>Team Create Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" autocomplete="off" required placeholder="Team Create Date" id="kt_datepicker_3" name="created_at"
                                           value="{{old('created_at')}}"/>
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row @error('division_id') validated @enderror @error('center_id') validated @enderror ">

                            <div class="col-sm-4">
                                <label for="reporting_to_id_two">Parent Team (If required)</label>
                                <select class="form-control kt-selectpicker parent_id" data-live-search="true" id="parent_id"
                                        name="parent_id">
                                    <option value="">Select</option>
                                    @foreach ($teams as $team)
                                        <option value="{{$team->id}}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-4">
                                <label for="division">Division</label>
                                <select class="form-control division" id="" name="division_id" required>
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="center">Center</label>
                                <select class="form-control center" id="" name="center_id" required>
                                    <option value="">Select Center</option>
                                </select>
                                @error('center_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('department_id') validated @enderror @error('process_id') validated @enderror  @error('process_segment_id') validated @enderror">

                            <div class="col-sm-4">
                                <label for="department">Department</label>
                                <select class="form-control department @error('department_id') validated @enderror" id=""
                                        name="department_id" required>
                                    <option value="">Select Department</option>
{{--                                    @foreach ($departments as $department)--}}
{{--                                        <option value="{{$department->id}}">{{ $department->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="process">Process</label>
                                <select class="form-control process @error('process_id') validated @enderror" id="process" name="process_id">
                                    <option value="">Select Process</option>
{{--                                    @foreach ($processes as $process)--}}
{{--                                        <option {{ (old('process_id') == $process->id) ? 'selected' : '' }} value="{{$process->id}}">--}}
{{--                                            {{ $process->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>
                                @error('process_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-sm-4">
                                <label for="process">Process Segment</label>
                                <select class="form-control process-segment @error('process_segment_id') validated @enderror" id="processSegment" name="process_segment_id">
                                    <option value="">Select Process Segment</option>
                                </select>
                                @error('process_segment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="reporting_to_id_one">Supervisor 1</label>
                                <select class="form-control kt-selectpicker reporting_to" data-live-search="true" id="reporting_to_id_one" name="supervisor[]">
                                    <option value="">Select</option>
                                    @foreach ($reportingTo as $employee)
                                        <option value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supervisor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-4">
                                <label for="reporting_to_id_two">Supervisor 2</label>
                                <select class="form-control kt-selectpicker reporting_to" data-live-search="true" id="reporting_to_id_two"
                                        name="supervisor[]">
                                    <option value="">Select</option>
                                    @foreach ($reportingTo as $employee)
                                        <option value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supervisor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="reporting_to_id_three">Supervisor 3</label>
                                <select class="form-control kt-selectpicker reporting_to" data-live-search="true" id="reporting_to_id_three"
                                        name="supervisor[]">
                                    <option value="">Select</option>
                                    @foreach ($reportingTo as $employee)
                                        <option value="{{$employee->id}}">{{ $employee->employer_id }} - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supervisor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row @error('parent_id') validated @enderror @error('is_functional') validated @enderror">
                            <div class="col-sm-4">
                                <label>Is functional?</label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" name="is_functional" value="1" required> Yes
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" name="is_functional" value="0"> No
                                        <span></span>
                                    </label>
                                </div>
                                @error('is_functional')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>

                <!--end::Form-->

            </div>
        </div>
    </div>
@endsection



@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    @include('layouts.partials.includes.division-center')

    <script>

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

        addSelect2Ajax('#team_lead_id', "{{route('employee.all')}}");
    </script>

    <script>
        $(document).on('change', '#process', function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('get.all.segment') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function (data) {
                    $('#processSegment').html(data);
                }

            });
        });

        $(document).on('change', '#team_lead_id', function () {
            let report_one = $('#reporting_to_id_one').val();
            let report_two = $('#reporting_to_id_two').val();
            let report_three = $('#reporting_to_id_three').val();
            let team_lead_id = $('#team_lead_id').val();
            if (team_lead_id) {
                if (team_lead_id == report_one || team_lead_id == report_two || team_lead_id == report_three) {
                    alert('Head of Team must be different');
                    $('#team_lead_id').val("").selectpicker("refresh");
                }
            }
        });


        $(document).on('change', '#reporting_to_id_one', function () {
            let report_one = $('#reporting_to_id_one').val();
            let report_two = $('#reporting_to_id_two').val();
            let report_three = $('#reporting_to_id_three').val();
            let team_lead_id = $('#team_lead_id').val();
            if (report_one) {
                if (report_one == report_two || report_one == report_three || report_one == team_lead_id) {
                    alert('Supervisor must be different');
                    $('#reporting_to_id_one').val("").selectpicker("refresh");
                }
            }
        });

        $(document).on('change', '#reporting_to_id_two', function () {
            let report_one = $('#reporting_to_id_one').val();
            let report_two = $('#reporting_to_id_two').val();
            let report_three = $('#reporting_to_id_three').val();
            let team_lead_id = $('#team_lead_id').val();
            if (report_two) {
                if (report_one == report_two || report_two == report_three || report_two == team_lead_id) {
                    alert('Supervisor must be different');
                    $('#reporting_to_id_two').val("").selectpicker("refresh");
                }
            }
        });

        $(document).on('change', '#reporting_to_id_three', function () {
            let report_one = $('#reporting_to_id_one').val();
            let report_two = $('#reporting_to_id_two').val();
            let report_three = $('#reporting_to_id_three').val();
            let team_lead_id = $('#team_lead_id').val();
            if (report_three) {
                if (report_one == report_three || report_two == report_three || report_three == team_lead_id) {
                    alert('Supervisor must be different');
                    $('#reporting_to_id_three').val("").selectpicker("refresh");
                }
            }
        });
    </script>


    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/metronic-datatable/base/html-table.js') }}" type="text/javascript"></script>

@endpush


