<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exercice;
use Faker\Generator as Faker;

$factory->define(Exercice::class, function (Faker $faker) {
    return [
        'principe' => $faker->text($maxNbChars = 30),
        'time' => '20min',
        'nbJoueurs' => '10',
        'image' => '8lDNNcSBuo.JPG',
        'description' => $faker->text($maxNbChars = 200),
        'typesexcercice_id' => 1,
    ];
});
