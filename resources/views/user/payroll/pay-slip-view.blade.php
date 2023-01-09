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
                    <span class="font-weight-bolder mb-2"><b>Employee Name:</b>  <span class="opacity-70">{{ $salaryBreakdown['userInfo']['name'] ?? ''}}</span></span>
                </div>


                <div class="d-flex flex-column flex-root">
                    <span class="font-weight-bolder mb-2"><b>Pay Period:</b>
                        <span class="opacity-70">{{ $salaryBreakdown['userInfo']['start_date'] ?? ''}}</span> &nbsp;<b>To</b>&nbsp;
                        <span class="opacity-70">{{ $salaryBreakdown['userInfo']['end_date'] ?? ''}}</span>
                    </span>
                    <!-- <span class="font-weight-bolder mb-2"><b>Payment Date:</b>
                        <span class="opacity-70">{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</span>
                    </span> -->
                </div>
            </div>
        </div>
    </div>
    <!-- end: Invoice header-->

    <!-- begin: Invoice body-->
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            @isset($salaryBreakdown['breakdown'])
            <b>Salary Breackdown</b>
            <div class="table-responsive">
                <table class="table">
                        <tr>
                            <th class="pl-0 font-weight-bold text-muted  text-uppercase">Description</th>
                            <!-- <th class="text-right font-weight-bold text-muted text-uppercase">Percent (%)</th> -->
                            <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                        </tr>

                        @foreach($salaryBreakdown['breakdown'] as $value)
                        <tr class="font-weight-boldest">
                            <td class="pl-0 pt-7"> {{ $value[0] }}</td>
                            <!-- <td class="text-right pt-7">{{ $value[1] }}</td> -->
                            <td class="text-danger pr-0 pt-7 text-right">{{ $value[2] }}</td>
                        </tr>
                        @endforeach
                        <!-- <tr class="font-weight-boldest border-bottom-0">
                            <td class="border-top-0 pl-0 py-4">Home Allowance</td>
                            <td class="border-top-0 text-right py-4">27.5%</td>
                            <td class="text-danger border-top-0 pr-0 py-4 text-right">17,875.00</td>
                        </tr>
                        <tr class="font-weight-boldest border-bottom-0">
                            <td class="border-top-0 pl-0 py-4">Conveyance Allowance</td>
                            <td class="border-top-0 text-right py-4">9%</td>
                            <td class="text-danger border-top-0 pr-0 py-4 text-right">5,850‬.00</td>
                        </tr>
                        <tr class="font-weight-boldest border-bottom-0">
                            <td class="border-top-0 pl-0 py-4">Medical Allowance</td>
                            <td class="border-top-0 text-right py-4">8.5%</td>
                            <td class="text-danger border-top-0 pr-0 py-4 text-right">5,525.00</td>
                        </tr> -->

                </table>
            </div>
            @endisset
        </div>
    </div>

    @isset($salaryBreakdown['adjustment'])
        <div class="row justify-content-center py-4 px-4 py-md-5 px-md-0">
            <div class="col-md-5">
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
                                <td class="text-right pt-7 text-uppercase text-right text-success">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-1">&nbsp;</div>

            <div class="col-md-5">
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
                                <td class="text-right pt-7 text-uppercase text-right text-success">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <th class="font-weight-bold text-muted  text-uppercase">Gross Salary</th>
                            <th class="font-weight-bold text-muted  text-uppercase">Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder">
                            <td>{{ $salaryBreakdown['userInfo']['bankInfo']['name'] ?? ''}}</td>
                            <td>{{ $salaryBreakdown['userInfo']['bankInfo']['account'] ?? ''}}</td>
                            <td>{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</td>
                            <td class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gross'] ?? ''}}</td>
                            <td class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gndAmount'] ?? ''}}</td>
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
