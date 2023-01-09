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
                    <span>Subject :</span> <span class="bolder-text">Release Letter</span>
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
                        This refers to your resignation dated April 03, 2019 from the position of Customer Service Officer under Operations Department.
                    </p>
                    <p>
                        The Management of Genex Infosys Limited has accepted your resignation and you are hereby released from the service of the Company effective from June 03, 2019 (Close of Business). So far you do not have any pending issues with the organization.
                    </p>
                    <p>
                        We wish you a successful career.
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

