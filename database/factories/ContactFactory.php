<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode
    ];
});
