<div class="form-group">
    {!! Form::label('sku', 'SKU:', ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::text('sku', $product->sku ?? '', ['class' => 'form-control', 'maxlength' => 20]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('colour', 'Colour:', ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::text('colour', $product->colour ?? '', ['class' => 'form-control', 'maxlength' => 20]) !!}
    </div>
</div>