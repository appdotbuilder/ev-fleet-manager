<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
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
            'employee_id' => 'required|string|max:50|unique:drivers,employee_id,' . $this->route('driver')->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:drivers,email,' . $this->route('driver')->id,
            'phone' => 'nullable|string|max:20',
            'license_number' => 'required|string|max:50|unique:drivers,license_number,' . $this->route('driver')->id,
            'license_expiry_date' => 'required|date',
            'date_of_birth' => 'required|date|before:18 years ago',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:150',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,on_trip,off_duty,suspended',
            'rating' => 'nullable|numeric|min:1|max:5',
            'total_trips' => 'nullable|integer|min:0',
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
            'employee_id.required' => 'Employee ID is required.',
            'employee_id.unique' => 'This Employee ID is already in use by another driver.',
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered to another driver.',
            'license_number.required' => 'Driver license number is required.',
            'license_number.unique' => 'This license number is already registered to another driver.',
            'license_expiry_date.required' => 'License expiry date is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Driver must be at least 18 years old.',
            'status.required' => 'Driver status is required.',
            'status.in' => 'Invalid driver status selected.',
            'rating.numeric' => 'Rating must be a valid number.',
            'rating.min' => 'Rating must be at least 1.',
            'rating.max' => 'Rating cannot exceed 5.',
            'total_trips.integer' => 'Total trips must be a whole number.',
            'total_trips.min' => 'Total trips cannot be negative.',
        ];
    }
}