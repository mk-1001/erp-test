@extends('layouts.app')

@section('content')
    <h2>Add Item</h2>

    @include('partials/flash')

    {!! Form::model(new App\Item, ['route' => ['items.store']]) !!}
    <table class="table table-responsive">
        <tbody>
            <tr>
                <td>Physical Status:</td>
                <td>
                    {!! Form::select(
                            'physical_status',
                            array_combine(\App\Item::PHYSICAL_STATUSES, \App\Item::PHYSICAL_STATUSES)
                        )
                    !!}
                </td>
            </tr>
            <tr>
                <td>Product:</td>
                <td>
                    {!! Form::select('product_id', $availableProductDetailsByID) !!}
                </td>
            </tr>
        </tbody>
    </table>
    {!! Form::submit('Add Item', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@endsection