<?php

use App\Utils\RecommendationFor;

return [
    'status' => [
        RecommendationFor::CONFIRMATION => 'Confirmation',
        RecommendationFor::EXTENSION_OF_PROBATION_PERIOD => 'Extension of probation period',
        RecommendationFor::PROMOTION => 'Promotion',
        RecommendationFor::INCREMENT => 'Increment',
        RecommendationFor::TRANSFER => 'Transfer',
        RecommendationFor::TERMINATION => 'Termination',
        RecommendationFor::DEMOTION => 'Demotion',
        RecommendationFor::OTHERS => 'Others',
    ]
];
