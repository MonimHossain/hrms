<?php

namespace App\Utils;

interface Payroll {

    const ADJUSTMENT = [
        'type' => ['deduction'=>'Deduction', 'addition'=>'Addition'],
        'status' => [
              'Generated' => 0,
              'Due' => 1,
              'Payed' => 2,
              'Hold' => 3,
        ]
    ];

    const LOAN = [
         'SHOWSTATUS' => ['REQUEST'=>1, 'APPROVED'=>2, 'REJECTED'=>3],
         'SHOWPROCESS' => ['DUE'=>1, 'PAID'=>2]
    ];

    const SALARYHOLD = [
        'status' => [
            'Hold' => 1,
            'Release' => 2
        ]
    ];

    const BONUS = [
        'status' => [
            'Active' => 1,
            'Inactive' => 2
        ],
        'type' => [
            'Percentage' => 1,
            'Fixed' => 2
        ]
    ];

    const STATEMENT = [
        'status' => [
            'Active' => 1,
            'Inactive' => 2
        ]
    ];

    const SALARYSTATUS = [
        'active' => 1,
        'inactive' => 0
    ];

    const PF = [
      'Generated'=> 0,
      'Due'=> 1,
      'Payed'=> 2,
      'Hold' => 3
    ];

    const TAX = [
        'Generated'=> 0,
        'Due'=> 1,
        'Payed'=> 2,
        'Hold' => 3
    ];


    const SALARYDETAILS = [
        'PF' => 1,
        'TAX' => 2,
        'ADJUSTMENT' => 3,
        'LWP' => 4,
        'LOAN' => 5
    ];

    const SALARYHOLDREASON = [
        'Unauthorized Absent' => 1,
        'On Notice Period' => 2,
        'Policy Violation' => 3
    ];



}




