<?php

namespace App\Services;

use App\Item;
use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Collection;

class OrderSubmissionService
{
    /**
     * Saves an order from the API request.
     *
     * @param array $orderInput
     * @return Collection $orderItems
     */
    public function handle(array $orderInput)
    {
        // Step 1: Create Order
        $order = Order::create([
            'customer_name' => $orderInput['customer'],
            'address'       => $orderInput['address']
        ]);

        // Step 2: Check if Products exist, get them (or else create them)
        $products = collect($orderInput['items'])->map(function (array $productInput) {
            $product = Product::where([
                'sku' => $productInput['sku']
            ])->first();
            if (!$product) {
                $product = Product::create($productInput);
            }
            return $product;
        });

        // Step 3: Check if Items exist
        $allItems = new Collection();
        foreach ($orderInput['items'] as $item) {
            $requiredQuantity = $item['quantity'];
            $suitableProduct = $products->where('sku', $item['sku'])->first();

            // Get existing Item(s) for adding to the Order
            $orderItems = Item::where('product_id', $suitableProduct->id)
                ->availableForNewOrder()
                ->limit($requiredQuantity)
                ->with('product')
                ->get();
            $orderItems->map(function (Item $item) use ($order) {
                $item->order()->associate($order);
                $item->save();
            });

            // Make any required Item(s), and attach them to the order
            $numItemsStillRequired = $requiredQuantity - $orderItems->count();
            // return/break if none

            // Insert new Items
            foreach (range(1, $numItemsStillRequired) as $index) {
                $newItem = Item::make();
                $newItem->order()->associate($order);
                $newItem->product()->associate($suitableProduct);
                $newItem->save();
                $orderItems->add($newItem);
            }

            // Insert into the $allItems Collection
            $orderItems->map(function (Item $item) use ($allItems) {
                $allItems->push($item);
            });
        }

        return $orderItems;
    }

}