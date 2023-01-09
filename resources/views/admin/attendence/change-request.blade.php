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
                                Attendance Change Requests
                            </h3>
                        </div>

                    </div>


                    <div class="kt-portlet__body" >
                        <div class="kt-section dtHorizontalExampleWrapper ">

                            <form class="kt-form" action="{{ route('employee.attendance.change.approval') }}" method="get">
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label for="team_lead_id">Head of Team</label>
                                            <select class="form-control kt-selectpicker" data-live-search="true" id="employee_id" name="employee_id"
                                                    name="team_lead_id" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <div class="kt-form__actions" style="margin-top: 26px;">
                                                <button type="submit" class="btn btn-primary">Find</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            @if($changeRequests->count() == 0)
                            <div class="alert alert-warning fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">No request data!</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                    </button>
                                </div>
                            </div>

                            @else

                            <table class="table table-bordered table-striped table-hover table-condensed" id="" width="100%">
                                <thead>
                                    <tr>
                                        {{-- <th class="bold">Employee</th>
                                        <th class="bold">Date</th>
                                        <th class="bold">Roster</th>
                                        <th class="bold">Attendance</th>
                                        <th class="bold">Out of Office</th>
                                        <th class="bold">Is ADO</th>
                                        <th class="bold">Remarks</th>
                                        <th class="bold">First Approved</th>
                                        <th class="bold">Final Approved</th>
                                        <th class="bold">Action</th> --}}
                                        <th class="bold">Employee</th>
                                        <th class="bold">Date</th>
                                        <th class="bold">Request Type</th>
                                        <th class="bold">Time</th>
                                        <th class="bold">Remarks</th>
                                        <th class="bold">First Approved</th>
                                        <th class="bold">Final Approved</th>
                                        <th class="bold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($changeRequests) }} --}}
                                    @foreach($changeRequests as $item)
                                    <tr>
                                        <td>{{ $item->employee->FullName }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ ($item->status == 1) ? 'Roster Change' : (($item->status == 2) ? 'Attendance Change' : '')}}</td>
                                        {{-- <td>{{ ($item->roster_start) ? \Carbon\Carbon::parse($item->roster_start)->format('H:i:s') : '' }} - {{  ($item->roster_end) ? \Carbon\Carbon::parse($item->roster_end)->format('H:i:s') : '' }}</td>
                                        <td>{{ ($item->punch_in) ? \Carbon\Carbon::parse($item->punch_in)->format('H:i:s') : '' }} - {{ ($item->punch_out) ? \Carbon\Carbon::parse($item->punch_out)->format('H:i:s') : '' }}</td> --}}
                                        <td>
                                        @if ($item->status == 1 && $item->is_adjusted_day_off != 1)
                                        {{ \Carbon\Carbon::parse($item->roster_start)->format('H:i:s') }} - {{ \Carbon\Carbon::parse($item->roster_end)->format('H:i:s') }}
                                        @elseif ($item->status == 1 && $item->is_adjusted_day_off == 1)
                                        Adjusted Dayoff
                                        @elseif ($item->status == 2)
                                        {{ \Carbon\Carbon::parse($item->punch_in)->format('H:i:s') }} - {{ \Carbon\Carbon::parse($item->punch_out)->format('H:i:s') }} @if (($item->out_of_office)) ({{ $item->out_of_office}}) @endif
                                        @endif
                                        </td>
                                        <td>{{ $item->remarks }}</td>
                                        <td>{{ _lang('attendance.change_request', $item->first_approve_status) }}</td>
                                        <td>{{ _lang('attendance.change_request', $item->final_approve_status) }}</td>
                                        <td>
                                            @if($item->final_approve_status == \App\Utils\AttendanceChangeStatus::PENDING)
                                            <form action="{{ route('employee.attendance.change.approval') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="change_id" value="{{ $item->id }}">
                                                <button type="submit" name="submit" value="approve" class="change_request text-success btn btn-icon"><i class="flaticon2-check-mark"></i></button> |
                                                <button type="submit" name="submit" value="reject" class="change_request text-danger btn btn-icon"><i class="flaticon2-cross"></i></button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $changeRequests->links() }}

                            @endif

                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection




@push('css')
       <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .btn.btn-icon {
            height: 1rem;
            width: 1rem;
        }
    </style>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    {{--        <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>--}}

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

        addSelect2Ajax('#employee_id', "{{route('employee.all')}}");
    </script>
@endpush
