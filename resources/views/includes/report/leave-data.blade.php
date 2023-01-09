<div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-line-graph"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Employee Leave Report
                    </h3>
                </div>
            </div>
            {{-- {{ dd($leaves) }} --}}
            <div class="kt-portlet__body">
                @if(count($leaves))
                <div style="overflow-x:auto;">
                    <!--begin: Datatable -->
                    <table class="table table-striped table-bordered " id="leaveReportTable">
                        <thead>
                            <tr class="text-center" style="vertical-align: middle;">
                                <th rowspan="2">Employee ID</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Division</th>

                                @if(Request::get('leave_report_type') == 'Use')
                                    <th rowspan="2">Leaves</th>
                                @endif
                                @if(Request::get('leave_report_type') == 'Balance')
                                    @foreach($leaveTypes as $item)
                                        @if($item->short_code == 'ML')
                                            <th >{{ $item->leave_type }}</th>
                                        @elseif($item->short_code == 'PL')
                                            <th >{{ $item->leave_type }}</th>
                                        @elseif($item->short_code == 'LWP')
                                            <th >{{ $item->leave_type }}</th>
                                        @else
                                            <th colspan="2">{{ $item->leave_type }}</th>
                                        @endif

                                    @endforeach
                                @endif
                                @php
                                    $count = 0;
                                @endphp
                                <th>Last Updated At</th>
                            </tr>
                            <tr>
                                @if(Request::get('leave_report_type') == 'Balance')

                                    @foreach($leaveTypes as $item)
                                        @if($item->short_code == 'ML')
                                            <th class="text-center">
                                                Remain
                                            </th>
                                        @elseif($item->short_code == 'PL')
                                            <th class="text-center">
                                                Remain
                                            </th>
                                        @elseif($item->short_code == 'LWP')
                                            <th class="text-center">Used</th>
                                        @else
                                            <th class="text-center">Total</th>
                                            {{-- <th>Used</th> --}}
                                            <th class="text-center">Remain</th>
                                        @endif

                                    @endforeach
                                @endif
                                {{-- <th class="text-center">-</th> --}}
                            </tr>
                        </thead>
                        <tbody class="text-center">

                            @foreach($leaves as $leave)
                                @php
                                    $employee = $leave['employee'];
                                    $earnLeaveService = new \App\Services\EarnLeaveService($employee);
                                    $leavesData = $leave['leaves'];
                                @endphp
                                <tr>
                                    <td>{{ $employee->employer_id }}</td>
                                    <td>
                                        <a target="_blank" href="{{ route('employee.profile', $employee->id) }}">{{ $employee->FullName }} </a> <br> {{ $employee->employeeJourney->designation->name ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($employee->divisionCenters->unique('division_id')->where('is_main', 1) as $item)
                                            {{ $item->division->name .', '.$item->center->center ?? null }}@if(!$loop->last) ; @endif
                                        @endforeach
                                    </td>
                                    @if(Request::get('leave_report_type') == 'Use')
                                        <td>
                                            @foreach($employee->leaves()->where('start_date', '>=', Request::get('start_date'))->where('start_date', '<=', Request::get('end_date'))->get() as $item)
                                                <span class="color-purple">{{ $item->leaveType->leave_type }}: </span> ({{ str_replace('.0', '',$item->quantity) }} day{{ $item->quantity > 1 ? 's':'' }}): <br>
                                                {{ $item->start_date ?? null }} <span class="color-aqua">to</span> {{ $item->end_date ?? null }}
                                                <br><br>
                                            @endforeach
                                        </td>
                                        <td></td>
                                    @endif
                                    @if(Request::get('leave_report_type') == 'Balance')
                                        @foreach($leavesData as $key => $balance)

                                            @if($balance)
                                                @if($key == \App\Utils\LeaveStatus::MATERNITY)
                                                    @if(is_numeric($balance['remain']) && (float)$balance['remain']%2 == 0)
                                                    <td >2</td>
                                                    @elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['remain'])
                                                    <td >1</td>
                                                    @elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['used'])
                                                    <td >0</td>
                                                    @else
                                                    <td >-</td>
                                                    @endif
                                                @elseif($key == \App\Utils\LeaveStatus::PATERNITY)
                                                    @if(is_numeric($balance['remain']) && (float)$balance['remain']%2 == 0)
                                                    <td >2</td>
                                                    @elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['remain'])
                                                    <td >1</td>
                                                    @elseif(is_numeric($balance['total']) && (float)$balance['total']/2 == $balance['used'])
                                                    <td >0</td>
                                                    @else
                                                    <td >-</td>
                                                    @endif
                                                @elseif($key == \App\Utils\LeaveStatus::LWP)
                                                    <td>{{ str_replace('.0', '', $balance['used']) }}</td>
                                                @elseif($key == \App\Utils\LeaveStatus::EARNED)
                                                    @php
                                                        $earnLeaveService = new App\Services\EarnLeaveService($employee);
                                                    @endphp
                                                    <td>{{ (is_numeric($balance['total'])) ? str_replace('.0', '', number_format( $balance['total'] , 1, '.', '')) : "-"}}</td>
                                                    {{-- <td>{{ (is_numeric($balance['used'])) ? str_replace('.0', '', number_format( $balance['used'] , 1, '.', '')) : "-" }} </td> --}}
                                                    <td>{{ (is_numeric($balance['remain'])) ? str_replace('.0', '', number_format( $balance['remain'] , 1, '.', '')) : "-" }}</td>
                                                @elseif($key == \App\Utils\LeaveStatus::CASUAL)
                                                    <td>{{ (is_numeric($balance['total'])) ? str_replace('.0', '', number_format( $balance['total'] , 1, '.', '')) : "-"}}</td>
                                                    {{-- <td>{{ (is_numeric($balance['used'])) ? str_replace('.0', '', number_format( $balance['used'] , 1, '.', '')) : "-" }} </td> --}}
                                                    <td>{{ (is_numeric($balance['remain'])) ? str_replace('.0', '', number_format( $balance['remain'] , 1, '.', '')) : "-" }}</td>
                                                @elseif($key == \App\Utils\LeaveStatus::SICK)
                                                    <td>{{ (is_numeric($balance['total'])) ? str_replace('.0', '', number_format( $balance['total'] , 1, '.', '')) : "-"}}</td>
                                                    {{-- <td>{{ (is_numeric($balance['used'])) ? str_replace('.0', '', number_format( $balance['used'] , 1, '.', '')) : "-" }} </td> --}}
                                                    <td>{{ (is_numeric($balance['remain'])) ? str_replace('.0', '', number_format( $balance['remain'] , 1, '.', '')) : "-" }}</td>
                                                @else 
                                                    <td>
                                                        -
                                                    </td>
                                                @endif
                                            @endif

                                        @endforeach
                                            <td>{{ Carbon\Carbon::parse($leave['last-update']->updated_at)->format('d-m-Y') }}</td>
                                    @endif

                                </tr>
                            @endforeach
                            @if(!count($leaves))
                                <tr class="text-center">
                                    <td colspan="12">No data found</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
                <!--end: Datatable -->


                @else
                    <div class="alert alert-primary" role="alert">
                        No data found!
                    </div>
                @endif
            </div>
        </div>




@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            // $('#leaveReportTable').DataTable();
            var table = $('#leaveReportTable').DataTable( {
                // responsive: true,
                // dom: 'Bftiprl',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdfHtml5',
                //     'print'
                // ],
                "searching": true
            } );
        } );

        new $.fn.dataTable.FixedHeader( table );
    </script>
@endpush
