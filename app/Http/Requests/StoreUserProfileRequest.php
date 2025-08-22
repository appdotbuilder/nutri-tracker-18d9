<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfileRequest extends FormRequest
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
            'height' => 'nullable|numeric|min:100|max:250',
            'weight' => 'nullable|numeric|min:30|max:300',
            'neck_circumference' => 'nullable|numeric|min:20|max:60',
            'waist_circumference' => 'nullable|numeric|min:50|max:150',
            'gender' => 'nullable|in:male,female',
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
            'height.numeric' => 'Height must be a valid number.',
            'height.min' => 'Height must be at least 100 cm.',
            'height.max' => 'Height cannot exceed 250 cm.',
            'weight.numeric' => 'Weight must be a valid number.',
            'weight.min' => 'Weight must be at least 30 kg.',
            'weight.max' => 'Weight cannot exceed 300 kg.',
            'neck_circumference.numeric' => 'Neck circumference must be a valid number.',
            'waist_circumference.numeric' => 'Waist circumference must be a valid number.',
            'gender.in' => 'Gender must be either male or female.',
        ];
    }
}