<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Beneficiary::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => '074' . $faker->randomNumber(7),
        'address' => $faker->address,
        'neighborhood' => 'Marasti',
        'city' => 'Cluj-Napoca',
        'county' => 'Cluj'
    ];
});
