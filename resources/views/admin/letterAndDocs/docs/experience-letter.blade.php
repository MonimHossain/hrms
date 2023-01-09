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
                        <span>Ref :</span>
                        <span>{{ $ref }}</span><br>
                        <span>Date :</span>
                        <span>{{ date('d/m/Y') }}</span><br>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">
                    <h6>TO WHOM IT MAY CONCERN </h6>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p>
                        This is to certify that Mr. {{ $data->FullName }}, Employee ID No: 318 worked in Genex Infosys Limited from [Date] to [Date]. He was designated as Chief Information Officer (CIO) under Quality Assurance Department.
                    </p>
                    <p>
                        During his tenure, he performed his duties with excellence and sincerity. He was dedicated to his job and maintained a very cordial relation with his teammates.
                    </p>
                    <p>
                        We wish him all the success for his future.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    Nazmul Hossain Shahin<br/>
                    Head of HR
                    <p>-------------------------------</p>
                </td>
            </tr>


        </table>
    </div>
</form>






