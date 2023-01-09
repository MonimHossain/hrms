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
                    <span>Subject :</span> <span class="bolder-text"><b>Advisory Letter</b></span>
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
                        It has been reported against you that, on [Date] around [Time] while you’re on duty you’re using a proxy server to watch Youtube. Such act is a violation of organizational policies and falls under severe disciplinary actions.
                    </p>
                    <p>
                        Considering your tenure in the company, management has been lenient to you for this time. You are hereby advised to deliver responsibilities with more cautiousness in line to organizational polices and supervisors consent.
                    </p>
                    <p>
                        It is expected that you will understand the importance of professional excellence in delivering your responsibility.
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


