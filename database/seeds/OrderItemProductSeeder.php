<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class OrderItemProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 1. Creates 50 products.
     * 2. Creates random items.
     * 3. Creates 5 orders, with 1-3 random items.
     *
     * @param Faker $faker
     * @return void
     */
    public function run(Faker $faker)
    {
        factory(App\Product::class, 50)->create()->each(function (App\Product $product) use ($faker) {
            // 30% of products are assigned to items
            if (!$faker->boolean($chanceOfGettingTrue = 30)) {
                return;
            }

            // A product is assigned to up to 3 items (using the product's id as the item's product_id)
            $product->items()->saveMany(factory(App\Item::class, rand(1, 3))->make([
                'product_id' => $product->id
            ]));
        });

        factory(App\Order::class, 5)->create()->each(function (App\Order $order) {
            // Get items that are not assigned, or no order_id
            // Add them to the order, $item->saveOrder(Order) also sets status
            $items = App\Item::availableForNewOrder()->inRandomOrder()->limit(rand(1, 3))->get();
            $order->items()->saveMany($items);
        });
    }
}
