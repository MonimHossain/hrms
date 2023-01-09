<table class="table table-condensed" style="border-collapse:collapse;" id="team-member-list">
    <thead>
    <tr>
        <th title="Serial Number">#</th>
        <th title="Name">Name</th>
        <th title="Department">Department</th>
        <th title="Process | Segment">Process | Segment</th>
        <th title="Email">Email</th>
        <th title="Phone">Phone</th>
        <th title="Action">Action</th>

    </tr>
    </thead>
    <tbody>
    @foreach ($result as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if (isset($item->profile_image))

                    <img class="rounded float-left img-fluid" width='35'
                         style="margin-right:10px;"
                         src="{{  asset('storage/employee/img/thumbnail/'.$item->profile_image) }}"
                         alt="user-image">
                @elseif(isset($item->gender) && $item->gender == "Male")
                    <img class="rounded float-left img-fluid" width='35'
                         style="margin-right:10px;"
                         src="{{  asset('assets/media/users/default_male.png') }}"
                         alt="user-image">
                @else
                    <img class="rounded float-left img-fluid" width='35'
                         style="margin-right:10px;"
                         src="{{  asset('assets/media/users/default_female.png') }}"
                         alt="user-image">
                @endif
                    <a href="{{ route('user.evaluation.analytical.report.employee', ['year' => Request::get('year'), 'employee' => $item->id]) }}" target="_blank" class="kt-link">{{ $item->employer_id }} - {{ $item->FullName }}</a>
            </td>
            <td>
                @foreach($item->departmentProcess->unique('department_id') as $val)
                    {{ $val->department->name ?? null }}@if(!$loop->last && $val->department) , @endif
                @endforeach
            </td>
            <td>
                @foreach($item->departmentProcess->unique('department_id') as $val)
                    {{ $val->process->name ?? 'All' }}@if(!$loop->last && $val->process) , @endif
                @endforeach
                |
                @foreach($item->departmentProcess->unique('department_id') as $val)
                    {{ $val->processSegment->name ?? 'All' }}@if(!$loop->last && $val->processSegment) , @endif
                @endforeach
            </td>

            <td>{{ $item->email }}</td>
            <td>{{ $item->contact_number }}</td>
            <td>
                <a href="{{ route('user.evaluation.analytical.report.employee', ['employee' => $item->id]) }}" style="font-weight: bold; font-size: 16px;" title="View Details"
                   target="_blank">
                    <button class="btn btn-sm btn-primary">View</button>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
