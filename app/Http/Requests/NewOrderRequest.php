<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NewOrderRequest
 * @package App\Http\Requests
 */
class NewOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order'                  => 'required',
            'order.customer'         => 'required|min:2',
            'order.address'          => 'required|string|min:2',
            'order.total'            => 'required|numeric|min:0',
            'order.items'            => 'required|array|min:1',
            'order.items.*.sku'      => 'required|min:2|max:20',
            'order.items.*.quantity' => 'required|integer|min:1',
            'order.items.*.colour'   => 'max:20'
        ];
    }
}
