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
                <td colspan="2">Govt. Holiday Payment</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Final Payble Days</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Payable Amount (Fixed Salary)</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Payable Amount (OT&Others)</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">KPI Incentive</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Previous Adjustment (+/-)</td><td>3</td>
            </tr>
            <tr>
                <td colspan="2">Payable Amount (Fixed Salary)</td><td>3</td>
            </tr>
            <tr>
                <td colspan="3">
                    <br>
                </td>
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

