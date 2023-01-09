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
                    <span class="font-weight-bolder mb-2"><b>Employee ID:</b>  <span class="opacity-70">{{ $salaryBreakdown['userInfo']['id'] ?? ''}}</span></span>
                    <span class="font-weight-bolder mb-2"><b>Employee Name:</b>  <span class="opacity-70">{{ $salaryBreakdown['userInfo']['name'] ?? ''}}</span></span>
                </div>


                <div class="d-flex flex-column flex-root">
                    {{-- <span class="font-weight-bolder mb-2"><b>Pay Period:</b>
                        <span class="opacity-70">24 June, 2020</span> &nbsp;<b>To</b>&nbsp;
                        <span class="opacity-70">24 July, 2020</span>
                    </span> --}}
                    <span class="font-weight-bolder mb-2"><b>Payment of: </b>
                        <span class="opacity-70">{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- end: Invoice header-->

    <!-- begin: Invoice body-->
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">

            <b>Hour Details</b>
            <div class="table-responsive">
                <table class="table">
                        <tr class="">
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase text-center">Quantity</th>
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase text-right">Amount</th>
                        </tr>
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> Ready Hour</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-center">{{ $salaryBreakdown['userInfo']['hourInfo']['ready_hour'] }}</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-right">{{ number_format($salaryBreakdown['userInfo']['hourInfo']['ready_hour_amount'], 2) }}</td>
                        </tr>
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> Lag Hour</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-center">{{ $salaryBreakdown['userInfo']['hourInfo']['lag_hour'] }}</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-right">{{ number_format($salaryBreakdown['userInfo']['hourInfo']['lag_hour_amount'], 2) }}</td>
                        </tr>
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> Break Hour</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-center">00:00:00</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-right">0.00</td>
                        </tr>
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> OT</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-center">00:00:00</td>
                            <td class="pl-0 font-weight-bold text-muted  text-uppercase text-right">0.00</td>
                        </tr>
                </table>
            </div>

        </div>
    </div>

    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>KPI Details</b>
            <div class="table-responsive">
                <table class="table">
                        <tr>
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                            <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                        </tr>
                        @foreach($salaryBreakdown['userInfo']['kpiInfo'] as $key=> $value)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $key }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value }}</td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
    @if(!empty($salaryBreakdown['userInfo']['adjustment']))
{{--        {{ dd($salaryBreakdown['userInfo']['adjustment']) }}--}}
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
                    @foreach($salaryBreakdown['userInfo']['adjustment'] as $key=> $value)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $value['name'] ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value['type'] ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value['amount'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($salaryBreakdown['userInfo']['other']))
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
                    @foreach($salaryBreakdown['userInfo']['other'] as $key=> $value)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $value['name'] ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value['type'] ?? '' }}</td>
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value['amount'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif

    @isset($salaryBreakdown['adjustment'])
        <!-- <div class="row justify-content-center py-4 px-4 py-md-5 px-md-0"> -->
            <!-- <div class="col-md-5">
                <div class="table-responsive">
                    <b>Addition</b>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaryBreakdown['adjustment']['add'] as $key=> $value)
                            <tr class="font-weight-boldest">
                                <td class="pl-0 pt-7"> {{ $key }}</td>
                                <td class="text-right pt-7">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> -->

            <!-- <div class="col-md-1">&nbsp;</div> -->

            <!-- <div class="col-md-5">
                <div class="table-responsive">
                    <b>Deduction</b>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                                <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaryBreakdown['adjustment']['deduct'] as $key=> $value)
                            <tr class="font-weight-boldest">
                                <td class="pl-0 pt-7"> {{ $key }}</td>
                                <td class="text-right pt-7">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> -->
        <!-- </div> -->
    @endisset
    <!-- end: Invoice body-->

    <!-- begin: Invoice footer-->
    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="font-weight-bold text-muted  text-uppercase">BANK</th>
                            <th class="font-weight-bold text-muted  text-uppercase">ACC.NO.</th>
                            <th class="font-weight-bold text-muted  text-uppercase">DUE DATE</th>
{{--                            <th class="font-weight-bold text-muted  text-uppercase">Gross Salary</th>--}}
                            <th class="font-weight-bold text-muted  text-uppercase">Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder">
                            <td>{{ $salaryBreakdown['userInfo']['bankInfo']['name'] ?? ''}}</td>
                            <td>{{ $salaryBreakdown['userInfo']['bankInfo']['account'] ?? ''}}</td>
                            <td>{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</td>
{{--                            <td class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gross'] }}</td>--}}
                            <td class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['payable'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <div class="d-flex justify-content-between">

                <a href="{{ route('paySlip.employee.download', ['id'=>$id, 'type'=>$type]) }}" class="btn btn-primary">Print Pay Slip</a>
            </div>
        </div>
    </div>
