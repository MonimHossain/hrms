<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Employee;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    static $employerID = 1;
    return [
        "login_id" => rand(1000, 2999),
        //"employer_id" => rand(10000, 19999),
        "employer_id" => $employerID++,
        "blood_group_id" => rand(1, 8),
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "email" => $faker->unique()->email,
        "personal_email" => $faker->unique()->email,
        "gender" => $faker->randomElement(['Male', 'Female']),
        //"center" => $faker->randomElement(['Dhaka', 'Chittagong']),
        //"nearby_location" => $faker->randomElement(['Uttara', 'Mohakhali', 'Mohammadpur', 'Mirpur', 'Motijhil', 'Dhanmondi', 'Moghbazar', 'Firmgate', 'Shahbagh', 'Kakrail', 'Abdullahpur', 'Basundhara', 'Badda', 'Gulshan', 'Shyamoli', 'Gabtoli']),
        "center_id" => 1,
        "nearby_location_id" => rand(1,59),
        "date_of_birth" => $faker->dateTimeThisCentury->format('Y-m-d'),
        "religion" => "Islam",
        "ssc_reg_num" => rand(150000, 250000),
        "father_name" => $faker->name,
        "mother_name" => $faker->name,
        "present_address" => $faker->address,
        "permanent_address" => $faker->address,
        "contact_number" => $faker->phoneNumber ,
        "alt_contact_number" => $faker->phoneNumber ,
        "pool_phone_number" => $faker->phoneNumber ,
        "emergency_contact_person" => $faker->name,
        "emergency_contact_person_number" => $faker->phoneNumber ,
        "relation_with_employee" =>  $faker->randomElement(['Brother', 'Sister', 'Uncle', 'Aunt']),
        "bank_name" =>  $faker->randomElement(['Doutch Bangla Bank', 'Easter Bank Limited', 'Meghna bank', 'City Bank']),
        "bank_branch" =>  $faker->randomElement(['Uttara', 'Mohakhali', 'Mohammadpur', 'Mirpur', 'Motijhil', 'Dhanmondi', 'Moghbazar', 'Firmgate', 'Shahbagh', 'Kakrail', 'Abdullahpur', 'Basundhara', 'Badda', 'Gulshan', 'Shyamoli', 'Gabtoli']),
        "bank_account" =>  $faker->bankAccountNumber,
        "bank_routing" =>  $faker->bankAccountNumber,
        "nid" => rand(),
        "passport" => rand(),
        "marital_status" =>  $faker->randomElement(['Married', 'Unmarried']),
        "spouse_name" => Null,
        "spouse_dob" => Null,
        "child1_name" => Null,
        "child1_dob" => Null,
        "child2_name" => Null,
        "child2_dob" => Null,
        "child3_name" => Null,
        "child3_dob" => Null,
    ];
});
