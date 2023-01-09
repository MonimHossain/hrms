<?php

namespace App\Utils;

interface RecommendationFor{
    const CONFIRMATION = 1;
    const EXTENSION_OF_PROBATION_PERIOD = 2;
    const PROMOTION = 3;
    const INCREMENT = 4;
    const TRANSFER = 5;
    const TERMINATION = 6;
    const DEMOTION = 7;
    const OTHERS = 8;
}
