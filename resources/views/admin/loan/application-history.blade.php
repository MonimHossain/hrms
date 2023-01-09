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
                        Loan Application History
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                    <div class="kt-section">
                        <div class="kt-section__content">


                            <form class="kt-form" action="{{ route('admin.loan.application.history')  }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control"
                                                       placeholder="Select Date"
                                                       id="kt_datepicker_3" autocomplete="off" name="date_from" value="{{ Request::get('date_from') }}"/>
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" readonly
                                                       placeholder="Select Date"
                                                       id="kt_datepicker_3" autocomplete="off" name="date_to" value="{{ Request::get('date_to') }}"/>
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Reference Id</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  placeholder="Reference ID" name="reference_id" value="{{ Request::get('reference_id') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  placeholder="Employee ID" name="employee_id" value="{{ Request::get('employee_id') }}"/>
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


                            <!--begin: Datatable -->
                            <table class="table table-bordered" id="html_table">
                                <thead>
                                <tr>
                                    <th title="Field #1">Ref ID</th>
                                    <th title="Field #2">Applied at</th>
                                    <th title="Field #3">Approved</th>
                                    <th title="Field #4">Type</th>
                                    <th title="Field #4">Interval</th>
                                    <th title="Field #4">Amount</th>
                                    <th title="Field #4">Status</th>
                                    <th title="Field #5">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($applicationList as $row)
                                    <tr>
                                        <td>{{ $row->reference_id }}</td>
                                        <td>{{ $row->created_at->format('d M, Y') }}</td>
                                        <td>{{ $row->approvedBy->FullName ?? '-' }}</td>
                                        <td>{{ $row->loanType->loan_type }}</td>
                                        <td>{{ $row->interval }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ trans('payroll.loan.status.'.$row->status) }}</td>
                                        <td>
                                            <a href="#" title="Loan Application Status Change" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.loan.application.history.edit', ['id'=>$row->id]) }}" class="btn-sm btn-outline-primary text-primary custom-btn globalModal">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end: Datatable -->
                                <!--end: Datatable -->

                        </div>
                    </div>

            </div>
        </div>

    </div>

    <!-- end:: Content -->
@endsection

@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endpush
