


    <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-home-tab">
        <table class="table table-striped table-nowrap mb-0" width="100%" id="lookup">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Gross Salary</th>
                    <th>Cumulative PF</th>
                    <th>Payable PF</th>
                </tr>
            </thead>
            <tbody>
            @foreach($history as $row)
                <tr>
                    <td>{{ $row['month'] ?? '' }}</td>
                    <td>{{ $row['gross'] ?? '' }}</td>
                    <td>{{ $row['cumulative'] ?? '' }}</td>
                    <td>{{ $row['payable'] }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    
    
</div>


