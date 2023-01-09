<?php

namespace App\Utils;

interface LeaveStatus {
//    const LEAVE = 3;
//    const PROCESSABLETYPE = 'AppLeave';
//    const PENDING = 0;
//    const APPROVAL = 1;
//    const REJECT = 2;


    const PENDING = 0;
    const APPROVED = 1;
    const REJECT = 2;
    const CANCEL = 3;

    const CASUAL = 1;
    const SICK = 2;
    const EARNED = 3;
    const MATERNITY = 4;
    const PATERNITY = 5;
    const LWP = 6;

    const FIRST_HALF_DAY = 1;
    const SECOND_HALF_DAY = 2;
}


