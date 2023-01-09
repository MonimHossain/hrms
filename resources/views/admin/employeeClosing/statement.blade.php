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
                                Adjustment Statement : {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('M, Y') }}
                            </h3>
                        </div>
                        <div class="row">

                            <a href="#" style="position: relative; top: 15px" title="Add New Adjustment" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.create') }}" class="card-text custom-btn globalModal">
                                <span class="btn btn-outline-primary">Add New</span>
                            </a>

                            &nbsp;

                            @if($confirmation)
                            <a href="#" style="position: relative; top: 15px" href="#" route="{{ route('payroll.adjustment.clearance') }}" smg="Do you want to give clearance" class="confirm">
                                <span class="btn btn-outline-warning">Clearance</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('payroll.adjustment.statement')  }}" method="GET">
                                <div class="row">
                                    {{--<div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick" name="date_from" placeholder="Select Month" value="{{ Request::get('date_from') }}">
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Adjustment Type</label>
                                            <div class="input-group">
                                                <select name="adjustment_type" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($adjustmentType as  $value)
                                                        <option {{ (Request::get('adjustment_type') ==  $value->id)? 'selected="selected"':'' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($emoloyees as $employee)
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
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Adjustment Type</th>
                                    <th>Type -</th>
                                    <th>Amount</th>
                                    <th>Current Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    {{--<th>Remarks</th>--}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($adjustments as $adjustment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $adjustment->employee->employer_id }}</td>
                                    <td>{{ $adjustment->employee->FullName }}</td>
                                    <td>{{ $adjustment->adjustmentType->name }}</td>
                                    <td>{{ $adjustment->type }}</td>
                                    <td>{{ $adjustment->amount }}</td>
                                    <td>{{ _lang('payroll.adjustment.status', $adjustment->status) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($adjustment->created_at)->format('d M Y') }}</td>
                                    <td>{{ $adjustment->createdBy->FullName }}</td>
                                    {{--<td>{{ str_limit($adjustment->remarks, 20, '...') }}</td>--}}
                                    <td>
                                        @if($confirmation)
                                        <a href="#" title="Update Adjustment" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.edit', [$adjustment->id]) }}" class="card-text custom-btn globalModal">
                                            <span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span>
                                        </a>
                                        @endif
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
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
@endpush

@include('layouts.confirmation-alert-smg')





