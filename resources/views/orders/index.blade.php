@extends('layouts.app')

@section('content')
    <h2>Orders</h2>

    <!-- Orders table -->
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Status</th>
                <th>Date</th>
                <th>View/Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('orders.edit', $order->id) }}">
                            <span class="glyphicon glyphicon-edit"></span> View/Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $orders->links() }}
    <p>Total records: {{ $orders->total() }}</p>
@endsection