@extends('layouts.container')

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

    <div class="filter_keys widget mt-0 mb-4">
        <div class="row">
            <div class="col-md-12">
                <label>Report Type</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio">
                        <input value="data" type="radio" name="report_type" {{ $is_stat ? '':'checked' }}> Data Report
                        <span></span>
                    </label>
                    <label class="kt-radio">
                        <input type="radio" value="stat" name="report_type" {{ $is_stat ? 'checked':'' }}> Statistics Report
                        <span></span>
                    </label>
                </div>
                <span class="form-text text-muted">You can generate full report or generate statustics</span>
            </div>
        </div>
    </div>

    @include('includes.report.filter')

    @if($search_string != '' && request()->get('report_type') != 'employeeInfo')
        <div class="filter_keys widget mt-0 mb-3">
            @if($employees)
                <strong>{{ 'Employee Info Report:' }} Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }}   of total {{$employees->total()}} entries </strong> <br>
            @endif
            @if($leaves)
                <strong>{{ 'Leave Report:' }} Showing total {{count($leaves)}} entries for: </strong> <br>
            @endif
            @if($attendance)
                <strong>{{ 'Attendance Report:' }} </strong> <br>
            @endif
            {!! $search_string !!}
        </div>
    @endif
    @if($employees)
        @include('includes.report.employee-data')
    @endif

    @if($leaves)
        @include('includes.report.leave-data')
    @endif

    @if($attendance)
        @include('includes.report.attendance-data')
    @endif

    @if($headcount_stat)
        @include('includes.report.headcount-stat')
    @endif
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
<!--begin::Page Vendors -->
<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo6/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/report.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function(){
    let t = $('#kt_table_1').DataTable({
             responsive: true,
            'processing': true,
            'serverSide': true,
            "deferRender": true,
            'ajax': "{{ route('employee.list') }}",
            'columns': [
                {
                    "data": null,"sortable": false,
                    render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                // {
                //     'data' : 'profile_img'
                //      },
                { 'data' : 'employer_id' },
                { 'data' : 'login_id' },
                { 'data' : "name" },
                { 'data' : 'designation' },
                { 'data' : 'department' },
                { 'data' : 'process' },
                { 'data' : 'center' },
                { 'data' : 'blood_group' },
                { 'data' : 'contact_number' },
                {
                    data: 'action',
                    name: 'action',
                    className: "text-center blog_delete",
                    orderable: true,
                    searchable: true,
                    // defaultContent: '<a target="_blank" href="" class="editor_edit"><i class="flaticon-eye"></i></a> / <a target="_blank" href="" class="editor_edit"><i class="flaticon-edit"></i></a> / <a href="" class="editor_remove"><i class="flaticon-delete"></i></a>'
                }
            ],
        });


        // Delete employee
        $("#kt_table_1").on('click', '.employee_remove', function () {
            var employeeId = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this employee",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = "{{ route('delete.employee', ['']) }}/"+employeeId;
                    Swal.fire(
                        'Deleted!',
                        'Employee has been deleted.',
                        'success'
                    )
                }
            });
        });

        $('input[type=radio][name=report_type]').change(function() {
            console.log(this.value);
            if(this.value == 'data'){
                $("#data_form").removeClass('hidden');
                $("#stat_form").addClass('hidden');
            } else {
                $("#stat_form").removeClass('hidden');
                $("#data_form").addClass('hidden');
            }
        });

        let filterType = $('#dateRangeFilter').val();
        if(filterType == 'all'){
            $(".datePicker").addClass('hidden');
        }

        $('#dateRangeFilter').change(function() {
            console.log(this.value);
            if(this.value == 'all'){
                $(".datePicker").addClass('hidden');
            } else {
                $(".datePicker").removeClass('hidden');
            }
        });

        $('#reload').on('click', function(){
            location.reload('/report');
            // $(location).attr('href', '/report')
        })

        $('#reset').on('click', function(){
            var url = $(this).attr('href');
            // alert(url);
            // $(location).attr('href', '/report')
        })

        $(".businessName").each(function() {
            let name = $(this).attr('title').split(" ");
            let shortName = '';
            if(name.length > 1){
                for(let count = 0; count < name.length; count++){
                    shortName += name[count][0];
                }
            }
            else {
                shortName = $(this).attr('title');
            }
            $(this).attr('title', shortName);
            console.log(name.length, $(this).attr('title'), shortName);
        });

        if($('#leaveReportType').val() == 'Use'){
            $('.dataRange').show();
            $('.date-pick').prop('required',true);
            $('.yearRange').hide();
            $('.year-pick').prop('required',false);
            $('.year-pick').val('');
        } else if($('#leaveReportType').val() == 'Balance'){
            $('.dataRange').hide();
            $('.date-pick').val('');
            $('.date-pick').prop('required',false);
            $('.yearRange').show();
            $('.year-pick').prop('required',true);
        } else {
            $('.dataRange').hide();
            $('.date-pick').val('');
            $('.date-pick').prop('required',false);
            $('.yearRange').hide();
            $('.year-pick').val('');
            $('.year-pick').prop('required',false);
        }
        $('#leaveReportType').on('change', function(){
            var val = $(this).val();
            if(val == 'Use'){
                $('.dataRange').show();
                $('.date-pick').prop('required',true);
                $('.year-pick').val('');
                $('.year-pick').prop('required',false);
                $('.yearRange').hide();
            }else if(val == 'Balance'){
                $('.dataRange').hide();
                $('.date-pick').val('');
                $('.date-pick').prop('required',false);
                $('.yearRange').show();
                $('.year-pick').prop('required',true);
            } else {
                $('.date-pick').val('');
                $('.date-pick').prop('required',false);
                $('.year-pick').val('');
                $('.year-pick').prop('required',false);
                $('.yearRange').hide();
                $('.dataRange').hide();
            }
        })
        $('.year-pick').datepicker({
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
});
</script>
<script>
    $(document).ready(function() {
        $('#exportTable').DataTable( {
            dom: 'Bftiprl',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columnDefs": [
                {"className": "dt-left", "targets": "_all"}
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>
@endpush


