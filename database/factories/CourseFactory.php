<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    $word = 'CUR_' . $faker->word;
    return [
        'name' => $word,
        'text' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'code' => $faker->numerify('CUR ###'),
        'unit' => floor(strlen($word) / 2),
    ];
});
