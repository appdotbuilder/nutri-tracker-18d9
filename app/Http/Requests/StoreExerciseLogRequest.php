<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseLogRequest extends FormRequest
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
            'exercise_type' => 'required|string|in:running,walking,cycling,swimming,yoga,weightlifting,dancing,hiking,basketball,soccer,tennis,jump_rope,rowing,pilates,martial_arts',
            'duration_minutes' => 'required|integer|min:1|max:720',
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
            'exercise_type.required' => 'Exercise type is required.',
            'exercise_type.in' => 'Please select a valid exercise type.',
            'duration_minutes.required' => 'Duration is required.',
            'duration_minutes.integer' => 'Duration must be a whole number.',
            'duration_minutes.min' => 'Duration must be at least 1 minute.',
            'duration_minutes.max' => 'Duration cannot exceed 12 hours (720 minutes).',
            'logged_date.required' => 'Date is required.',
            'logged_date.date' => 'Please provide a valid date.',
        ];
    }
}