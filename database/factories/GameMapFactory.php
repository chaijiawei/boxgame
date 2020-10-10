<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameMap;
use Faker\Generator as Faker;

$factory->define(GameMap::class, function (Faker $faker) {
    $data = json_encode(['map' => 'test']);
    $dateTime = $faker->dateTimeThisMonth();
    return [
        'level' => $faker->unique()->numberBetween(1, 100),
        'map_data' => $data,
        'created_at' => $dateTime,
        'updated_at' => $dateTime,
    ];
});
