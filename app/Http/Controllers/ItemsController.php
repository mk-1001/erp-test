<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Item;
use App\Product;
use Illuminate\Support\Facades\Redirect;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(15);
        return view('items/index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $availableProductsByID = Product::orderBy('sku')->get()->keyBy('id');
        $availableProductDetailsByID = $availableProductsByID->map(function (Product $product) {
            return "SKU: {$product->sku}, colour: {$product->colour}";
        });
        return view('items/create', compact('availableProductDetailsByID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateItemRequest $request)
    {
        Item::create($request->all());
        return Redirect::route('items.index')->with('message', 'Item added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items/edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateItemRequest $request
     * @param  Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->input());
        return Redirect::route('items.edit', [$item->id])->with('message', 'Item updated successfully.');
    }
}
