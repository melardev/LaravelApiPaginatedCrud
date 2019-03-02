<?php


use App\Models\Todo;

$factory->define(Todo::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->words($nb=$faker->numberBetween(2,5), $asText=true),
        'description' => $faker->sentence($nbWords=$faker->numberBetween(10,100)),
        'completed' => $faker->boolean(30) // chance of getting true 30%
    ];
});