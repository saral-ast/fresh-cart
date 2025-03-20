<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'featured' => 'boolean',
        ];

        // For slug, conditionally apply unique validation
        if ($this->isMethod('POST')) {
            // Creating a new category
            $rules['slug'] = 'required|string|max:255|unique:categories';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            // Editing an existing category - ignore the current category ID
            $categoryId = $this->route('category');
            $rules['slug'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($categoryId)
            ];
            $rules['image'] ='nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }
}
