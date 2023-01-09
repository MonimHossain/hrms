<form class="kt-form center-division-form" action="{{ route('previous.attendance.correction.update', ['id'=>$id]) }}" method="post">
    @csrf
    <input name="_method" type="hidden" value="PUT">
    <div class="row">
        <div class="col-xl-6">
            <div class="form-group">
                <label>Check In</label>
                <div class="input-group date">
                    <input class="form-control" type="text" id="start-date" name="start_date" value="">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Check Out</label>
                <div class="input-group date">
                    <input class="form-control" type="text" id="end-date" name="end_date" value="">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar-check-o"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                <!-- <select name="leave_type" id="leave_type" class="form-control" required>
                        <option value="">Select a Cow</option>
                        @foreach($leaveBalance as $row)
                            @if($row->remain > 0 || $row->leaveType->id == \App\Utils\LeaveStatus::LWP)
                                <option value="{{ json_encode(['type_id'=>$row->leaveType->id, 'balance_id'=>$row->id]) }}">{{ $row->leaveType->short_code }} - {{ $row->leaveType->leave_type }}</option>
                            @endif
                        @endforeach
                                <option value="{{ json_encode(['type_id'=>'-1', 'balance_id'=>'0']) }}">Consideration</option>
                    </select> -->
                <label>Attendance Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="">Select a Status</option>
                    <option value="{{\App\Utils\AttendanceStatus::PRESENT}}">Present</option>
                    <option value="{{\App\Utils\AttendanceStatus::ABSENT}}">Absent</option>
                    <option value="{{\App\Utils\AttendanceStatus::LATE}}">Late</option>
                    <option value="{{\App\Utils\AttendanceStatus::EARLY_LEAVE}}">Early Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::ADJUSTED_DAY_OFF}}">Adjust a Day Off</option>
                    <option value="{{\App\Utils\AttendanceStatus::DAYOFF}}">Day Off</option>
                    <option value="{{\App\Utils\AttendanceStatus::WITHOUT_ROSTER}}">Without Roaster</option>
                    <option value="{{\App\Utils\AttendanceStatus::HOLIDAY}}">Holiday</option>
                    <option value="{{\App\Utils\AttendanceStatus::CASUAL_LEAVE}}">Casual Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::SICK_LEAVE}}">Sick Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::EARNED_LEAVE}}">Earned Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::LEAVE_WITHOUT_PAY}}">Leave without pay</option>
                    <option value="{{\App\Utils\AttendanceStatus::MATERNITY_LEAVE}}">Maternity Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::PATERNITY_LEAVE}}">Paternity Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::ANNUAL_LEAVE}}">Annual Leave</option>
                    <option value="{{\App\Utils\AttendanceStatus::SICK_LEAVE_HALF}}">Sick Leave Half</option>
                    <option value="{{\App\Utils\AttendanceStatus::CASUAL_LEAVE_HALF}}">Casual Leave Half</option>
                    <option value="{{\App\Utils\AttendanceStatus::ANNUAL_LEAVE_HALF}}">Annual Leave Half</option>
                    <option value="{{\App\Utils\AttendanceStatus::OUT_OF_OFFICE}}">Out of Office</option>
                    <option value="{{\App\Utils\AttendanceStatus::HALF_DAY}}">Half Day</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="form-group" id="remarks">
                <textarea name="remarks" id="" class="form-control" cols="30" rows="2"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('#remarks').hide();
    $('textarea').prop('required', true);

    $(document).on('change', '#leave_type', function() {
        let leaveType = JSON.parse($(this).val());
        $('#remarks').prop('required', true);

        if (leaveType.type_id == '-1') {
            $('#remarks').show();
            $('textarea').prop('required', true);
        } else {
            $('#remarks').hide();
            $('textarea').prop('required', false);
        }
    });

    $('#start-date').datepicker({
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        },
        format: 'yyyy-mm-dd'
    });
    $('#end-date').datepicker({
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        },
        format: 'yyyy-mm-dd',
        // viewMode: "years",
        // minViewMode: "years"
    });
</script>