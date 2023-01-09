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
                            <table class="table table-bordered table-striped table-hover table-condensed" id="" width="100%">
                                <thead>
                                    <tr>
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
                                            @if($item->first_approve_status == \App\Utils\AttendanceChangeStatus::PENDING)
                                            <form action="{{ route('user.attendance.change.approval') }}" method="POST">
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

                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection




@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
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
        var arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }

        // enable clear button
        $('.kt_datepicker_3').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            showOn: 'none',
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm-dd',
        });
    </script>
@endpush
