@push('css')

    <style>
        OL { counter-reset: item }
        LI { display: block }
        LI:before { content: counters(item, ".") " "; counter-increment: item }
    </style>

@endpush


<form class="kt-form" action="{{ route('settings.manage.document.create') }}" method="POST">
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
                        <h6>Mr./Ms.</h6>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100px" colspan="3">
                        <span>Subject :</span> <span class="bolder-text">CONFIRMATION OF SERVICE</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><span>Dear,</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            Considering the performance during the probation period, management is pleased to confirm your service as Executive from  under the following terms and conditions:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            <ol>
                                <li>
                                    <b>Salary & Benefit:</b>
                                    <ol>
                                        <li>
                                            <b>Salary: </b>
                                            Employment: You will be on probation for a period of six months from the date of joining and on satisfactory completion of probation period the official confirmation letter will be issued in due course. Your service may be terminated without any notice during the probation period at management’s discretion.
                                            <ol type="I">
                                                <li> Basic -------------		Tk</li>
                                                <li> House Rent --------	    Tk</li>
                                                <li> Conveyance --------	    Tk</li>
                                                <li> Medical	-----------  	Tk.</li>
                                                <li> Medical	----------- 	Tk.</li>
                                            </ol>
                                            As per the current taxation rules, taxes due on your remuneration shall be deducted at source and deposited to treasury directly by the company. A copy of the paid treasury receipt will be delivered to you periodically.
                                        </li>
                                        <li>
                                            <b>Provident Fund:</b>
                                            According to the organization policy your PF contribution will be 7% of basic and the same amount would be contributed by the organization as well. For getting company contribution fully an employee has to have at least 3 years of continuous service with the company.
                                        </li>
                                        <li>
                                            <b>Festival Bonus:</b>
                                            You will receive two festival bonuses in a calendar year, each bonus shall be equivalent to 1 basic salary.
                                        </li>
                                        <li>
                                            <b>Insurance & Hospitalization:</b>
                                            Your life insurance & Hospitalization shall be as per policy of the company.
                                        </li>
                                        <li>
                                            <b>Gratuity:</b>
                                            After completion of 5 years of continuous service with the company you will be entitled for gratuity. At the end of your service tenure you will be getting 1 month basic salary for every completed year of service with the company. Which shall be calculated based on last drawn salary.
                                        </li>
                                    </ol>
                                </li>
                                <li>
                                    <b>Integrity:</b>
                                    While employed with this Company, you agree to refrain from engaging in any activity which is prejudicial to the interest of the Company or which interferes with the performance of your job, whether within or outside your working hours without the prior consent of the Company. The company shall be at liberty to initiate appropriate action against you if any integrity issue is identified.
                                </li>
                                <li>
                                    <b>Non-Disclosure of Information: </b>
                                    You agree that all records and documents of the company and its clients and all information pertaining to their affairs are confidential and that no unauthorized discloser / reproduction of the same will be made by you at any time during or after your employment with the company. You agree to abide by all appropriate procedures to ensure the protection of the Company’s confidential proprietary and trade secret information. The provisions of this section shall apply even after the term of this agreement. You further recognize all such confidential information is intellectual properties of the company.
                                </li>
                                <li>
                                    <b>Confidentiality: </b>
                                    In the event that you violate the confidentiality or any other obligation contained herein, you agree that the company shall have the right to enjoin or restrain you from continuing with such act through the appropriate process according to policy.
                                </li>
                                <li>
                                    <b>Placement/Posting:</b>
                                    You may be assigned to any other position within the Unit or Group as and when needed to the Company’s sole judgment and save for any diminution of salary and other benefits.
                                </li>
                                <li>
                                    <b>Termination:</b>
                                    The Company may terminate your employment without assigning any reason thereof at any time by giving 120 days advance notice in writing or pay in lieu thereof. You may terminate this agreement of service by giving the Company 2 (two) month’s advance notice in writing or pay in lieu thereof.
                                </li>
                                <li>
                                    <b>Handing Over Assets: </b>
                                    You agree to immediately surrender all records, documents and properties of the Company those lying under your custody, if requested during employment and at the termination thereof whether or not requested. You further recognize that you hold those records, documents and properties in trust of the Company.
                                </li>
                                <li>
                                    It is expressly agreed and understood that there is no verbal agreement of understanding between you and the Company affecting this agreement. Other than those provided under Company policies, rules and regulations and that on alterations variations of the terms hereof, shall be binding upon either party to this agreement unless the same are reduced in writing and signed by you and the Company.
                                </li>

                                <li>
                                    We welcome you to the “Genex” family and trust your association with us will be mutually beneficial.

                                    Your signature on the space provided below will indicate your acceptance of the foregoing terms and conditions.
                                </li>
                            </ol>
                            Thanking you.
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
                        Tanvir Hossain
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






