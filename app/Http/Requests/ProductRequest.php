<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 */
class ProductRequest extends FormRequest
{
    /**
     * Standard validation rules.
     *
     * @var array
     */
    protected $rules = [
        'sku'    => 'required|string|min:1|max:20|unique:products,sku',
        'colour' => 'max:20',
    ];


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
        // Add a unique SKU requirement, only if the SKU is being changed (update product request), or a create request.
        $relatedProduct = $this->route('product');
        $uniqueSKU = '';
        if (!$relatedProduct || $relatedProduct->sku != $this->get('sku')) {
            $uniqueSKU = '|unique:products,sku';
        }

        return [
            'sku'    => 'required|string|min:1|max:20' . $uniqueSKU,
            'colour' => 'max:20',
        ];
    }
}
