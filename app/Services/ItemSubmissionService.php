<?php

namespace App\Services;

use App\Item;
use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ItemSubmissionService
 * This class provides a service for finding or creating items.
 * @package App\Services
 */
class ItemSubmissionService
{

    /**
     * @param Order $order
     * @param Collection $products (products attached to the order)
     * @param array $inputItems items to be created (containing sku and quantity). SKU must be unique to each row
     * @return Collection $items
     */
    public function findOrCreateItemsForOrder(Order $order, Collection $products, array $inputItems)
    {
        $productsBySKU = $products->keyBy('sku');

        // Holder for all Items that get assigned to the order.
        $allItems = new Collection();

        // Process each required item's SKU and quantity.
        array_walk($inputItems, function (array $item) use ($order, $productsBySKU, $allItems) {
            $requiredQuantity = $item['quantity'];
            $suitableProduct = $productsBySKU->get($item['sku']);

            // Assign the Order to as many available Items as possible
            $orderItems = $this->assignOrderToExistingItems($order, $suitableProduct, $requiredQuantity);

            // Insert the Items into the $allItems Collection
            $orderItems->map(function (Item $item) use ($allItems) {
                $allItems->push($item);
            });

            // Make any required additional Item(s), and attach them to the order
            $numItemsStillRequired = $requiredQuantity - $orderItems->count();
            if (!$numItemsStillRequired) {
                return;
            }

            // Insert any new Items
            $newItems = $this->createNewItemAndAssignOrder($order, $suitableProduct, $numItemsStillRequired);

            // Insert all new Items into the $allItemsCollection
            $newItems->map(function (Item $item) use ($allItems) {
                $allItems->push($item);
            });
        });

        return $allItems;
    }

    /**
     * Assign an Order to a collection of existing Items.
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @return Collection $items
     */
    public function assignOrderToExistingItems(Order $order, Product $product, $quantity)
    {
        // Get existing available Item(s) for adding to the Order
        $orderItems = Item::where('product_id', $product->id)
            ->availableForNewOrder()
            ->with('product')
            ->limit($quantity)
            ->get();

        $orderItems->map(function (Item $item) use ($order) {
            $item->order()->associate($order);
            $item->save();
        });
        return $orderItems;
    }

    /**
     * Create a new Item for an Order and Product.
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity num to create
     * @return Collection $newItems
     */
    public function createNewItemAndAssignOrder(Order $order, Product $product, $quantity = 1)
    {
        $newItems = new Collection();
        for ($i = 0; $i < $quantity; $i++) {
            $newItem = Item::make();
            $newItem->order()->associate($order);
            $newItem->product()->associate($product);
            $newItem->save();
            $newItems->add($newItem);
        }
        return $newItems;
    }
}