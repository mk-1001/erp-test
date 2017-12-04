<?php

namespace App\Services;

use App\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderSubmissionService
 * @package App\Services
 */
class OrderSubmissionService
{

    /**
     * @var ProductSubmissionService
     */
    protected $productSubmissionService;

    /**
     * @var ItemSubmissionService
     */
    protected $itemSubmissionService;

    /**
     * OrderSubmissionService constructor.
     * @param ProductSubmissionService $productService
     * @param ItemSubmissionService $itemService
     */
    function __construct(ProductSubmissionService $productService, ItemSubmissionService $itemService)
    {
        $this->productSubmissionService = $productService;
        $this->itemSubmissionService = $itemService;
    }

    /**
     * Saves an order from the API request.
     *
     * @param array $orderInput (validated with a unique SKU in each item)
     * @return Collection $orderItems
     */
    public function handle(array $orderInput)
    {
        // Step 1: Create Order
        $order = Order::create([
            'customer_name' => $orderInput['customer'],
            'address'       => $orderInput['address'],
            'total'         => $orderInput['total']
        ]);

        // Step 2: Determine the required order quantity for each SKU, noting that a user might request 2 items with
        // the same SKU - in which case the quantities must be summed.
        $orderInput['items'] = $this->mergeDuplicateSKUQuantities($orderInput['items']);

        // Step 3: Check if Products exist, get them (or else create them)
        // Note: it is already validated that each "item" in the order will have a unique SKU
        $products = $this->productSubmissionService->findOrCreateProducts($orderInput['items']);

        // Step 4: Assign the Products to Items (by making Items, or using existing available Items)
        $orderItems = $this->itemSubmissionService->findOrCreateItemsForOrder($order, $products, $orderInput['items']);

        return $orderItems;
    }

    /**
     * Merge any items with the same SKU, by summing the quantities.
     * e.g. [
     *   { sku: 'SKU1', quantity: 3 },
     *   { sku: 'SKU1', quantity: 3 },
     * ]
     * will become:
     * [{ sku: 'SKU1', quantity: 6 }]
     * The colour attribute will be retained, if present.
     *
     * @param array $orderItemsInput
     * @return array transformed orderInput
     */
    private function mergeDuplicateSKUQuantities(array $orderItemsInput)
    {
        $numUniqueSKUs = array_unique(array_column($orderItemsInput, 'sku'));

        // No merging required if no duplicate SKUs
        if ($numUniqueSKUs == count($orderItemsInput)) {
            return $orderItemsInput;
        }

        $mergedOrderItems = [];
        array_walk($orderItemsInput, function (array $item) use (&$mergedOrderItems) {
            // If the Item SKU occurs the first time:
            if (!isset($mergedOrderItems[$item['sku']])) {
                $mergedOrderItems[$item['sku']] = $item;
                return;
            }

            // If the Item SKU is already in use:
            // Add the quantity
            $mergedOrderItems[$item['sku']]['quantity'] += $item['quantity'];

            // Set the colour, if necessary
            if (!isset($mergedOrderItems[$item['sku']]['colour']) && isset($item['colour'])) {
                $mergedOrderItems[$item['sku']]['colour'] = $item['colour'];
            }
        });

        // Return 0-index based array
        return array_values($mergedOrderItems);
    }

}