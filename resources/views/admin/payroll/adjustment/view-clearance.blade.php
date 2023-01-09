<div class="row">
    <div class="paper col-sm-12">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">

                    <p class="card-category text-sm">Salary : {{ $adjustmentGenerateData['month'] ?? '' }}-{{ $adjustmentGenerateData['year'] ?? '' }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="paper col-sm-12">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <table class="table-bordered text-primary" width="100%">
                        <tr>
                            <th>Adjustment Type</th>
                            <th>Adjustment Amount</th>
                        </tr>
                        @foreach($adjustmentGenerateData['result'] as $row)
                        <tr>
                            <td>{{ $row['adjustment'] ?? 0 }}</td>
                            <td>{{ $row['amount'] ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="paper col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <a href="#" style="position: relative; left: 5px"
                           route="{{ route('payroll.adjustment.statement.clearance', ['year'=>$adjustmentGenerateData['year'], 'month'=>$adjustmentGenerateData['month']]) }}"
                           smg="Do you want to give clearance" type="submit" class="btn btn-outline-warning confirm">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


