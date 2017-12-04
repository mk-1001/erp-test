<?php

namespace App\Http\Controllers;

use App\Order;
use App\Item;
use Illuminate\Support\Facades\Redirect;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(15);
        return view('orders/index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders/edit', compact('order'));
    }

    /**
     * Remove an item from an order.
     *
     * @param Order $order
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function removeItem(Order $order, Item $item)
    {
        $order->removeItem($item->id);
        return Redirect::route('orders.edit', [$order->id])->with('message', 'Item removed from order.');
    }
}
