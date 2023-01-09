<form class="kt-form page" action="{{ route('settings.manage.document.create') }}" method="POST">
    @csrf
    <div class="row">
        <table class="container">
            <tr>
                <td colspan="3">
                    <p>
                        <span>Date :</span>
                        <span>{{ date('d/m/Y') }}</span><br>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h6>{{ $data->FullName }}</h6>
                    <h6>ID: {{ $data->employer_id }}</h6>
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
                    <span>Subject :</span> <span class="bolder-text">Letter of Termination</span>
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
                        Your contract is terminated with immediate effect.
                    </p>
                    <p>
                        You may collect your dues, if any, from the HR department on any working day after getting necessary clearance from all concerned.
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
            <tr>
            <td>
                Copy To:
                <ol>
                    <li>Director</li>
                    <li>Concerned HOD</li>
                    <li>Employee’s Personal File</li>
                </ol>
            </td>
            </tr>
       </table>
    </div>



</form>

