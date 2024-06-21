<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        'stock' => 'required|integer|min:0',
        'discount' => 'required|numeric|max:100|min:0', // Ensure discount is less than or equal to 100
        'status' => 'required|in:active,inactive,paused',
        'manufacturer_id' => 'required|exists:manufacturers,id',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        ];
    }
}
