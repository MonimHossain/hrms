<?php

use App\Utils\AttendanceChangeStatus;
use App\Utils\AttendanceStatus;

return [
    'status' => [
        AttendanceStatus::ABSENT => "A",
        AttendanceStatus::PRESENT => "P",
        AttendanceStatus::HALF_DAY => "HD",
        AttendanceStatus::HOLIDAY => "H",
        AttendanceStatus::DAYOFF => "D",
        AttendanceStatus::ADJUSTED_DAY_OFF => "ADO",
        AttendanceStatus::LATE => "LT",
        AttendanceStatus::EARLY_LEAVE => "ELV",
        AttendanceStatus::CASUAL_LEAVE => "CL",
        AttendanceStatus::SICK_LEAVE => "SL",
        AttendanceStatus::EARNED_LEAVE => "EL",
        AttendanceStatus::MATERNITY_LEAVE => "ML",
        AttendanceStatus::PATERNITY_LEAVE => "PL",
        AttendanceStatus::LEAVE_WITHOUT_PAY => "LWP",


        AttendanceStatus::ANNUAL_LEAVE => "AL",
        AttendanceStatus::SICK_LEAVE_HALF => "HSL",
        AttendanceStatus::CASUAL_LEAVE_HALF => "HCL",
        AttendanceStatus::ANNUAL_LEAVE_HALF => "HAL",
        AttendanceStatus::OUT_OF_OFFICE => "OF",
        AttendanceStatus::WITHOUT_ROSTER => "WR",
    ],

    'change_request' => [
        AttendanceChangeStatus::PENDING => 'Pending',
        AttendanceChangeStatus::APPROVED => 'Approved',
        AttendanceChangeStatus::REJECTED => 'Rejected',
    ]
];
