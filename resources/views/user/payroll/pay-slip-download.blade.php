<table style="width: 100%; border-collapse: collapse;" border="0">
    <tr>
        <td style="text-align:left">
            <h3 class="display-4 font-weight-boldest mb-10">PAYSLIP</h3>
        </td>
        <td style="text-align:right; float:right">
            <a href="#" class="mb-5" >
                <img style="text-align:right; float:right" height="50px" width="180px" src="{{ asset('/assets/media/company-logos/logo-2.png') }}" alt="">
            </a>
        </td>
    </tr>
    <tr>

        <td colspan="2">&nbsp; </td>
    </tr>
    <tr>
        <td colspan="2">
            <span class=" d-flex flex-column align-items-md-end opacity-70">
                <span>Nitol Niloy Tower (Level 8), Nikunja C/A, Airport Road</span>
                <span>Dhaka-1229</span>
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp; <br><br><br></td>
    </tr>
    <tr>
        <td>
            <div class="d-flex flex-column flex-root">
                <span class="font-weight-bolder mb-2"><b>Employee Name:</b>  <span class="opacity-70">{{ $salaryBreakdown['userInfo']['name'] ?? ''}}</span></span>
            </div>
        </td>
        <td>
            <span class="font-weight-bolder mb-2"><b>Pay Period:</b>
                <span class="opacity-70">{{ $salaryBreakdown['userInfo']['start_date'] ?? ''}}</span> &nbsp;<b>To</b>&nbsp;
                <span class="opacity-70">{{ $salaryBreakdown['userInfo']['end_date'] ?? ''}}</span>
            </span>
        </td>
    </tr>
</table>

<br><br>
    <!-- end: Invoice header-->

    <!-- begin: Invoice body-->
@isset($salaryBreakdown['breakdown'])

<b>Salary Breackdown</b>
<table class="table" style="width: 100%; border-collapse: collapse;" border="0">
        <tr>
            <th class="pl-0 font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Description</th>
            <!-- <th class="text-right font-weight-bold text-muted text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Percent (%)</th> -->
            <th class="text-right pr-0 font-weight-bold text-muted text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Amount</th>
        </tr>

        @foreach($salaryBreakdown['breakdown'] as $value)
        <tr class="font-weight-boldest">
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> {{ $value[0] }}</td>
            <!-- <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-right pt-7">{{ $value[1] }}</td> -->
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger pr-0 pt-7 text-right">{{ $value[2] }}</td>
        </tr>
        @endforeach
</table>
<br>
<br>
@endisset

@isset($salaryBreakdown['adjustment'])

<table style="width: 100%;">
    <tr>
        <td style="width: 100%">
            <b>Addition</b>
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 5px;border: 1px solid black;border-collapse: collapse; ">Description</th>
                        <th style="padding: 5px;border: 1px solid black;border-collapse: collapse; ">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaryBreakdown['adjustment']['add'] as $key=> $value)
                    <tr class="font-weight-boldest">
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse; " class="pl-0 pt-7"> {{ $key }}</td>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse; " class="text-right pt-7">{{ $value }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </td>
        <td style="width: 100%">
            <b>Deduction</b>
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 font-weight-bold text-muted  text-uppercase" style="text-align:left">Description</th>
                        <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-right pr-0 font-weight-bold text-muted text-uppercase" style="text-align:left">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaryBreakdown['adjustment']['deduct'] as $key=> $value)
                    <tr class="font-weight-boldest">
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> {{ $key }}</td>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-right pt-7">{{ $value }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </td>
    </tr>
</table>
<br><br>
@endisset
<table class="table" style="width: 100%; border-collapse: collapse;" border="0">
    <thead>
        <tr>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">BANK</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">ACC.NO.</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">DUE DATE</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Gross Salary</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Payable</th>
        </tr>
    </thead>
    <tbody>
        <tr class="font-weight-bolder">
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['bankInfo']['name'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['bankInfo']['account'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gross'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gndAmount'] ?? ''}}</td>
        </tr>
    </tbody>
</table>











