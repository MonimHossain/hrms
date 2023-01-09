<?php

use App\Utils\Payroll;

return [
    'adjustment' => [
        'status' => [
            Payroll::ADJUSTMENT['status']['Generated'] => 'Generated',
            Payroll::ADJUSTMENT['status']['Due'] => 'Due',
            Payroll::ADJUSTMENT['status']['Payed'] => 'Payed',
            Payroll::ADJUSTMENT['status']['Hold'] => 'Hold',
        ]
    ],



    'loan' => [
        'status' => [
            Payroll::LOAN['SHOWSTATUS']['REQUEST'] => 'Requested',
            Payroll::LOAN['SHOWSTATUS']['APPROVED'] => 'Approved',
            Payroll::LOAN['SHOWSTATUS']['REJECTED'] => 'Rejected',
        ],
        'process' => [
            Payroll::LOAN['SHOWPROCESS']['DUE'] => 'Due',
            Payroll::LOAN['SHOWPROCESS']['PAID'] => 'Paid'
        ]
    ],

    'salaryhold' => [
        'status' => [
            Payroll::SALARYHOLD['status']['Hold'] => 'Hold',
            Payroll::SALARYHOLD['status']['Release'] => 'Release'
        ]
    ],

    'bonus' => [
        'status' => [
            Payroll::BONUS['status']['Active'] => 'Active',
            Payroll::BONUS['status']['Inactive'] => 'Inactive'
        ],
        'type' => [
            Payroll::BONUS['type']['Percentage'] => 'Percentage',
            Payroll::BONUS['type']['Fixed'] => 'Fixed'
        ]
    ],

    'pf' => [
        'status' => [
            Payroll::PF['Generated'] => 'Generated',
            Payroll::PF['Due'] => 'Due',
            Payroll::PF['Payed'] => 'Payed',
            Payroll::PF['Hold'] => 'Hold',
        ]
    ],

    'tax' => [
        'status' => [
            Payroll::TAX['Generated'] => 'Generated',
            Payroll::TAX['Due'] => 'Due',
            Payroll::TAX['Payed'] => 'Payed',
            Payroll::TAX['Hold'] => 'Hold',
        ]
    ]
];
