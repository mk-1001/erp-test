<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        // Add a unique SKU requirement, only if the SKU is being changed
        $relatedProduct = $this->route('product');
        $uniqueSKU = '';
        if ($relatedProduct->sku != $this->get('sku')) {
            $uniqueSKU = '|unique:products,sku';
        }

        return [
            'sku'    => 'required|string|min:1|max:20' . $uniqueSKU,
            'colour' => 'max:20',
        ];
    }
}
