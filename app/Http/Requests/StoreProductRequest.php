<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:1',
        'stock' => 'required|integer',
        'discount' => 'required|numeric|max:100', // Ensure discount is less than or equal to 100
        'status' => 'required|in:active,inactive,paused',
        'manufacturer_id' => 'nullable|exists:manufacturers,id',
        'product_Code'=>'required|integer|unique:products,product_Code',
        'category_id' => 'nullable|exists:categories,id',
        'description' => 'nullable|string',
        ];
    }
}
