<div class="row">
    <div class="paper col-sm-12">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">

                    <p class="card-category text-sm">Salary : {{ $result['month'] ?? '' }}-{{ $result['year'] ?? '' }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="paper col-sm-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                        <table class="table-bordered text-primary" width="100%">
                            <tr>
                                <th colspan="2">PF Eligible Employee</th>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>Amount</td>
                            </tr>
                            <tr>
                                <td>{{ $result['emp_count'] ?? 0 }}</td>
                                <td>{{ $result['total_amount'] ?? 0 }}</td>
                            </tr>
                        </table>

                </div>
            </div>
        </div>
    </div>
    <div class="paper col-sm-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">
                    <table class="table-bordered text-primary" width="100%">
                        <tr>
                            <th colspan="2">Generated</th>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>Amount</td>
                        </tr>
                        <tr>
                            <td>{{ $result['generated'] ?? 0 }}</td>
                            <td>{{ $result['generated-amount'] ?? 0 }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="paper col-sm-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">

                    <table class="table-bordered text-primary" width="100%">
                        <tr>
                            <th colspan="2">Disabled</th>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>Amount</td>
                        </tr>
                        <tr>
                            <td>{{ $result['disabled'] ?? 0 }}</td>
                            <td>{{ $result['disabled-amount'] ?? 0 }}</td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <div class="paper col-sm-3">
        <div class="card card-stats">
            <div class="card-body ">
                <div class="row">

                    <table class="table-bordered text-primary" width="100%">
                        <tr>
                            <th colspan="2">Hold</th>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>Amount</td>
                        </tr>
                        <tr>
                            <td>{{ $result['hold'] ?? 0 }}</td>
                            <td>{{ $result['hold-amount'] ?? 0 }}</td>
                        </tr>
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
                           route="{{ route('payroll.provident.fund.statement.clearance', ['year'=>$result['year'], 'month'=>$result['month']]) }}"
                           smg="Do you want to give clearance" type="submit" class="btn btn-outline-warning confirm">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


