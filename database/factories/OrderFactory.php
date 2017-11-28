<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name(),
        'address'       => $faker->address,
        'status'        => App\Order::STATUS_IN_PROGRESS,
        'order_date'    => $faker->dateTimeThisMonth
    ];
});
