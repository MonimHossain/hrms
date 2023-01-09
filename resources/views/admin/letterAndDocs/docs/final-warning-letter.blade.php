@push('css')
    <style>
        ol {
            line-height: 40px;
        }
        li {
            line-height: 60px;
        }

        .bolder-text {
            font-size: 18px;
            font-weight: bolder;
        }
        p, span {
            text-align: justify;
            text-justify: inter-word;
        }
    </style>
@endpush
<form class="kt-form" action="{{ route('settings.manage.document.create') }}" method="POST">
    @csrf
    <div class="row">
        <table class="container">
            <tr>
                <td colspan="3">
                    <p>
                        <span>Ref :</span>
                        <span>{{ $ref }}</span><br>

                        <span>Date :</span>
                        <span>{{ date('d/m/Y') }}</span><br>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h6>Mr. {{ $data->FullName }}</h6>
                    <span>[Address Line 1]</span><br>
                    <span>[Address Line 2]</span><br>
                    <span>Dist: [District]</span><br>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 100px" colspan="3">
                    <b><span>Subject :</span> <span class="bolder-text">FINAL WARNING LETTER</span></b>
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
                        With reference to QA Team, it has been found that you have violated the company’s code of conduct. That is you have done misbehave with customer which may consider as fatal error.
                    </p>
                    <p>
                        As per the policy, you have been given a last chance to follow our code of conduct and act accordingly with immediate effect.
                    </p>
                    <p>
                        Hope the warning letter will assist you to understand how important it is to follow the Code of Conduct from your end and you will do your utmost to improve the quality of your performance in the coming days.
                    </p>
                    <p>
                        We will monitor your performance closely for further necessary reviews.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p>
                        Thanking you.							   Terms and Conditions Accepted
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    Nazmul Hossain Shahin<br/>
                    Head of HR
                    <p>-------------------------------</p>
                </td>
                <td colspan="2">&nbsp;</td>
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






