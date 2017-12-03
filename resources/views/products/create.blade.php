@extends('layouts.app')

@section('content')
    <h2>Add Product</h2>

    @include('partials/flash')

    {!! Form::model(new App\Product, ['route' => ['products.store'], 'class' => 'form-horizontal']) !!}
    @include('products/partials/_form')
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Add Product', ['class' => 'btn btn-success']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection