<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'sku'    => 'SKU' . $faker->unique()->numberBetween(1000000, 9999999),
        'colour' => $faker->colorName
    ];
});
