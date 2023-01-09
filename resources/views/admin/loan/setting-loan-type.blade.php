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
                        Loan Type
                    </h3>
                </div>
                <span class="pull-right">
                    <a href="#" style="margin-top: 10px;" title="Add New Loan Type" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.loan.setting.loan.create') }}" class="btn btn-outline-primary custom-btn globalModal">Add
                         New Loan Type
                    </a>
                </span>
            </div>
            <div class="kt-portlet__body">



                <table class="table table-bordered" id="html_table">
                    <thead>
                    <tr>
                        <th title="Field #1">#</th>
                        <th title="Field #2">Loan Type</th>
                        <th title="Field #3">Loan Max Interval</th>
                        <th title="Field #4">Loan Max Amount</th>
                        <th title="Field #5">Terms and Conditions</th>
                        <th title="Field #6">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($loanTypes as $loanType)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $loanType->loan_type }}</td>
                        <td>{{ $loanType->interval }}</td>
                        <td>{{ $loanType->max_amount }}</td>
                        <td>{{ $loanType->loan_type }}</td>
                        <td>{{ $loanType->content }}</td>
                        <td>
                            <a href="#" title="Edit New Loan Type" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.loan.setting.loan.edit', ['id'=>$loanType->id]) }}" class="text-primary custom-btn globalModal">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
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
