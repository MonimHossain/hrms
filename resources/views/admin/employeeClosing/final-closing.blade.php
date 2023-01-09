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
                                Final Closing
                            </h3>
                        </div>
                        {{--<a href="#" style="position: relative; top: 15px" title="Add New Adjustment" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.create') }}" class="card-text custom-btn globalModal">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a>--}}
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('user.final.closing.request.clearance.hr')  }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($emoloyees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} : {{ $employee->FUllName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">


                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 20px !important;">#</th>
                                <th>Employee</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Supervisor</th>
                                <th>Team Lead</th>
                                <th>Created At</th>
                                <th>Status .</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($allClearanceApproval as $closing)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $closing->employee->employer_id ?? '' }} : {{ $closing->employee->FullName ?? '' }}</td>
                                    <td>{{ $closing->employee->employeeJourney->designation->name ?? null }}</td>
                                    <td>
                                        @foreach($closing->employee->departmentProcess as $item)
                                            {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $closing->supervisor->employer_id ?? '' }} : {{ $closing->supervisor->FullName ?? '' }}</td>
                                    <td>{{ $closing->teamlead->employer_id ?? '' }} : {{ $closing->teamlead->FullName ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($closing->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($closing->final_closing !== \App\Utils\EmployeeClosing::ApprovedFrom['approval']['approved'])
                                            <span class="btn-sm btn-warning">Pending</span>
                                        @else
                                            <span class="btn-sm btn-success">Done</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="#" style="width: 110px;" title="Final Approval for Employee Closing" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.request.clearance.hr.final.approval.show', ['id'=>$closing->id]) }}" class="text-primary custom-btn globalModal"><span class="btn-sm btn-outline-primary"><i class="la la-user-secret"></i></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
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
        $('.month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
    </script>
@endpush




