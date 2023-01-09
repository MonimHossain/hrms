<?php

namespace App\Utils;

interface EmployeeClosing {

    const ApprovedFrom = [
        'status' => [
             'hr' => 1,
             'admin' => 2,
             'account' => 3,
             'it' => 4
        ],

        'approval' => [
            'approved' => 1,
            'rejected' => 2,
            'pending' => 0
        ],

        'teamLeadSupervisor' => [
            'new' => 0,
            'supervisor_approved' => 1,
            'team_lead_approved' => 2,
            'hr_approved' => 3,
            'rejected' => 4
        ],

        'final' => [
            'false' => 0,
            'true' => 1
        ]
    ];

    const CheckList = [
        'whereYouWork' => [
            '1. Charge Hand Over:',
            '2. Files &/or Documents:',
            '3. Others:',
            '4. Remarks/Comments:'
        ],

        'accounts'=> [
            '1. Advance Against Salary:',
            '2. Advance Against TA/DA:',
            '3. Other Financials:',
            '4. Remarks/Comments:'
        ],

        'it'=> [
            '1. PC / Laptop:',
            '2. Pendrive/ Hardware:',
            '3. Passward :',
            '4. Remarks/Comments:'
        ],

        'admin'=> [
            '1. Office Gears:',
            '2. Corporate SIM:',
            '3. ID Blocking/Deleting:',
            '4. Other Office Gears:',
            '5. Remarks/Comments:'
        ],

        'hr'=> [
            '1. Clearance from All Department:',
            '2. Proper Notice Period Served?:',
            '3. Any fianancial adjustment:',
            '4. Remarks/Comments:'
        ]
    ];

    const SeparationReason = [
        'unauthorizedAbsence'=>'0',
        'terminationForZTP'=>'1',
        'terminationForUnethicalPractice'=>'2',
        'studyPurposeResignation'=>'3',
        'familyIssueResignation'=>'4',
        'betterOpportunityResignation'=>'5',
        'healthIssueResignation'=>'6',
        'personalReasonResignation'=>'7',
        'Others'=>'8',
    ];

    const ClearanceMode = [
        'Need Clearance',
        'No Need Clearance'
    ];

    const Payment = [
        'due'=>'0',
        'payed'=>'1'
    ];
}




