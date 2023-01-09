<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\NearbyLocation;

$factory->define(NearbyLocation::class, function (Faker $faker) {
    return [
        "center" => $faker->randomElement(['Dhaka', 'Chittagong']),
        "nearby" => $faker->randomElement(['Uttara', 'Mohakhali', 'Mohammadpur', 'Mirpur', 'Motijhil', 'Dhanmondi', 'Moghbazar', 'Firmgate', 'Shahbagh', 'Kakrail', 'Abdullahpur', 'Basundhara', 'Badda', 'Gulshan', 'Shyamoli', 'Gabtoli']),
    ];
});
