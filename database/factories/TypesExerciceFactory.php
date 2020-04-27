<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TypesExercice;
use Faker\Generator as Faker;

$factory->define(TypesExercice::class, function (Faker $faker) {
    return [
        'nom' => $faker->text($maxNbChars = 10),
    ];
});
