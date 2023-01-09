<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-line-graph"></i>
                    </span>
            <h3 class="kt-portlet__head-title">
                Employee Attendance Report
            </h3>
        </div>
    </div>
    {{-- {{ dd($leaves) }} --}}
    <div class="kt-portlet__body">
    @if (!isset($attendance) && !isset( $tableDate))

    no records

    @elseif($attendance->count() == 0 || sizeof($tableDate) == 0)
    no records
    @else
    <div class="table-responsive">
        <table class="table table-striped custom-table table-nowrap mb-0" id="attendanceReport">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Process</th>
                    @php
                        $period = new DatePeriod(
                            new DateTime(Request::get('datefrom')),
                            new DateInterval('P1D'),
                            new DateTime(date("Y-m-d", strtotime(date(Request::get('dateto')). "+1 day")))
                        );
                    @endphp
                    @foreach ($period as $key => $value)
                    <th class="text-bold">{{ $value->format('M d')  }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>

                @foreach ($attendance as $items)
                @if ($items->attendances->isNotEmpty())
                <tr>
                    <td>
                        <h2 class="table-avatar">
                            <a href="javascript: void(0);">{{ $items->employer_id }} - {{ $items->FullName }}</a>
                        </h2>
                    </td>
                    <td>
                        <h2 class="table-avatar">
                            <a href="javascript: void(0);">@foreach($items->departmentProcess->unique('department_id') as $item)
                                    {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                @endforeach</a>
                        </h2>
                    </td>
                    <td>
                        <h2 class="table-avatar">
                            <a href="javascript: void(0);">@foreach($items->departmentProcess->unique('process_id') as $item)
                                    {{ $item->process->name ?? null }}
                                    -
                                    {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                @endforeach</a>
                        </h2>
                    </td>
                    @foreach ($period as $key => $value)
                        <td class="text-bold text-center">
                            @foreach ($items->attendances as $item)
                                @if (date("Y-m-d", strtotime($item->date)) == $value->format('Y-m-d'))
                                    @if ($item->status == \App\Utils\AttendanceStatus::PRESENT)
                                        <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-success' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    @elseif($item->status == \App\Utils\AttendanceStatus::HALF_DAY)
                                        <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    @elseif($item->status == \App\Utils\AttendanceStatus::LATE)
                                        <a href="javascript:void(0);" class="{{ ($item->punch_in && $item->punch_out) ? 'text-warning' : 'text-muted'}}" data-attendance-id="{{ $item->id }}"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info">{{ _lang('attendance.status',$item->status) }}</a>
                                    @else
                                        {{ _lang('attendance.status',$item->status) }}
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        {{ Request::get('display_type') == 'Paginate' ? $attendance->appends(Request::all())->links() : '' }}
    </div>
    @endif
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal custom-modal fade" id="attendance_info" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<!-- /Attendance Modal -->


@push('css')

<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
    rel="stylesheet" type="text/css" />
{{-- attendance css --}}
<link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            var table = $('#attendanceReport').DataTable( {
                responsive: true,
                dom: 'Bftiprl',
                buttons: [
                    'excelHtml5'
                ],
                "searching": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            } );
        } );

        new $.fn.dataTable.FixedHeader( table );
    </script>
@endpush
