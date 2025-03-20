<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'phone' => 'required|digits_between:10,15',
            'status' => 'required',
        ];

        if ($this->isMethod('POST')) {
            $rules['email'] = 'required|email|max:255|unique:users';
            $rules['password'] = 'required|confirmed|min:8';
            // $rules['status'] = 'required|boolean';
        } else {
            $userId = $this->route('customer');
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)
            ];
            $rules['password'] = 'nullable|confirmed|min:8';
            // $rules['status'] = 'nullable|boolean';
        }

        return $rules;
    }
}
