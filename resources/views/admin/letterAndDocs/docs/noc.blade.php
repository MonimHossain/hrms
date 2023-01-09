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
                        This is to certify that Ms./Mr -------, D/O {{ $data->FullName }}, and Employee ID No: {{ $data->employer_id }} is a permanent employee of Genex Infosys Limited. He has been working with this company since 1st November, 2018 as Executive under Operations department.
                    </p>
                    <p>
                        He wishes to travel to Bhutan from 14th March, 2019 to 211st March, 2019 and management of Genex Infosys Limited has no objection in this regard.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    Minarul Islam<br/>
                    Head of People & Culture
                    <p>-------------------------------</p>
                </td>
            </tr>


        </table>
    </div>



</form>






