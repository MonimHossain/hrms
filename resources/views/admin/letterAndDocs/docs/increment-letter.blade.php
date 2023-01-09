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
                        <h6>{{ $data->FullName }}</h6>
                        <span>[Address Line 1]</span><br>
                        <span>[Address Line 2]</span><br>
                        <span>[Dist: Noakhali]</span><br>
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
                    <td colspan="3"><span>Dear Mr. </span><span style="font-weight: bold">{{ $data->FullName }}</span></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            Considering your performance for last one year management has decided to promote you as --------------------. You will receive Tk. 20,000/= (Taka Twenty Thousand Only) as gross salary w.e.f 01 January 2015 as per the below structure:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>
                        <table>
                            <tr>
                                <td>
                                    Basic -------------		Tk
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    House Rent --------	    Tk
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Conveyance --------	    Tk
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Medical	-----------  	Tk.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Medical	----------- 	Tk.
                                </td>
                            </tr>
                            <tr>
                                <td style="border-top: 1px solid #646C9a">
                                    Total	=		Tk.
                                </td>
                            </tr>

                        </table>
                        <br>
                        As per the current taxation rules, taxes due on your remuneration shall be deducted at source and deposited to treasury directly by the company. A copy of the paid treasury receipt will be delivered to you periodically.
                        </p>
                        <p>
                            Other benefit/s shall remain unchanged until further notice.
                        </p>
                        <p>
                            We hope that you will keep continuation of rendering the best services to the company and at the same time enrich your career with us.
                        </p>
                        <p>Congratulations.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nazmul Hossain Shahin<br/>
                        Head of HR
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






