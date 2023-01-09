<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Training;

$factory->define(Training::class, function (Faker $faker) {
    return [
        "employee_id" => rand(1,10),
        "training_title" => "Full Stack Web Developer",
        "Country" => "Bangladesh",
        "topics_covered" => "JavaScript, PHP, Laravel",
        "training_year" => "2016",
        "institute" => "UIU",
        "duration" => "12 Months",
        "location" => "Dhaka",
    ];
});
