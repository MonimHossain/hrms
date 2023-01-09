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
                                Salary Hold Statement : {{ \Carbon\Carbon::parse($year.'-'.$month)->format('M, Y') }}
                            </h3>
                        </div>

                        <div class="row">
                            <a href="#" style="position: relative; top: 15px" title="Add New Salary Hold" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.salary.hold.create') }}" class="card-text custom-btn globalModal">
                                <span class="btn btn-primary">Add New</span>
                            </a>

                            &nbsp;
                        </div>

                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            {{--<form class="kt-form" action="{{ route('payroll.salary.hold.statement') }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $employee)
                                                        <option {{ (Request::get('employee_id') ==  $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">View</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>--}}
                            <form class="kt-form" action="{{ route('payroll.salary.hold.statement') }}" method="get">
                                @csrf
                                <div class="kt-portlet">
                                    <div class="kt-portlet__body">
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Month</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" readonly placeholder="Select Month"
                                                               id="month-pick" name="month" value="{{ $month }}" />
                                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>year</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" readonly placeholder="Select Year"
                                                               id="year-pick" name="year" value="{{ $year }}" />
                                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <div class="kt-form__actions" style="margin-top: 26px;">
                                                        <input type="submit" class="btn btn-primary" id="view" name="button" value="View">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                            @if($salaryHolds->isNotEmpty())
                            <a class="btn btn-success" href="{{ route('payroll.salary.hold.download', ['year'=>$year, 'month'=> $month]) }}">Download</a>

                            @can(_permission(\App\Utils\Permissions::SALARY_HOLD_CLEARANCE_VIEW))
                            <a id="clearance" title="Hold Status" data-toggle="modal" data-target="#kt_modal"
                               action="{{ route('payroll.hold.statement.view.clearance', ['year'=>$year, 'month'=> $month]) }}"
                               class="btn btn-success custom-btn globalModal text-white pull-right"><i class="fa fa-arrow-down" aria-hidden="true"></i>
                                Clearance
                            </a>
                            @endcan

                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Devision Center</th>
                                    <th>Dept-Process</th>
                                    <th>Emp-Type</th>
                                    <th>Hold Status</th>
                                    <th>Hold Start Date</th>
                                    <th>Hold By</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($salaryHolds as $salaryHold)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $salaryHold->employee->employer_id }}</td>
                                        <td>{{ $salaryHold->employee->FullName }}</td>
                                        <td>
                                        @foreach($salaryHold->employee->divisionCenters as $item)
                                            <div class="kt-list-timeline__item" style="width: auto;">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text"
                                                        style="padding: 0 0 0 15px;">{{ $item->division->name ?? null }} - {{ $item->center->center ?? null }}</span>

                                            </div>
                                        @endforeach
                                        </td>
                                        <td>
                                        @foreach($salaryHold->employee->departmentProcess->unique('department_id') as $item)
                                            {!! $item->department->name ?? null !!} @if(!$loop->last && $item->department) , @endif
                                        @endforeach</td>
                                        <td>{{ $salaryHold->employee->employeeJourney->employmentType->type ?? null }}</td>
                                        <td>{{ _lang('payroll.salaryhold.status', $salaryHold->status) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($salaryHold->month)->format('M Y') }}</td>
                                        <td>{{ $salaryHold->createdBy->FullName }}</td>
                                        <td>{{ str_limit($salaryHold->remarks, 20, '...') }}</td>
                                        <td>
                                            <a href="#" title="Update Salary Hold" form-size="modal-md" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.salary.hold.edit', [$salaryHold->id]) }}" class="card-text custom-btn globalModal">
                                                <span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <a id="" title="Hold Status" data-toggle="modal" data-target="#kt_modal"
                               action="{{ route('payroll.hold.statement.view.clearance', ['year'=>$year, 'month'=> $month]) }}"
                               class="btn btn-success custom-btn globalModal text-white pull-right"><i class="fa fa-arrow-down" aria-hidden="true"></i>
                                Clearance
                            </a>
                            <br>
                            <br>
                            <br>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Not Found!</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@include('layouts.confirmation-alert-smg')


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        table {
            text-align: center;
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
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function(){
            $('.validationCheck').on('change', function(){
                if($(this).is(":checked")){
                    let id = $(this).attr('id');
                    let url = '{{ route('salary.validation', ['']) }}';
                    $.ajax({url: url + '/' + id, success: function(result){
                            alert(result);
                        }});
                }
            })
        })
    </script>


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

        //Auto load button enable or disabled
        $('#clearance').hide();
        $('#notfoundClearance').hide();

        $(document).ready(function () {
            var month = $('#month-pick').val();
            var year = $('#year-pick').val();
            $.ajax({
                url: "{{ route('payroll.hold.statement.button.enabled.disabled') }}",
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", "month":month, "year":year},
                success: function (data) {
                    (data.confirmation) ?  $('#clearance').show() : $('#clearance').hide();
                }
            });
        });

        $('#month-pick, #year-pick').on('change', function () {
            var month = $('#month-pick').val();
            var year = $('#year-pick').val();
            $.ajax({
                url: "{{ route('payroll.hold.statement.button.enabled.disabled') }}",
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", "month":month, "year":year},
                success: function (data) {
                    (data.confirmation) ?  $('#clearance').show() : $('#clearance').hide();
                }
            });
        });



    </script>

@endpush




