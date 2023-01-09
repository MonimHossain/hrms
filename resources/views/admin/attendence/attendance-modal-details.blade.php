<div class="row">
    <div class="col-md-12">
        <div class="card punch-status">
            <div class="card-body">
                <h5 class="card-title">Timesheet <small class="text-muted">{{ \Carbon\Carbon::create($attendance->date)->toFormattedDateString()}}</small></h5>
                <div class="punch-det">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Roster start</h6>
                            <p>{{ ($attendance->roster_start) ? \Carbon\Carbon::create($attendance->roster_start)->toDayDateTimeString() : '-'}}</p>
                        </div>
                        <div class="col-sm-6">
                            <h6>Roster end</h6>
                        <p>{{ ($attendance->roster_end) ? \Carbon\Carbon::create($attendance->roster_end)->toDayDateTimeString() : '-'}}</p>
                        </div>
                    </div>
                </div>
                <div class="punch-info">
                    <div class="punch-hours">
                        <span>{{ $workHours. ' hrs' }}</span>
                    </div>
                </div>
                <div class="punch-det">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6>Punch In at</h6>
                            <p>{{ ($attendance->punch_in) ? \Carbon\Carbon::create($attendance->punch_in)->toDayDateTimeString() : '-'}}</p>
                            <?php 
                                $map = '';
                                if($attendance->first_checkin){
                                    echo "<p>";
                                    $map = json_decode($attendance->first_checkin);
                                    echo "<strong>Street:</strong> " . $map->street . "<br>";
                                    echo "<strong>Geo Location:</strong> " . $map->latLng->lat . ", ". $map->latLng->lng ."<br>";
                                    echo "<img src='" . $map->mapUrl . "'><br>";
                                    echo "</p>";
                                } else {
                                    echo "Map location missing";
                                }    
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <h6>Punch Out at</h6>
                            <p>{{ ($attendance->punch_in != $attendance->punch_out) ? \Carbon\Carbon::create($attendance->punch_out)->toDayDateTimeString() : '-'}}</p>
                            <?php 
                                $map = '';
                                if($attendance->last_checkin){
                                    echo "<p>";
                                    $map = json_decode($attendance->last_checkin);
                                    echo "<strong>Street:</strong> " . $map->street . "<br>";
                                    echo "<strong>Geo Location:</strong> " . $map->latLng->lat . ", ". $map->latLng->lng ."<br>";
                                    echo "<img src='" . $map->mapUrl . "'><br>";
                                    echo "</p>";
                                } else {
                                    echo "Map location missing";
                                }     
                            ?>
                        </div>
                    </div>




                </div>
                @if(!is_null($attendance->remarks))
                <p class="text-purple-dark"><b>Remarks : </b>{{ $attendance->remarks }}</p>
                @endif
                {{-- <div class="statistics">
                    <div class="row">
                        <div class="col-md-12 col-12 text-center">
                            <div class="stats-box">
                                <p>Overtime</p>
                                <h6>{{ $overTime }} </h6>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
