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
                        Update {{ $team->name }}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">


                <!--begin::Form-->
                <form class="kt-form center-division-form" action="{{ route('employee.team.update') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Team Name</label>
                                <input type="hidden" value="{{ $team->id }}" name="team_id">
                                <input type="text" class="form-control" name="name" aria-describedby="nameHelp"
                                       value="{{ $team->name }}" placeholder="Enter Team Name">
                            </div>

                            <div class="col-sm-4">
                                <input type="hidden" value="{{ $team->team_lead_id }}" id="team-lead">
                                <label for="team_lead_id">Head of Team</label>
                                {{-- .kt-selectpicker --}}
                                <select class="form-control " id="head-of-team" data-live-search="true"
                                        name="team_lead_id">
                                    @if(!$team->team_lead_id)
                                        <option value="">Select</option>
                                    @endif
                                        <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            value="{{$employee->id}}">{{ $employee->employer_id }}
                                            -
                                            {{ $employee->FullName }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-sm-4">
                                <label>Team Create Data</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly required placeholder="Team Create Data" id="kt_datepicker_3" name="created_at"
                                           value="{{ ($team->created_at) ? $team->created_at->format('Y-m-d') : '' }}"/>
                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-4">
                                <input type="hidden" value="{{ $team->parent_id }}" id="parent_id">
                                <label for="reporting_to_id_two">Parent Team (If required)</label>
                                <select class="form-control  parent_id" id="parent-team" data-live-search="true"
                                        name="parent_id">
                                    <option value="">Select</option>
                                    @foreach ($teams as $item)
                                        <option   value="{{$item->id}}">{{ $item->name }}</option>
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
                                        <option {{ ($team->division_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    @foreach($centers as $item)
                                        <option {{ ($team->center_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->center }}</option>
                                    @endforeach
                                </select>
                                @error('center_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-4">
                                <label for="department">Department</label>
                                <select class="form-control department" id="department"
                                        name="department_id" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $item)
                                        <option {{ ($team->department_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="process">Process</label>
                                <select class="form-control process" id="process"
                                        name="process_id">
                                    <option value="">Select Process</option>
                                    @if($processes)
                                    @foreach ($processes as $process)
                                        <option
                                            {{ ($team->process_id == $process->id) ? 'selected' : ' ' }}  value="{{ $process->id }}">
                                            {{ $process->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="process">Process Segment</label>
                                <select class="form-control process-segment" id="processSegment" name="process_segment_id">
                                    <option value="">Select Process Segment</option>
                                @if($team->process_segment_id && $segments)
                                    @foreach ($segments as $segment)
                                            <option
                                                {{ ($team->process_segment_id == $segment->id)?'selected="selected"':'' }}  value="{{ $segment->id }}">
                                                {{ $segment->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="reporting_to_id_one">Supervisor 1</label>
                                <select class="form-control kt-selectpicker" data-live-search="true"
                                        id="reporting_to_id_one" name="supervisor[]">
                                    @if(!((isset($supervisors[0]) && $supervisors[0]['supervisor_id'])))
                                        <option value="">Select</option>
                                    @endif
                                        <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            {{ (isset($supervisors[0]) && $supervisors[0]['supervisor_id'] == $employee->id)?'selected="selected"':'' }} value="{{$employee->id}}">{{ $employee->employer_id }}
                                            - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="reporting_to_id_two">Supervisor 2</label>
                                <select class="form-control kt-selectpicker" data-live-search="true"
                                        id="reporting_to_id_two"
                                        name="supervisor[]">
                                    @if(!((isset($supervisors[1]) && $supervisors[1]['supervisor_id'])))
                                        <option value="">Select</option>
                                    @endif
                                        <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            {{ (isset($supervisors[1]) && $supervisors[1]['supervisor_id'] == $employee->id)?'selected="selected"':'' }} value="{{$employee->id}}">{{ $employee->employer_id }}
                                            - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="reporting_to_id_three">Supervisor 3</label>
                                <select class="form-control kt-selectpicker" data-live-search="true"
                                        id="reporting_to_id_three"
                                        name="supervisor[]">
                                    @if(!((isset($supervisors[2]) && $supervisors[2]['supervisor_id'])))
                                        <option value="">Select</option>
                                    @endif
                                        <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            {{ (isset($supervisors[2]) && $supervisors[2]['supervisor_id'] == $employee->id)?'selected="selected"':'' }} value="{{$employee->id}}">{{ $employee->employer_id }}
                                            - {{ $employee->FullName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row @error('parent_id') validated @enderror @error('is_functional') validated @enderror">
                            <div class="col-sm-4">
                                <label>Is functional?</label>
                                <div class="kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" {{ ($team->is_functional == 1) ? 'checked' : '' }} name="is_functional" value="1" required> Yes
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" {{ ($team->is_functional == 0) ? 'checked' : '' }} name="is_functional" value="0"> No
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
                            <button type="submit" class="btn btn-primary">Update</button>
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
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/metronic-datatable/base/html-table.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>

    {{-- <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script> --}}
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('assets/js/demo1/pages/components/extended/sweetalert2.js') }}" type="text/javascript"></script> --}}
    @include('layouts.partials.includes.division-center')
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
    </script>
    <script !src="">
        $(document).ready(function () {
            let parent_id = $('#parent_id').val();
            $('#parent-team').selectpicker('val', [parent_id]);

            let team_lead = $('#team-lead').val();
            $('#head-of-team').selectpicker('val', [team_lead]);
        })
    </script>
@endpush


