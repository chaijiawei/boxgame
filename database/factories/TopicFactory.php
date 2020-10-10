<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    $dateTime = $faker->dateTimeThisMonth;

    return [
        'title' => $faker->sentence,
        'content' => $faker->text,
        'slug' => $faker->slug,
        'summary' => $faker->text,
        'created_at' => $faker->dateTimeThisMonth($dateTime),
        'updated_at' => $dateTime,
    ];
});
