@extends('layouts.app')

@section('content')
    <h2>Products</h2>

    @include('partials/flash')

    <a href="{{ route('products.create') }}" class="btn btn-success">
        <span class="glyphicon glyphicon-plus"></span> Add new Product
    </a>

    <!-- Products table -->
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Colour</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->colour }}</td>
                    <td>
                        <a href="{{ route('products.edit', [$product->id]) }}" class="btn btn-info">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $products->links() }}
    <p>Total records: {{ $products->total() }}</p>
@endsection