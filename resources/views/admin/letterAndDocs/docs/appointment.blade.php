@push('css')

    <style>
        table {
            text-align: justify;
            text-justify: inter-word;
            margin: 50px
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
                            <span>{{ date('m/d/Y') }}</span><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h6>Mr./Ms. [Name]</h6>
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
                        <span>Subject :</span> <span class="bolder-text">Letter Of Appointment</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><span>Dear Mr. </span><span style="font-weight: bold">[Name]</span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            With reference to your application and subsequent interviews with us, the management is pleased to appoint you as Executive with effect from September 4, 2014 under the following terms and conditions:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            <ol>
                                <li>
                                    Employment: You will be on probation for a period of six months from the date of joining and on satisfactory completion of probation period the official confirmation letter will be issued in due course. Your service may be terminated without any notice during the probation period at management’s discretion.
                                </li>
                                <li>
                                    Remuneration: During the probation period you will receive salary of Tk. ---------- (Taka ------- Thousand Only) as per the following breakdown:
                                    <ol type="I">
                                        <li> Basic -----------------		Tk</li>
                                        <li> House Rent -----------	    Tk</li>
                                        <li> Conveyance ---------	    Tk</li>
                                        <li> Medical --------------  	Tk.</li>
                                        <li> Medical -------------- 	Tk.</li>
                                    </ol>
                                    Total	=		Tk.<br>
                                    As per the current taxation rules, taxes due on your remuneration shall be deducted at source and deposited to treasury directly by the company. A copy of the paid treasury receipt will be delivered to you periodically.
                                </li>

                                <li>
                                    Benefits: You will be entitled for other admissible benefits like PF, Gratuity, Group Insurance, hospitalization, if applicable as per the company policy.
                                </li>
                                <li>
                                    Duties: You will observe the normal attendance hours of the company applicable to the location of your position. You will devote your whole time and attention to the business of the company, obey and observe all lawful instructions given to you.
                                </li>
                                <li>
                                    Restrictions: During the employment with the company you will not engage yourself directly or indirectly in any business other than that of this company.
                                </li>
                                <li>
                                    Confidentiality: During your employment you will not divulge to any person/persons any secret/confidential information which you may have acquired as a result of employment with the company. If you disclose any such information to any other person, the company will take such action, as it considers necessary to protect or enforce its rights against you and / or such other person.
                                </li>
                                <li>
                                    Posting: Your initial posting shall be at our office located at Uttara in Dhaka. However, the management reserves the right to relocate you at any other location.
                                </li>
                                <li>
                                    Working Hour & Leave: Your working day and weekly off will be as per policy and business requirement of the company. You will be allowed to enjoy leave as per company leave policy as may be applicable from time-to-time.
                                </li>
                                <li>
                                    Concealment of Information: On assumption of appointment, at any stage, if any misrepresentation or concealment of fact is detected in your bio-data, action will be taken which may lead to dismissal from service.
                                </li>
                                <li>
                                    Your service shall be governed by the prevailing rules and regulations of the company as may be applicable from time-to time.
                                </li>
                                <li>
                                    You are expected to demonstrate a high standard of integrity, commitment, initiative, punctuality and good manners while discharging your responsibilities.
                                </li>
                                <li>
                                    On or before joining, you are requested to submit copy of following documents to the HR Department:
                                    <ol type="A">
                                        <li>
                                            Copy of the national ID card
                                        </li>
                                        <li>
                                            2 (two) copies of passport size photographs
                                        </li>
                                        <li>
                                            Copy of certificates/mark sheets in support of your academic qualification
                                        </li>
                                        <li>
                                            Copy of release letter from your previous employer
                                        </li>
                                        <li>
                                            Salary certificate in proof of last salary
                                        </li>
                                    </ol>
                                </li>
                            </ol>




                            Please sign and return to us a copy of this appointment letter duly accepted by you.

                            We welcome you to the Genex family and look forward to a long-term association with you.


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
                    <td>&nbsp;</td>
                    <td>
                        [Tanvir Hossain]
                        <p>-------------------------------</p>
                    </td>
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






