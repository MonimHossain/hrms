<?php
use App\Utils\LeaveStatus;

return [

    'status' => [
        LeaveStatus::PENDING => 'Pending',
        LeaveStatus::APPROVED => 'Approved',
        LeaveStatus::REJECT => 'Rejected',
        LeaveStatus::CANCEL => 'Cancelled'
    ],

//    'progress' => [
//        LeaveStatus::PENDING => 'dissabled',
//        LeaveStatus::APPROVED => 'complete'
//    ],

    'leaveType' => [
        LeaveStatus::SICK => 'Sick Leave',
        // LeaveStatus::EARNED => 'Earned Leave',
        LeaveStatus::EARNED => 'Annual Leave',
        LeaveStatus::CASUAL => 'Casual Leave',
        LeaveStatus::MATERNITY => 'Maternity Leave',
        LeaveStatus::PATERNITY => 'Paternity Leave',
        LeaveStatus::LWP => 'Leave Without Pay'
    ],

    'leaveCode' => [
        LeaveStatus::SICK => 'SL',
        LeaveStatus::EARNED => 'EL',
        LeaveStatus::CASUAL => 'CL',
        LeaveStatus::MATERNITY => 'ML',
        LeaveStatus::PATERNITY => 'PL',
        LeaveStatus::LWP => 'LWP'
    ]

];
