<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'price'=> 'required|numeric|min:0',
            'category_id' => 'required',
            'description' => 'required|string|max:255',
            'featured' => 'boolean',
        ];

        if ($this->isMethod('POST')) {
            $rules['slug'] = 'required|string|max:255|unique:products';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            $productId = $this->route('product');
            $rules['slug'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($productId)
            ];
        }

        return $rules;
    }
}
