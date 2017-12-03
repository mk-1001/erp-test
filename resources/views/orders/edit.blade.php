@extends('layouts.app')

@section('content')
    <h2>Edit Order</h2>

    <h3>Order Details:</h3>
    <table class="table table-responsive">
        <tbody>
            <tr>
                <td>Order ID:</td>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td>{{ $order->customer_name }}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <td>Order Date:</td>
                <td>{{ $order->order_date }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Items:</h3>
    @if ($order->items->count())
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Item Status</th>
                    <th>Physical Status</th>
                    <th>Product SKU</th>
                    <th>Product Colour</th>
                    <th>Remove From Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->physical_status }}</td>
                        <td>{{ $item->product->sku }}</td>
                        <td>{{ $item->product->colour }}</td>
                        <td>
                            {!! Form::open(['route' => [
                                'orders.items.remove',
                                $order->id,
                                $item->id
                            ], 'method' => 'delete']) !!}

                            {{ Form::button('<span class="glyphicon glyphicon-remove"></span> Remove', [
                                'class' => 'btn btn-danger',
                                'onclick' => 'return confirm("Are you sure?");',
                                'type' => 'submit']) }}

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>There are no items in this order.</p>
    @endif

@endsection