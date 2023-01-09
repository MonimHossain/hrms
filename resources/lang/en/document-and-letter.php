<?php

use App\Utils\DocumentAndLetter;


return [
    'status' => [
        DocumentAndLetter::APPROVALSTATUS['NEW'] => 'New',
        DocumentAndLetter::APPROVALSTATUS['PROCESSING'] => 'Processing',
        DocumentAndLetter::APPROVALSTATUS['REJECT'] => 'Rejected',
        DocumentAndLetter::APPROVALSTATUS['DONE'] => 'Done',
    ],

    'access' => [
        DocumentAndLetter::ACCESS['EMPLOYEE'] => 'Employee',
        DocumentAndLetter::ACCESS['ADMIN'] => 'Admin'
    ]


];
