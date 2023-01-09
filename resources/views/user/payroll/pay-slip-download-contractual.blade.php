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

@if(!empty($salaryBreakdown['userInfo']['summary']))
    {{--        {{ dd($salaryBreakdown['userInfo']['adjustment']) }}--}}
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-11">
            <b>Adjustment Details</b>
            <div class="table-responsive">
                <table class="table" style="width: 100%; border-collapse: collapse;" border="0">
                    <tr>
                        <th style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 font-weight-bold text-muted  text-uppercase">Name</th>
                        <th style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                    </tr>
                    @foreach($salaryBreakdown['userInfo']['summary'][0] as $key=> $value)
                        <tr class="font-weight-boldest">
                            <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> {{ $key ?? '' }}</td>
                            <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger pr-0 pt-7 text-right">{{ $value ?? '' }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-weight-boldest">
                        <td  style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> Adjustment</td>
                        <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger pr-0 pt-7 text-right">{{ $adjustment ?? 0 }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> Other Allowance</td>
                        <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger pr-0 pt-7 text-right">{{ $allowance ?? 0 }}</td>
                    </tr>
                    <tr class="font-weight-boldest">
                        <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="pl-0 pt-7"> KPI</td>
                        <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger pr-0 pt-7 text-right">{{ $kpi ?? 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif



<br><br>
<table class="table" style="width: 100%; border-collapse: collapse;" border="0">
    <thead>
        <tr>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">BANK</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">ACC.NO.</th>
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">DUE DATE</th>
{{--            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Gross Salary</th>--}}
            <th class="font-weight-bold text-muted  text-uppercase" style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;">Payable</th>
        </tr>
    </thead>
    <tbody>
        <tr class="font-weight-bolder">
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['bankInfo']['name'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['bankInfo']['account'] ?? ''}}</td>
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $salaryBreakdown['userInfo']['month'] ?? ''}}</td>
{{--            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gross'] }}</td>--}}
            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;" class="text-danger font-size-h3 font-weight-boldest">{{ $salaryBreakdown['userInfo']['gndAmount'] }}</td>
        </tr>
    </tbody>
</table>











