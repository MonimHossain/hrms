


    <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-home-tab">
        <table class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Gross Salary</th>
                    <th>Cumulative Tax</th>
                    <th>Payable Tax</th>
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


