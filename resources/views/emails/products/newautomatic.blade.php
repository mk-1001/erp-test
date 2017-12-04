@component('mail::message')

# New Product(s) have been created for a new Order.

A total of {{ $products->count() }} Product(s) were created, as they did not exist when the new Order was submitted.

# New Product Details:
@foreach ($products as $product)
SKU: {{ $product->sku }}, Colour: {{ $product->colour }}

@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
