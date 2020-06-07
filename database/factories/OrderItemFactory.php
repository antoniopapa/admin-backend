<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\OrderItem::class, function (Faker $faker) {
    return [
        'product_title' => $faker->text(30),
        'price' => $faker->numberBetween(10, 100),
        'quantity' => $faker->numberBetween(1, 5),
    ];
});
