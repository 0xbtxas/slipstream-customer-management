<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'reference' => 'nullable|string|max:255',
            'customer_category_id' => 'required|exists:customer_categories,id',
            'start_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom validation error messages for the request.
     *
     * This method overrides the default Laravel validation messages
     * to provide more user-friendly and descriptive messages
     * for specific validation rule failures.
     *
     * @return array<string, string> Array of rule => message pairs
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Customer name is required.',
            'customer_category_id.required' => 'Please select a category.',
            'customer_category_id.exists' => 'The selected category is invalid.',
            'start_date.date' => 'Start date must be a valid date.',
        ];
    }
}
