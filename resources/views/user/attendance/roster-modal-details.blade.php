<div class="row">
    <div class="col-sm-12">

        <div class="card punch-status">
            <div class="card-body">
                <h5 class="card-title">Timesheet <small class="text-muted">{{ \Carbon\Carbon::create($roster->date)->toFormattedDateString()}}</small></h5>
                <div class="punch-det">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Roster start</h6>
                            <p>{{ ($roster->roster_start) ? \Carbon\Carbon::create($roster->roster_start)->toDayDateTimeString() : '-'}}</p>
                        </div>
                        <div class="col-sm-6">
                            <h6>Roster end</h6>
                        <p>{{ ($roster->roster_end) ? \Carbon\Carbon::create($roster->roster_end)->toDayDateTimeString() : '-'}}</p>
                        </div>
                    </div>
                </div>
                @if(isset($change_request) && $change_request == 1)
                <a href="javascript:void(0);" data-date="{{ $roster->date }}" class="btn btn-warning btn-block change_request"><i class="la la-edit"></i> Change Request</a>
                @endif
            </div>
        </div>
    </div>
</div>
