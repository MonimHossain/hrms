<div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon-line-graph"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Employee Report
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">

                <div style="overflow-x:auto;">
                    <!--begin: Datatable -->
                    <table class="table table-striped table-bordered " id="employee-report-table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Center</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Process</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Blood Group</th>
                                <th>Religion</th>
                                <th>Reporting (1st)</th>
                                <th>Reporting (2nd)</th>
                                <th>Joining Date</th>
                                <th>Last Working Date</th>
                                <th>Employment Type</th>
                                <th>Employee Status</th>
                                <th>Account completed (%)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)

                                {{-- @php
                                    dd($employee);
                                @endphp --}}
                                <tr>
                                    <td>{{ $employee->employer_id }}</td>
                                    <td>{{ $employee->FullName }}</td>
                                    <td>
                                        @foreach($employee->divisionCenters->where('is_main',1) as $item)
                                            {{ $item->division->name .',  '.$item->center->center  ?? null }}@if(!$loop->last) <br> @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($employee->departmentProcess->unique('department_id') as $item)
                                            {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $employee->employeeJourney->designation->name ?? '' }}</td>
                                    <td>
                                        @foreach($employee->departmentProcess->unique('process_id') as $item)
                                            {{ $item->process->name ?? null }}
                                            -
                                            {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $employee->contact_number ?? '' }}</td>
                                    <td>{{ $employee->gender ?? '' }}</td>
                                    <td>{{ $employee->bloodGroup->name ?? '' }}</td>
                                    <td>{{ $employee->religion  ?? '' }}</td>
                                    <td>
                                        @foreach($employee->teams as $team)
                                            @if($team->team_lead_id != $employee->id)
                                                {{-- Team: {{ $team->name }} <br> --}}
                                                @if($team->teamLead)
                                                    {{ $team->teamLead->first_name .' '. $team->teamLead->last_name }}
                                                @endif
                                            @endif
                                        @endforeach
                                        {{-- {{ $employee->teams }} --}}
                                        {{-- {{ $employee->employeeTeam->team }}
                                        {{ $employee->employeeTeam->team ? $employee->employeeTeam->team->teamLead ? $employee->employeeTeam->team->teamLead->first_name .' '. $employee->employeeTeam->team->teamLead->last_name  : '' : '' }} --}}
                                    </td>
                                    <td></td>
                                    <td>{{ $employee->employeeJourney->doj  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->lwd  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->employmentType->type  ?? '' }}</td>
                                    <td>{{ $employee->employeeJourney->employeeStatus->status  ?? '' }}</td>
                                    <td>
                                        {{ $employee->profile_completion  ?? '' }} <br>
                                        <a target="_blank" href="{{ route('Admin.Report.missing-data', ['employee_id' => $employee->id]) }}">Show fields</a>
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank" href="{{ route('employee.profile', $employee->id) }}"><i class="flaticon-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(!$employees->count())
                                <tr class="text-center">
                                    <td colspan="12">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-md-12 margin-top-10">--}}
{{--                        {{ $employees->appends($filters)->links() }}--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--end: Datatable -->
            </div>
        </div>

@push('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#employee-report-table').DataTable( {
                // dom: 'Bftiprl',
                // buttons: [
                //     'copyHtml5',
                //     'excelHtml5',
                //     'csvHtml5',
                //     'pdfHtml5',
                //     'print'
                // ],
                "columnDefs": [
                    {"className": "dt-left", "targets": "_all"}
                ],
                "searching": true
            } );
        } );
    </script>

@endpush

