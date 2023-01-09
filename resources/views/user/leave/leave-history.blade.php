@extends('layouts.container')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Leave History
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <form class="kt-form" action="{{ route('team.leave.history') }}" method="get">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Team</label>
                                            <div class="input-group date">
                                                <select required id="team_lead_id" name="team" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach ($teams as $team)
                                                        <option {{ ($team->id == Request::get('team')) ? 'selected':'' }} value="{{$team->id}}" data-tokens="{{ $team->name }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group date">
                                                <select id="employee_id" name="employee_id" class="form-control" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach ($employees as $employee)
                                                        <option {{ ($employee->id == Request::get('employee_id')) ? 'selected':'' }} value="{{$employee->id}}" data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }} - {{ $employee->FullName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control date_from" readonly placeholder="Select Start Date"
                                                       id="kt_datepicker_3" name="date_from" value="{{ Request::get('date_from') }}" />
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control date_to" readonly placeholder="Select End Date"
                                                       id="kt_datepicker_3" name="date_to" value="{{ Request::get('date_to') }}" />
                                                <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions" >
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                                <button type="reset" class="btn btn-secondary reset-button">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped custom-table table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Number Of Application</th>
                                            <th>Quantity (Day)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($employeeCollection))
                                        @foreach($employeeCollection as $employee)
                                        <tr>
                                            <td>
                                                {{ $employee->employer_id }}
                                            </td>
                                            <td>
                                                {{ $employee->FullName }}
                                            </td>
                                            <td>
                                                {{ (isset($employee->leaves[0]))? str_replace('.0', '',$employee->leaves[0]->numberApplication):0 }}
                                            </td>
                                            <td>
                                                {{ (isset($employee->leaves[0]))? str_replace('.0', '',$employee->leaves[0]->totalLeave):0 }}
                                            </td>
                                            <td class="text-bold text-center">
                                                <a title="Leave Details" target="_blank" href="{{ route('leave.list', ['id'=>$employee->id]) }}" class="btn-sm btn-primary">Leave Details</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                     @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!--end::Form-->


                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
    <script>
       $('.kt-form').on('click', '.reset-button', function (e) {
           $('#team_lead_id').prop("selected", false);
           $('#employee_id').prop("selected", false);
           $('.date_from').val('');
           $('.date_to').val('');
       });


       $(document).on('change', '#team_lead_id', function()
       {
           var id = $(this).val();
           $.ajax({
               url: "{{ route('leave.employee.list') }}",
               type: 'POST',
               data: {"_token": "{{ csrf_token() }}","id": id},
               success: function(data) {
                    var result = JSON.parse(data);
                   $.each(result, function (i, value) {

                       var div_data = "<option value=" + value.id + ">" + value.first_name + "</option>";

                       $('#employee_id').hrml(div_data);

                   });
               }
           });
       });
    </script>
@endpush
