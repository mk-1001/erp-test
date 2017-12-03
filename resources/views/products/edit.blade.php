@extends('layouts.app')

@section('content')
    <h2>Edit Product</h2>
    <h3>Product ID: {{ $product->id }}</h3>

    @include('partials/flash')

    {!! Form::model($product, [
        'route' => ['products.update', $product->id],
        'method' => 'PUT',
        'class' => 'form-horizontal'
    ]) !!}

    @include('products/partials/_form')
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection