    <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0 invoice-body" id="printcontent">
        <div class="col-md-11">
            {{-- <img alt="Logo" src="http://localhost:8000/assets/media/company-logos/logo-2.png"> --}}
            <div class="d-flex justify-content-between pb-20 pb-md-10 flex-column flex-md-row">
                <h3 class="display-4 font-weight-boldest mb-10">PAYSLIP</h3>
                <div class="d-flex flex-column align-items-md-end px-0">
                    <!--begin::Logo-->
                    <a href="#" class="mb-5">
                        <img src="{{ asset('/assets/media/company-logos/logo-2.png') }}" alt="">
                    </a>
                    <!--end::Logo-->
                    <span class=" d-flex flex-column align-items-md-end opacity-70">
                        <span>Nitol Niloy Tower (Level 8), Nikunja C/A, Airport Road</span>
                        <span>Dhaka-1229</span>
                    </span>
                </div>
            </div>
            <div class="border-bottom w-100 mt-5"></div>
            <div class="d-flex justify-content-between pt-5 pb-5">
                <div class="d-flex flex-column flex-root">
                    <span class="font-weight-bolder mb-2"><b>Employee ID:</b>  <span class="opacity-70">{{ $employee->employer_id ?? ''}}</span></span>
                    <span class="font-weight-bolder mb-2"><b>Employee Name:</b>  <span class="opacity-70">{{ $employee->fullName ?? ''}}</span></span>
                </div>


                <div class="d-flex flex-column flex-root">
                    <span class="font-weight-bolder mb-2"><b>Pay Period:</b>
                        <span class="opacity-70">{{ $payslip_data->cycle_start ?? ''}}</span> &nbsp;<b>To</b>&nbsp;
                        <span class="opacity-70">{{ $payslip_data->cycle_end ?? ''}}</span>
                    </span>
                    <span class="font-weight-bolder mb-2"><b>Payment of: </b>
                        <span class="opacity-70">{{ $payslip_data->month ?? ''}}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- end: Invoice header-->

    <!-- begin: Invoice body-->


    <!-- Comment Start Here -->
   {{-- @if(!empty($salaryBreakdown))
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Salary Details</b>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Count</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> Total Payable Days</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ $salaryBreakdown->present ?? '0.00' }}</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($salaryBreakdown->present * $salaryBreakdown->perday_salary, 2) ?? 0.00 }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> Total Payable Holidays</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ $salaryBreakdown->holiday_present ?? '0.00' }}</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($salaryBreakdown->holiday_present * ($salaryBreakdown->perday_salary), 2) ?? 0.00 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endif



    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>KPI Details</b>
            <div class="table-responsive">
                <table class="table">
                        <tr>
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Grade</th>
                            <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                        </tr>
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $salaryBreakdown->kpi_grade }}</td>
                            <td class="text-success pr-0 pt-7 text-right">{{ $salaryBreakdown->kpi_bonus }}</td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
    @if(json_decode($adjustment_data->adjustment_addition) || json_decode($adjustment_data->adjustment_deduction))
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Adjustment Details</b>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Name</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Type</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    @foreach(json_decode($adjustment_data->adjustment_addition) as $key => $addition)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="pr-0 pt-7 text-right text-success">(+)</td>
                            <td class="pr-0 pt-7 text-right test-success">{{ $addition ?? '' }}</td>
                        </tr>
                    @endforeach
                    @foreach(json_decode($adjustment_data->adjustment_deduction) as $key => $deduction)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">(-)</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $deduction ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif

    @if(json_decode($allowance_data->allowance_addition) || json_decode($allowance_data->allowance_deduction))
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Other Allowance Details</b>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Name</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Type</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    @foreach(json_decode($allowance_data->allowance_addition) as $key => $addition)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="pr-0 pt-7 text-right text-success">(+)</td>
                            <td class="pr-0 pt-7 text-right test-success">{{ $addition ?? '' }}</td>
                        </tr>
                    @endforeach
                    @foreach(json_decode($allowance_data->allowance_deduction) as $key => $deduction)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">(-)</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $deduction ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
    --}}
    <!-- Comment Start Here -->


    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <div class="table-responsive">
                <table class="table">
                    <!-- <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Count</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr> -->
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> KPI Grade</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ $salaryBreakdown->kpi_grade ?? '-' }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> Total Payable Days</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ $salaryBreakdown->present ?? '0.00' }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> Amount</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($salaryBreakdown->present * $salaryBreakdown->perday_salary, 2) ?? 0.00 }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> OT Amount</td>
                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($salaryBreakdown->holiday_present * ($salaryBreakdown->perday_salary), 2) ?? 0.00 }}</td>                        
                    </tr>
                    <tr class="font-weight-boldest">
                        <td class="pl-0 pt-7"> KPI Amount</td>                        
                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($salaryBreakdown->kpi_bonus ?? 0, 2) ?? 0.00 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @if(json_decode($adjustment_data->adjustment_addition) || json_decode($adjustment_data->adjustment_deduction))
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Adjustment Details</b>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Name</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Type</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    @foreach(json_decode($adjustment_data->adjustment_addition) as $key => $addition)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="pr-0 pt-7 text-right text-success">(+)</td>
                            <td class="pr-0 pt-7 text-right test-success">{{ $addition ?? '' }}</td>
                        </tr>
                    @endforeach
                    @foreach(json_decode($adjustment_data->adjustment_deduction) as $key => $deduction)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">(-)</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $deduction ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif

    @if(json_decode($allowance_data->allowance_addition) || json_decode($allowance_data->allowance_deduction))
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Other Allowance Details</b>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="pl-0 font-weight-bold text-muted  text-uppercase">Name</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Type</th>
                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    @foreach(json_decode($allowance_data->allowance_addition) as $key => $addition)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="pr-0 pt-7 text-right text-success">(+)</td>
                            <td class="pr-0 pt-7 text-right test-success">{{ $addition ?? '' }}</td>
                        </tr>
                    @endforeach
                    @foreach(json_decode($allowance_data->allowance_deduction) as $key => $deduction)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">(-)</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $deduction ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif


    <!-- begin: Invoice footer-->
    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="font-weight-bold text-muted  text-uppercase">BANK</th>
                            <th class="font-weight-bold text-muted  text-uppercase">ACC.NO.</th>
                            <th class="font-weight-bold text-muted  text-uppercase">Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder">
                            <td>{{ $bankInfo['name'] ?? ''}}</td>
                            <td>{{ $bankInfo['account'] ?? ''}}</td>
                            <td>{{ number_format($payslip_data->payable_salary, 2) ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <p class="text-center">
                Note: This is system generated payslip does not required seal and signature
            </p>
        </div>
    </div>
    @if(!$is_download)
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-11">
                <div class="d-flex justify-content-between">

                    <a href="{{ route('paySlip.emp.download', ['id'=>$id, 'type'=>$type]) }}" class="btn btn-primary">Print Pay Slip</a>
                </div>
            </div>
        </div>
    @endif
