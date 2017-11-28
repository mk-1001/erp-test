<?php

use Faker\Generator as Faker;

$factory->define(App\Item::class, function (Faker $faker) {
    $physicalStatusOptions = [
        App\Item::PHYSICAL_STATUS_IN_WAREHOUSE,
        App\Item::PHYSICAL_STATUS_TO_ORDER
    ];
    // product_id to be set externally
    return [
        'physical_status' => $faker->randomElement($physicalStatusOptions)
    ];
});
