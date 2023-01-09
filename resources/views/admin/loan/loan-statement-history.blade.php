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
                        Loan Statement History
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-bordered" id="html_table">
                    <thead>
                    <tr>
                        <th title="Field #1">Ref ID</th>
                        <th title="Field #2">Employee Id</th>
                        <th title="Field #3">EMI</th>
                        <th title="Field #4">Month</th>
                        <th title="Field #5">Due Amount</th>
                        <th title="Field #6">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($loanApplication as $application)
                        @php
                            $approvedValue = \App\Utils\Payroll::LOAN['SHOWSTATUS']['APPROVED'];
                            $color =  (($application->loan->loanGeneralApp->status ?? 0) == $approvedValue)?'red':'';
                        @endphp
                        <tr>
                            <td style="color : {{ $color }}">{{ $application->loan->reference_id }}</td>
                            <td>{{ $application->loan->employee->employer_id }}</td>
                            <td style="color : {{ $color }}">{{ $application->amount }} </td>
                            <td>{{ $application->emi_date->format('d M, Y') }}</td>
                            <td>{{ $application->amount_due }}</td>
                            <td>{{ trans('payroll.loan.process.'.$application->status) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--end: Datatable -->
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
