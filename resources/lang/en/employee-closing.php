<?php
use App\Utils\EmployeeClosing;

return [

    'teamLeadSupervisorStatus' => [
        EmployeeClosing::ApprovedFrom['teamLeadSupervisor']['new'] => 'New',
        EmployeeClosing::ApprovedFrom['teamLeadSupervisor']['supervisor_approved'] => 'Supper Visor',
        EmployeeClosing::ApprovedFrom['teamLeadSupervisor']['team_lead_approved'] => 'Team Lead',
        EmployeeClosing::ApprovedFrom['teamLeadSupervisor']['hr_approved'] => 'Hr',
        EmployeeClosing::ApprovedFrom['teamLeadSupervisor']['rejected'] => 'Rejected',
    ],

    'finalStatus' => [
        EmployeeClosing::ApprovedFrom['final']['true'] => 'True',
        EmployeeClosing::ApprovedFrom['final']['false'] => 'False',
    ],

    'separationReason' => [
        EmployeeClosing::SeparationReason['unauthorizedAbsence'] => 'Unauthorized Absence',
        EmployeeClosing::SeparationReason['terminationForZTP'] => 'Termination For ZTP',
        EmployeeClosing::SeparationReason['terminationForUnethicalPractice'] => 'Termination ForUnethical Practice',
        EmployeeClosing::SeparationReason['studyPurposeResignation'] => 'Study Purpose Resignation',
        EmployeeClosing::SeparationReason['familyIssueResignation'] => 'Family Issue Resignation',
        EmployeeClosing::SeparationReason['betterOpportunityResignation'] => 'Better Opportunity Resignation',
        EmployeeClosing::SeparationReason['healthIssueResignation'] => 'Health Issue Resignation',
        EmployeeClosing::SeparationReason['personalReasonResignation'] => 'Personal Reason Resignation',
        EmployeeClosing::SeparationReason['Others'] => 'Others',
    ],

    'payment' => [
        EmployeeClosing::Payment['due'] => 'Due',
        EmployeeClosing::Payment['payed'] => 'Payed'
    ]

];
