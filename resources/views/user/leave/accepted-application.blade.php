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
                            Requested Leave
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                <table class="kt-datatable" id="html_table" width="100%">
                    <thead>
                        <tr>
                            <th title="Field #1">Subject</th>
                            <th title="Field #2">Description</th>
                            <th title="Field #3">Start Date</th>
                            <th title="Field #4">End Date</th>
                            <th title="Field #5">Leave Type</th>
                            <th title="Field #6">Leave Location</th>
                            <th title="Field #7">Resume Date</th>
                            <th title="Field #8">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $leave->subject }}</td>
                            <td>{{ $leave->description }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>
                                @foreach (json_decode($leave->leave_type) as $type)
                                    {{ trans('leave.leaveType.'.$type) }}
                                @endforeach
                            </td>
                            <td>{{ $leave->leave_location }}</td>
                            <td>{{ $leave->resume_date }}</td>
                            <td align="right">
                                <a href="{{ route('leave.view', [$leave->id]) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('user.history', [$leave->id]) }}" class="btn btn-info">History</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/demo1/pages/crud/metronic-datatable/base/html-table.js') }}" type="text/javascript"></script>
@endpush
