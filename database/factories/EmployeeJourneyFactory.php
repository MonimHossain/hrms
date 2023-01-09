<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\EmployeeJourney;
use App\EmployeeJourneyArchive;

$factory->define(EmployeeJourney::class, function (Faker $faker) {
    static $i = 0;
    return [
        "employee_id" => ++$i,
        //"process_id" => rand(1,3),
        //"process_segment_id" => rand(1,3),
        "designation_id" => rand(1,4),
        "job_role_id" => rand(1,3),
        //"department_id" => rand(1,4),
        "employment_type_id" => rand(1,3),
        "employee_status_id" => rand(1,3),
        //"sup1" => rand(1,3),
        //"sup2" => rand(1,3),
        //"hod" => rand(1,3),
        "doj" => $faker->dateTime(),
        "contract_start_date" => $faker->dateTime(),
        "contract_end_date" => $faker->dateTime(),
        "probation_start_date" => $faker->dateTime(),
        "probation_period" => rand(1,6),
        "process_doj" => $faker->dateTime(),
    ];
});
$factory->define(EmployeeJourneyArchive::class, function (Faker $faker) {
    static $i = 0;
    return [
        "employee_id" => ++$i,
        //"process_id" => rand(1,3),
        //"process_segment_id" => rand(1,3),
        "designation_id" => rand(1,4),
        "job_role_id" => rand(1,3),
        //"department_id" => rand(1,4),
        "employment_type_id" => rand(1,3),
        "employee_status_id" => rand(1,3),
        //"sup1" => rand(1,3),
        //"sup2" => rand(1,3),
        //"hod" => rand(1,3),
        "doj" => $faker->dateTime(),
        "contract_start_date" => $faker->dateTime(),
        "contract_end_date" => $faker->dateTime(),
        "probation_start_date" => $faker->dateTime(),
        "probation_period" => rand(1,6),
        "process_doj" => $faker->dateTime(),
    ];
});
