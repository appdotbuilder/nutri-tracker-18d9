<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodLogRequest extends FormRequest
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
            'calories' => 'required|numeric|min:0|max:9999',
            'protein' => 'required|numeric|min:0|max:999',
            'fat' => 'required|numeric|min:0|max:999',
            'carbohydrates' => 'required|numeric|min:0|max:999',
            'logged_date' => 'required|date',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Food/drink name is required.',
            'calories.required' => 'Calories value is required.',
            'calories.numeric' => 'Calories must be a valid number.',
            'protein.required' => 'Protein value is required.',
            'protein.numeric' => 'Protein must be a valid number.',
            'fat.required' => 'Fat value is required.',
            'fat.numeric' => 'Fat must be a valid number.',
            'carbohydrates.required' => 'Carbohydrates value is required.',
            'carbohydrates.numeric' => 'Carbohydrates must be a valid number.',
            'logged_date.required' => 'Date is required.',
            'logged_date.date' => 'Please provide a valid date.',
        ];
    }
}