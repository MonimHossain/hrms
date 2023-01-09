<form class="kt-form page" action="{{ route('settings.manage.document.create') }}" method="POST">
    @csrf
    <div class="row">
        <h2 style="text-align: center">Pay Slip</h2>
        <table class="container" border="1" style="width: 100%">
            <tr>
                <td colspan="2">Pay Cycle</td><td>16 May 2019 to 15 June, 2019</td>
            </tr>
            <tr>
                <td colspan="2">Employee ID</td><td>121212</td>
            </tr>
            <tr>
                <td colspan="2">Employee Name</td><td>Khayrul Hasan</td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="2">Inbound Login Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Inbound Overtime Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Outbound Login Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Outbound Overtime Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Backend / Support Login Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">KPI Payment</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Break Time Hours</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Lag Hrs. Adjustment</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Total Hours</td><td>45443</td>
            </tr>
            <tr>
                <td colspan="2">Adjustment: </td><td>N/A</td>
            </tr>
            <tr>
                <td colspan="2">Total Amount: </td><td>BDT 13,454</td>
            </tr>
            <tr>
                <td colspan="3">
                    *** This Pay Slip is computer generated and does not need any signature
                </td>
            </tr>
       </table>
    </div>



</form>

