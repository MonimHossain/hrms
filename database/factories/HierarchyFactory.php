<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Hierarchy;
$factory->define(Hierarchy::class, function (Faker $faker) {
    static $i = 1;
    return [
        'parent_id' => $i++,
        'employee_id' => rand(1,10),
    ];
});
