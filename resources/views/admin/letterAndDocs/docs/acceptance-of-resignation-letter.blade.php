<form class="kt-form page" action="{{ route('settings.manage.document.create') }}" method="POST">
    @csrf
    <div class="row">
        <table class="container">
            <tr>
                <td colspan="3">
                    <p>
                        <span>Date :</span>
                        <span>9 November, 2019</span><br>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h6>{{ $data->FullName }}</h6>
                    <h6>{{ $data->employer_id }}</h6>
                    <h6>{{ $data->employeeJourney->department->name }}</h6>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 100px" colspan="3">
                    <span>Subject :</span> <span class="bolder-text">ACCEPTANCE OF YOUR RESIGNATION</span>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="3"><span>Dear Mr. </span><span style="font-weight: bold">{{ $data->FullName }}</span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <p>
                        With reference to your resignation letter dated 03rd July, 2018 this is to inform you that your resignation has been accepted effective from 30th September, 2018.
                    </p>
                    <p>
                        However, we will make your final settlement considering your notice period, leave balance and other relevant dues.
                    </p>
                    <p>
                        Your clearance shall be given in due course after necessary verifications. Therefore, you are requested to deposit the company ID card, corporate mobile numbers and any other company property entrusted to you during your employment with us, on or before your last working date.
                    </p>
                    <p>
                        We wish you all success in your future endeavors.
                    </p>
                </td>
            </tr>

            <tr>
                <td>
                    Thanking you.<br/>
                    <p>-------------------------------</p>
                </td>
                <td colspan="2"></td>
            </tr>
       </table>
    </div>



</form>

