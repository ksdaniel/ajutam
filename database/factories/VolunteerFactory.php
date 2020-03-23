<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Volunteer::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => '074' . $faker->randomNumber(7),
        'county' => 'CJ',
        'city' => $faker->randomElement(['Cluj-Napoca', 'Turda', 'Dej', 'Gherla', 'Huedin']),
        'address' => $faker->address,
        'neighborhood' => $faker->randomElement(['Bulgaria', 'Centru', 'Gara', 'Gheorgheni', 'Plopilor']),
        'activation_area' => $faker->sentence,
        'involvement_type' => $faker->randomElement(['Promoter', 'Susținător', 'Voluntar']),
        'involvement_direction' => $faker->randomElement(['Call Center', 'Medicamente', 'Alimente']),
        'availability' => $faker->randomElement(['Zilnica', 'Saptamanala']),
        'availability_details' => $faker->sentence,
        'observations' => $faker->sentence,
        'ci' => '',
        'cnp' => '',
        'loc_domiciliu' => $faker->randomElement(['Cluj-Napoca', 'Turda', 'Dej', 'Gherla', 'Huedin']),
        'str_domiciliu' => $faker->streetName,
        'nr_domiciliu' => $faker->numberBetween(1, 100),
        'ap_domiciliu' => $faker->numberBetween(1, 100),
        'ip_acord' => $faker->ipv4,
        'data_acord' => $faker->date('Y-m-d')
    ];
});
