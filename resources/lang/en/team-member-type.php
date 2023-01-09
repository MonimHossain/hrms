<?php

use App\Utils\TeamMemberType;

return [
    'member_type' => [
        TeamMemberType::TEAMLEADER => 'Team Leader',
        TeamMemberType::SUPERVISOR => 'Supervisor',
        TeamMemberType::MEMBER => 'Member',
        TeamMemberType::ASSTMEMBER => 'Assoc. Member'
    ]
];
