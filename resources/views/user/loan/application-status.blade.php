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
                        Loan History
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">

                    <div class="kt-section">
                        <div class="kt-section__content">

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
                                        @foreach($loanApplication as $application)
                                        <tr>
                                            <td>{{ $application->reference_id }}</td>
                                            <td>{{ $application->created_at->format('d M, Y') }}</td>
                                            <td>{{ $application->approvedBy->FullName ?? '-' }}</td>
                                            <td>{{ $application->loanType->loan_type }}</td>
                                            <td>{{ $application->interval }}</td>
                                            <td>{{ $application->amount }}</td>
                                            <td>{{ trans('payroll.loan.status.'.$application->status) }}</td>
                                            <td>
                                                @if($application->status == 1)
                                                <a href="#" title="Loan Application Edit" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('loam.application.edit', ['id'=>$application->id]) }}" class="text-primary custom-btn globalModal">
                                                    Edit
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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


    @push('js')

        <script>
            $(document).on('change', '#loan_type', function()
            {
                var id = $(this).val();
                $('#termAndCondition').html('');
                $("#interval").html("");
                $.ajax({
                    url: "{{ route('loan.term.condition') }}",
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}","id": id},
                    success: function(data) {
                        var result = JSON.parse(data);
                        $('#termAndCondition').html(result.content);
                        $('#amount').attr('max', result.max_amount);

                        for(var i=1; i <(result.interval+1); i++)
                        {
                            $("#interval").append(new Option(i, i));
                        }
                    }
                });
            });

        </script>

    @endpush

@endpush
