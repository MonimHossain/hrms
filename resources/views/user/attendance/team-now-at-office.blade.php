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
                        Team Member's Attendance Status
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">

                    <form class="kt-form" action="{{ route('user.team.attendance.now.at.office.submit') }}" method="get">

                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>Team</label>
                                    <div class="input-group date">

                                        <select id="team_lead_id" name="team" class="form-control kt-selectpicker" data-live-search="true">
                                            <option value="">Select</option>
                                            @foreach ($teams as $team)
                                                <option {{ ($team->id == Request::get('team')) ? 'selected':'' }} value="{{$team->id}}"
                                                        data-tokens="{{ $team->name }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="kt-form__actions">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <button type="reset" class="btn btn-secondary reset-button">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="kt-section__content">
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
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_absent) ? $total_absent : 0 }}</span>
                                                <span class="dbox__title">Absent</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_late_entry) ? $total_late_entry : 0 }}</span>
                                                <span class="dbox__title">Late Entry</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($total_early_leave) ? $total_early_leave : 0 }}</span>
                                                <span class="dbox__title">Early Leave</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="dbox dbox--color-3">
                                            <div class="dbox__body">
                                                <span class="dbox__count">{{ isset($missing_exit) ? $missing_exit : 0 }}</span>
                                                <span class="dbox__title">Missing Exit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card section end -->
                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0" id="attendanceReport">
                                    <thead>
                                    <tr>                                        
                                        <th>Emoloyee ID</th>
                                        <th>Emoloyee Name</th>
                                        <th>Roster Starts</th>
                                        <th>Roster Ends</th>
                                        <th>Punched at</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report_data as $report)
                                            <tr>                                        
                                                <td>{{ $report['employer_id'] }}</td>
                                                <td>{{ $report['name'] }}</td>
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
