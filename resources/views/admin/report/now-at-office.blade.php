@extends('layouts.container')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                    <h3 class="kt-portlet__head-title">
                        Now at office
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">

                    <div class="kt-section__content">

                        <div class="containter">
                            <form action="{{ route('Admin.Report.now-at-office') }}" method="GET" class="kt-form">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select name="department_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach ($departments as $item)
                                                <option
                                                    {{ (isset($filters['department_id']) && $filters['department_id']== $item->id) ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Process</label>
                                            <select name="process_id" class="form-control">
                                                <option value="">All Process</option>
                                                @foreach ($processes as $item)
                                                <option
                                                    {{ (isset($filters['process_id']) && $filters['process_id'] == $item->id) ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                            
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Employment Type</label>
                                            <div>
                                                <select class="form-control kt-select2" id="kt_select2_32" name="employment_type">
                                                    <option value="">All</option>
                                                    @foreach($employmentTypes as $employmentType)
                                                        <option value="{{ $employmentType->id }}" {{ isset($filters['employment_type']) && $filters['employment_type'] == $employmentType->id ? 'selected': '' }}>{{ $employmentType->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <div>
                                                <select class="form-control kt-select2" id="kt_select2_93" name="gender">
                                                    <option value="">All</option>
                                                    @foreach($genders as $gender)
                                                        <option value="{{ $gender }}" {{ isset($filters['gender']) && $filters['gender'] == $gender ? 'selected': '' }}>{{ $gender }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <div>
                                                <select class="form-control kt-select2" id="kt_select2_103" name="blood_group">
                                                    <option value="">All</option>
                                                    @foreach($bloodGroups as $bloodGroup)
                                                        <option value="{{ $bloodGroup->id }}"  {{ isset($filters['blood_group']) && $filters['blood_group'] == $bloodGroup->id ? 'selected': '' }}>{{ $bloodGroup->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Religion</label>
                                            <div>
                                                <select class="form-control kt-select2" id="kt_select2_1000" name="religion">
                                                    <option value="">All</option>
                                                    @foreach($employee_religions as $employee_religion)
                                                        <option value="{{ $employee_religion }}" {{ isset($filters['religion']) && $filters['religion'] == $employee_religion ? 'selected': '' }}>{{ $employee_religion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <div>
                                                <select class="form-control kt-select2" id="kt_select2_85" name="designation">
                                                    <option value="">All</option>
                                                    @foreach($designations as $designation)
                                                        <option value="{{ $designation->id }}" {{ isset($filters['designation']) && $filters['designation'] == $designation->id ? 'selected': '' }}>{{ $designation->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="kt-form__actions" >
                                                <label>&nbsp</label> <br>
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if (!isset($attendances) )

                            No records for this month

                        @else

                            @php
                                $total_office       =   0;
                                $total_present      =   0;
                                $total_absent       =   0;
                                $total_late_entry   =   0;
                                $total_early_leave  =   0;
                                $missing_exit       =   0;

                                if ($report_data){
                                    foreach ($report_data as $item){
                                        $total_office++;
                                        if ($item['status'] == \App\Utils\AttendanceStatus::PRESENT){
                                            $total_present++;
                                        } elseif($item['status'] == \App\Utils\AttendanceStatus::LATE) {
                                            $total_late_entry++;
                                        }else {
                                            if ($item['status'] == \App\Utils\AttendanceStatus::ABSENT) {
                                                $total_absent++;
                                            }
                                            else if ($item['status'] == \App\Utils\AttendanceStatus::DAYOFF) {
                                                //
                                            }
                                            else{
                                                //
                                            }
                                        }
                                    }
                                }
                            @endphp



                        <!-- card section start -->
                            {{-- <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_present) ? $total_present : 0 }}</span>
                                                <span class="dbox__title">Present</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_late_entry) ? $total_late_entry : 0 }}</span>
                                                <span class="dbox__title">Late Entry</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- card section end -->
                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0" id="attendanceReport">
                                    <thead>
                                    <tr>                                        
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Center</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Process</th>
                                        <th>Phone</th>
                                        <th>Reporting (1st)</th>
                                        <th>Employment Type</th>
                                        <th>Employee Status</th>
                                        <th>Religion</th>
                                        <th>Blood Group</th>
                                        <th>Roster Starts</th>
                                        <th>Roster Ends</th>
                                        <th>Punched at</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report_data as $report)
                                            @php
                                                $employee = $report['employee'];
                                            @endphp
                                            <tr>                                        
                                                <td>
                                                    <a target="_blank" href="{{ route('employee.profile', $employee->id) }}">{{ $employee->employer_id }}</a>
                                                </td>
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
                                                <td>{{ $employee->pool_phone_number ?? $employee->contact_number }}</td>
                                                <td>
                                                    @foreach($employee->teams as $team)
                                                        @if($team->team_lead_id != $employee->id)
                                                            Team: {{ $team->name }} <br>
                                                            @if($team->teamLead)
                                                                {{ $team->teamLead->first_name .' '. $team->teamLead->last_name }}
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $employee->employeeJourney->employmentType->type  ?? '' }}</td>
                                                <td>{{ $employee->employeeJourney->employeeStatus->status  ?? '' }}</td>
                                                <td>{{ $employee->religion  ?? '' }}</td>
                                                <td>{{ $employee->bloodGroup->name  ?? '' }}</td>
                                                <td>{{ $report['roster_start'] != 'No roster' ? date('h:i:s A', strtotime($report['roster_start'])) : $report['roster_start'] }}</td>
                                                <td>{{ $report['roster_end'] != 'No roster' ? date('h:i:s A', strtotime($report['roster_end'])) : $report['roster_end'] }}</td>
                                                <td>{{ $report['punch_in'] != '' ? date('h:i:s A', strtotime($report['punch_in'])) : '-' }}</td>
                                                <td>{{ _lang('attendance.status',$report['status']) }}</td>
                                                <td>
                                                    <?php 
                                                        $map = '';
                                                        if($report['location']){                                                            
                                                            $map = json_decode($report['location']);
                                                            if($map){
                                                                echo "<p>";
                                                                echo "<strong>Street:</strong> " . $map->street . "<br>";
                                                                echo "<strong>Geo Location:</strong> " . $map->latLng->lat . ", ". $map->latLng->lng ."<br>";
                                                                echo "<img src='" . $map->mapUrl . "'><br>";
                                                                echo "</p>";
                                                            }                                                            
                                                        } else {
                                                            echo "Map location missing";
                                                        }      
                                                    ?>
                                                </td>
                                            </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end:: Content -->

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
@endsection

@push('css')

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
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
                "searching": true
            } );
        } );

        new $.fn.dataTable.FixedHeader( table );
    </script>
@endpush



@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    
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

        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'mm',
            viewMode: 'months',
            minViewMode: 'months'
        });

        $('#year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });
    </script>

    <script>
        $('#attendance_info').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var attendance_id = button.data('attendance-id') // Extract info from data-* attributes
            let url = "{{ route('user.team.attandance.details') }}";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    attendance_id,
                    "_token": "{{ csrf_token() }}",
                },
                // dataType: 'json',
                success: function (res) {
                    $('.modal-body').html(res);

                },
                error: function (request, status, error) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });
        });
    </script>
@endpush
