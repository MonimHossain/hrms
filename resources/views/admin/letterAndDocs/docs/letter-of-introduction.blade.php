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
                        This is to certify that {{ $data->FullName }}, Emp. ID: {{ $data->employer_id }} has been working with this company since [Date] as a [Sr. Executive]. He has a good standard of discipline, punctuality, initiative & performance. To the best of our knowledge he is not engaged with any activity subversive to the country.
                    </p>
                    <p>
                        We wish him every success in his career.
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






