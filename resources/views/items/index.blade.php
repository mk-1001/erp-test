@extends('layouts.app')

@section('content')
    <h2>Items</h2>
    <a href="{{ route('items.create') }}" class="btn btn-success">
        <span class="glyphicon glyphicon-plus"></span> Add new Item
    </a>

    <!-- Items table -->
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Physical Status</th>
                <th>Status for Ordering</th>
                <th>Edit Order</th>
                <th>View/Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->physical_status }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        @if ($item->order)
                            <a href="{{ route('orders.edit', [$item->order->id]) }}">
                                Order {{ $item->order->id }}
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info" href="{{ route('items.edit', $item->id) }}">
                            <span class="glyphicon glyphicon-edit"></span> View/Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $items->links() }}
    <p>Total records: {{ $items->total() }}</p>
@endsection