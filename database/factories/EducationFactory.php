<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Education;

$factory->define(Education::class, function (Faker $faker) {
    return [
        "employee_id" => rand(1,10),
        "level_of_education_id" => rand(1, 3),
        "institute_id" => rand(1, 3),
        "exam_degree_title" => 'Secondary School Certificate',
        "major" => 'Science',
        "result" => '5',
        "passing_year" => '2009',
    ];
});
