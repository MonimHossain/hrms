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
            <div class="card-body ">
                <div class="row">
                    <table class="table-bordered text-primary" width="100%">
                        <tr>
                            <th colspan="2">Permanent Employee</th>
                        </tr>
                       
                        <tr>
                            <td>{{ $result['permanet'] ?? 0 }}</td>
                            
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
                            <th colspan="2">Contractual Employee</th>
                        </tr>
                       
                        <tr>
                            <td>{{ $result['contractual'] ?? 0 }}</td>
                           
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
                            <th colspan="2">Probation Employee</th>
                        </tr>
                        
                        <tr>
                            <td>{{ $result['probation'] ?? 0 }}</td>
                            
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
                            <th colspan="2">Hourly Employee</th>
                        </tr>
                        
                        <tr>
                            <td>{{ $result['hourly'] ?? 0 }}</td>
                            
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
                           route="{{ route('payroll.hold.statement.clearance', ['year'=>$result['year'], 'month'=>$result['month']]) }}"
                           smg="Do you want to give clearance" type="submit" class="btn btn-outline-warning confirm">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


