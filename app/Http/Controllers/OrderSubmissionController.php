<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewOrderRequest;
use App\Services\OrderSubmissionService;
use Illuminate\Database\Eloquent\Collection;

class OrderSubmissionController extends Controller
{
    /**
     * Handles a new order post request.
     * @param NewOrderRequest $request
     * @param OrderSubmissionService $service
     * @return array Items in order
     */
    public function store(NewOrderRequest $request, OrderSubmissionService $service)
    {
        $orderInput = $request->get('order');
        $allItems = $service->handle($orderInput);
        return [
            'items' => $allItems
        ];
    }
}
