@extends('layouts.app')

@section('content')
    <h2>Edit Product</h2>

    @include('partials/flash')

    {!! Form::model($product, ['route' => ['products.store']]) !!}
    {!! Form::submit('Edit Product', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection