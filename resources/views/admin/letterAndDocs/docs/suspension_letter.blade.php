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
                    <span>Subject :</span> <span class="bolder-text">Suspension Letter</span>
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
                        It has been observed that you are not performing your duties properly in terms of your assigned works by your line management. Every month you have lag. After doing lag, you don't cover the lag within the following week. Last month, you were instructed not to leave office without covering lag. But you left office without covering lag. You don't co-operate with team as well as don't follow instruction. Most of the time, you don’t pick phone & not responsible towards work.
                    </p>
                    <p>
                        Based on your above behavior, your line management advised you several times to improve yourself towards your job responsibility and your commitment but you always failed to keep your commitment whatever you have promised. In this situation, our strict operational issues are being hampered.
                    </p>
                    <p>
                        Therefore, you are suspended for seven days from the process dated from 8th May, 2015 to 14th May, 2015 and it is highly expected to you to follow the company’s instructions and improve your performance in future.
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

