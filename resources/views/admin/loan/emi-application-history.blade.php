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
                        Reduce Application
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <table class="table table-bordered" id="html_table">
                    <thead>
                        <tr>
                            <th>Ref ID</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Applied At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emiAppList as $row)
                            <tr>
                                <td>{{ $row->referenceId->reference_id ?? '-' }}</td>
                                <td>{{ $row->referenceId->employee->employer_id ?? '-' }}</td>
                                <td>{{ $row->referenceId->employee->FullName ?? '-' }}</td>
                                <td>{{ $row->created_at->format('d M, Y') }}</td>
                                <td>{{ trans('payroll.loan.status.'.$row->status) }}</td>
                                <td>
                                    <a href="#" title="EMI Reduce Application Status Change" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.loan.emi.application.history.edit', ['id'=>$row->id]) }}" class="btn-sm btn-outline-primary text-primary custom-btn globalModal">
                                        <i class="fas fa-check-circle"></i>
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
