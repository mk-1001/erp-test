@extends('layouts.app')

@section('content')
    <h2>Add Product</h2>

    @include('partials/flash')

    {!! Form::model(new App\Product, ['route' => ['products.store']]) !!}

    {!! Form::submit('Add Product', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@endsection