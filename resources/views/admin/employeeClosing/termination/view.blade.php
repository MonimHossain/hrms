<div class="table-responsive">
    <table class="table table-bordered table-striped custom-table table-nowrap mb-0">
        <tr>
            <th>Applied At</th>
            <th>Clearance Status</th>
            {{--<th>Remarks</th>--}}
            <th>Final Close</th>
        </tr>
        @if(isset($closingApplication))
            @foreach($closingApplication as $close)
                <?php
                /*Status*/
                $hr_status = $close->closingClearanceStatus->hr_status ?? 0;
                $it_status = $close->closingClearanceStatus->it_status ?? 0;
                $admin_status = $close->closingClearanceStatus->admin_status ?? 0;
                $accounts_status = $close->closingClearanceStatus->accounts_status ?? 0;
                $own_dept_status = $close->closingClearanceStatus->own_dept_status ?? 0;

                /*Remarks*/
                /*$hr_clearance = $close->closingClearanceStatus->hr_clearance ?? '';
                $it_clearance = $close->closingClearanceStatus->it_clearance ?? '';
                $admin_clearance = $close->closingClearanceStatus->admin_clearance ?? '';
                $accounts_clearance = $close->closingClearanceStatus->accounts_clearance ?? '';
                $own_dept_clearance = $close->closingClearanceStatus->own_dept_clearance ?? '';*/

                $checkPending = '<i class="text-warning fa fa-flask"></i>';
                $checkYes = '<i class="text-primary fa fa-check"></i>';
                $checkNo = '<i class="text-danger fa fa-times"></i>';
                $selectStatusArray = [$checkPending, $checkYes, $checkNo];
                ?>
                <tr>
                    <td rowspan="5">
                        {{ \Carbon\Carbon::parse($close->applied_at)->format('d M, Y') }}
                    </td>
                    <td>
                        <p>Hr : <?php echo $selectStatusArray[$hr_status] ?></p>
                    </td>
                    {{--<td>
                        {!! \Illuminate\Support\Str::limit($hr_clearance, 50, '. . .') !!}
                    </td>--}}
                    <td rowspan="5">
                        {{ ($close->final_closing) ? 'Yes' : 'No' }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>IT : <?php echo $selectStatusArray[$it_status] ?></p>
                    </td>
                    {{--<td>
                        {!! \Illuminate\Support\Str::limit($it_clearance, 100, '. . .') !!}
                    </td>--}}
                </tr>
                <tr>

                    <td>
                        <p>Admin : <?php echo $selectStatusArray[$admin_status] ?></p>
                    </td>
                    {{--<td>
                        {!! \Illuminate\Support\Str::limit($admin_clearance, 50, '. . .') !!}
                    </td>--}}
                </tr>
                <tr>
                    <td>
                        <p>Accounts : <?php echo $selectStatusArray[$accounts_status] ?></p>
                    </td>
                    {{--<td>
                        {!! \Illuminate\Support\Str::limit($accounts_clearance, 50, '. . .') !!}
                    </td>--}}
                </tr>
                <tr>
                    <td>
                        <p>Own Department : <?php echo $selectStatusArray[$own_dept_status] ?></p>
                    </td>
                    {{--<td>
                        {!! \Illuminate\Support\Str::limit($own_dept_clearance, 50, '. . .') !!}
                    </td>--}}
                </tr>
            @endforeach
        @endif
    </table>

</div>
