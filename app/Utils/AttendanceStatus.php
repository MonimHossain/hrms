<?php

namespace App\Utils;

interface AttendanceStatus {
//    const ABSENT = 0;
//    const PRESENT = 1;
//    const WITHOUT_ROSTER = 2;
//    const HOLIDAY = 3;
//    const DAYOFF = 4;
//    const ADJUSTED_DAY_OFF = 5;
//    const LATE = 6;
//
//
//    const CASUAL_LEAVE = 7;
//    const SICK_LEAVE = 8;
//    const EARNED_LEAVE = 9;
//    const MATERNITY_LEAVE = 10;
//    const PATERNITY_LEAVE = 11;
//    const LEAVE_WITHOUT_PAY = 12;
//
//    const ANNUAL_LEAVE = 13;
//    const SICK_LEAVE_HALF = 14;
//    const CASUAL_LEAVE_HALF = 15;
//    const ANNUAL_LEAVE_HALF = 16;
//    const OUT_OF_OFFICE = 17;




    const CASUAL_LEAVE = 1;
    const SICK_LEAVE = 2;
    const EARNED_LEAVE = 3;
    const MATERNITY_LEAVE = 4;
    const PATERNITY_LEAVE = 5;
    const LEAVE_WITHOUT_PAY = 6;

    const ABSENT = 7;
    const PRESENT = 8;
    const WITHOUT_ROSTER = 9;
    const HOLIDAY = 10;
    const DAYOFF = 11;
    const ADJUSTED_DAY_OFF = 12;
    const LATE = 13;
    const EARLY_LEAVE = 14;

    const ANNUAL_LEAVE = 15;
    const SICK_LEAVE_HALF = 16;
    const CASUAL_LEAVE_HALF = 17;
    const ANNUAL_LEAVE_HALF = 18;
    const OUT_OF_OFFICE = 19;

    const HALF_DAY = 20;


}
