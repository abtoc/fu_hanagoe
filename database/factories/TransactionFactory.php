<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'channel_id' => null,
        'date' => null,
        'view_count' => null,
        'view_count_daily' => null,
        'subscriber_count' => null,
        'subscriber_count_daily' => null
    ];
});
