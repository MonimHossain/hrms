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
                                Leave Use Report
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('admin.leave.status')  }}" method="get">

                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" required
                                                       placeholder="Select Date"
                                                       autocomplete="off"
                                                       id="kt_datepicker_3" name="date_from" value="{{ Request::get('date_from') }}"/>
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
                                                <input type="text" class="form-control" readonly
                                                       placeholder="Select Date"
                                                       autocomplete="off"
                                                       id="kt_datepicker_3" name="date_to" value="{{ Request::get('date_to') }}"/>
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
                                            <label>Department</label>
                                            <select name="department_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($departments as $item)
                                                    <option {{ ($item->id == Request::get('department_id')) ? 'selected':'' }}
                                                            {{--                                                    {{ (isset($departmentRequest) && $departmentRequest== $item->id) ? 'selected' : '' }}--}}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Process</label>
                                            <select name="process_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($processes as $item)
                                                    <option {{ ($item->id == Request::get('process_id')) ? 'selected':'' }}
                                                            {{--                                                    {{ (isset($processRequest) && $processRequest == $item->id) ? 'selected' : '' }}--}}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Team</label>
                                            <select name="team_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach ($teams as $team)
                                                    <option {{ ($team->id == Request::get('team_id')) ? 'selected':'' }}
                                                            value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  placeholder="Employee ID" name="employer_id" value="{{ Request::get('employer_id') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if(!empty($teamLeaveStatus) && count($teamLeaveStatus) > 0)
                            <table class="inner-table" width="100%">
                                <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Process</th>
                                    <th>Team</th>
                                    <th>Casual</th>
                                    <th>Sick</th>
                                    <th>Annual</th>
                                    <th>Maternity</th>
                                    <th>Paternity</th>
                                    <th>Leave Without Pay</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($teamLeaveStatus as $status)
                                        <tr>
                                            <td>{{ $status->employer_id }} - {{ $status->emname }}</td>
                                            <td>{{ $status->department }}</td>
                                            <td>{{ $status->process }}-{{ $status->processSegment }}</td>
                                            <td>{{ $status->teamName }}</td>
                                            <td class="casual">{{ str_replace('.0', '',$status->Casual) }}</td>
                                            <td class="sick">{{ str_replace('.0', '',$status->Sick) }}</td>
                                            <td class="earned">{{ str_replace('.0', '',$status->Earned) }}</td>
                                            <td class="maternity">{{ str_replace('.0', '',$status->Maternity) }}</td>
                                            <td class="paternity">{{ str_replace('.0', '',$status->Paternity) }}</td>
                                            <td class="lwp">{{ str_replace('.0', '',$status->LWP) }}</td>
                                            <td class="total-leave">{{ str_replace('.0', '',$status->totalLeave)}}</td>
                                            <td class="text-bold text-center">
                                                <a title="Leave Details" target="_blank" href="{{ route('admin.leave.list', ['id'=>$status->id]) }}" class="btn-sm">Leave Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Grand total</td>
                                        <td class="casualSum"></td>
                                        <td class="sickSum"></td>
                                        <td class="earnedSum"></td>
                                        <td class="maternitySum"></td>
                                        <td class="paternitySum"></td>
                                        <td class="lwpSum"></td>
                                        <td class="totalSum"></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                                <br>
                                {!! $teamLeaveStatus->render() !!}
                            @else
                                <p>No data found !</p>
                            @endif
                        </div>
                    </div>


                    <!--begin::Form-->

                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@push('css')

    <style>
        .inner-table{
            border-collapse: collapse; border-spacing: 0px; text-align:center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width:.5px;
            border-style:solid;
        }
        .inner-table th {
            border: 1px solid #0abb87;
        }

        .inner-table td {
            border: 1px solid #0abb87;
        }
    </style>

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
         var casualSum = 0;
         var sickSum = 0;
         var earnedSum = 0;
         var maternitySum = 0;
         var paternitySum = 0;
         var lwpSum = 0;
         var total_leave = 0;
        (function($){
            $(".casual").each(function(k, v) {
                    casualSum += parseFloat($(this).html());
            });
            $(".sick").each(function(k, v) {
                sickSum += parseFloat($(this).html());
            });
            $(".earned").each(function(k, v) {
                earnedSum += parseFloat($(this).html());
            });
            $(".maternity").each(function(k, v) {
                maternitySum += parseFloat($(this).html());
            });
            $(".paternity").each(function(k, v) {
                paternitySum += parseFloat($(this).html());
            });
            $(".lwp").each(function(k, v) {
                lwpSum += parseFloat($(this).html());
            });
            $(".total-leave").each(function(k, v) {
                total_leave += parseFloat($(this).html());
            });
        $('.casualSum').text(casualSum);
        $('.sickSum').text(sickSum);
        $('.earnedSum').text(earnedSum);
        $('.maternitySum').text(maternitySum);
        $('.paternitySum').text(paternitySum);
        $('.lwpSum').text(lwpSum);
        $('.totalSum').text(total_leave);
        })(jQuery);

    </script>
@endpush




