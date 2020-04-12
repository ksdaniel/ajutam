<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Solicitation::class, function (Faker $faker) {
    return [
        'beneficiary_id' => factory(App\Beneficiary::class),
        'categories' => $faker->randomElement(['Alimente', 'Medicamente']),
        'emergency' => '',
        'status' => 'necesita_voluntar',
        'additional_responses' => json_encode([
            'question' => $faker->sentence,
            'answer' => $faker->sentence
        ]),
        'observations' => $faker->sentence,
        'payment_type' => $faker->randomElement(['card', 'cash']),
        'payment_status' => 'neachitat',
        'payment_value' => '9.90',
        'finish_date' => $faker->dateTime('now'),
    ];
});
