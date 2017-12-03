@extends('layouts.app')

@section('content')
    <h2>Edit Item</h2>
    <h3>Item Details:</h3>

    @include('partials/flash')

    {!! Form::model($item, ['method' => 'PUT', 'route' => ['items.update', $item->id]]) !!}
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td>Item ID:</td>
                    <td>{{ $item->id }}</td>
                </tr>
                <tr>
                    <td>Physical Status:</td>
                    <td>
                        {!! Form::select(
                                'physical_status',
                                $item->order ? array_combine(\App\Item::PHYSICAL_STATUSES, \App\Item::PHYSICAL_STATUSES)
                                    : array_combine(\App\Item::PHYSICAL_STATUSES_WITHOUT_ORDER,
                                        \App\Item::PHYSICAL_STATUSES_WITHOUT_ORDER)
                            )
                        !!}
                    </td>
                </tr>
                <tr>
                    <td>Status for ordering:</td>
                    <td>{{ $item->status }}</td>
                </tr>
                <tr>
                    <td>Edit Order:</td>
                    <td>
                        @if ($item->order)
                            <a href="{{ route('orders.edit', [$item->order->id]) }}">
                                Order {{ $item->order->id }}
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        {!! Form::submit('Save Updates', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection