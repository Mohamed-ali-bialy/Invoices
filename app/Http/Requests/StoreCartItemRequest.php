<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productIds' => 'required|array',
            'productIds.*' => 'required|exists:products,id',
            'quantitys' => 'required|array',
            'quantitys.*' => 'required|integer|min:1',
            'redirectToCart' => 'nullable|boolean',
        ];
    }
}
