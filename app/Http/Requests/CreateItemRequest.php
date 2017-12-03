<?php

namespace App\Http\Requests;

use App\Item;
use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'physical_status' => 'required|in:' . implode(',', Item::PHYSICAL_STATUSES_WITHOUT_ORDER),
            'product_id'      => 'required|exists:products,id'
        ];
    }
}
