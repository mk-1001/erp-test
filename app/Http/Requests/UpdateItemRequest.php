<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateItemRequest
 * @package App\Http\Requests
 */
class UpdateItemRequest extends FormRequest
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
        $relatedItem = $this->route('item');
        return [
            'physical_status' => 'required|in:' . implode(',', $relatedItem->getAllowedPhysicalStatuses())
        ];
    }
}
