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
                        Loan Statement : {{ \Carbon\Carbon::now()->format('M, Y') }}
                    </h3>
                </div>
                <div class="form-group">
                  @if($generate)
                    <a href="#" route="{{ route('admin.loan.statement.update.emi.generate') }}" smg="Do you want to generate loan statement" type="submit" class="btn btn-outline-info confirm" style="position: relative; top: 13px">Generate</a>
                  @endif
                  @if($confirmation)
                      <a href="#" route="{{ route('admin.loan.statement.update.emi.clearance') }}" smg="Do you want to generate loan statement" type="submit" class="btn btn-outline-warning confirm" style="position: relative; top: 13px">Clearance</a>
                  @endif


                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                    <table class="table table-bordered" id="html_table">
                        <thead>
                            <tr>
                                <th title="Field #1">Ref ID</th>
                                <th title="Field #2">Employee Id</th>
                                <th title="Field #3">Name</th>
                                <th title="Field #4">EMI</th>
                                <th title="Field #5">Due Amount</th>
                                <th title="Field #6">Status</th>
                                <th title="Field #7">Actions</th>
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
                            <td>{{ $application->loan->employee->FullName }}</td>
                            <td style="color : {{ $color }}">{{ $application->amount }} </td>
                            <td>{{ $application->amount_due }}</td>
                            <td>{{ trans('payroll.loan.process.'.$application->status) }}</td>
                            <td>
                                @if(($application->loan->loanGeneralApp->status ?? 0) == $approvedValue)
                                    @if($confirmation)
                                        <a href="#" title="Loan Statement Update EMI Change" form-size="modal-md" data-toggle="modal"  data-target="#kt_modal" action="{{ route('admin.loan.statement.emi.change', ['id'=>$application->id]) }}" class="btn-sm btn-outline-primary text-primary custom-btn globalModal">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    @endif
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

    <!-- end:: Content -->
@endsection

@include('layouts.confirmation-alert-smg')
