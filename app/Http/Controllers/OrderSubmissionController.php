<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewOrderRequest;
use App\Order;
use Carbon\Carbon;

class OrderSubmissionController extends Controller
{
    /**
     * Handles a new order post request.
     * @TODO assumption $request is validated already
     * @TODO move logic out of controller
     */
    public function newOrder(NewOrderRequest $request)
    {
        // 1. Creates order
        $data = json_decode($request->input('data'), true);
        $order = new Order();
        $order->customer_name = $data['order']['customer'];
        $order->address = $data['order']['address'];
        $order->order_date = Carbon::now();
        $order->save();

        //@TODO:

        // 2. Products
        $orderItems = $data['order']['items'];
        // ($orderItems contains 'sku' to uniquely identify products)

        // 2a. Find if the product exists

        // 2.a.i If the product does not exist, create a new product, then a new item, then an order

        // 2a.ii. If the item and product both exist, create the order

        // 2a.iii. If the product exists, but no available item exists, create a new item, then an order

    }
}
