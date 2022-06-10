<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'id' => Str::random(16),
        'title' => $faker->text,
        'description' => $faker->text
    ];
});
