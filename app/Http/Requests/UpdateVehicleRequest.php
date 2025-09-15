<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
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
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vin' => 'required|string|max:17|unique:vehicles,vin,' . $this->route('vehicle')->id,
            'license_plate' => 'nullable|string|max:20',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 2),
            'color' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive,maintenance,charging',
            'battery_capacity' => 'nullable|numeric|min:0|max:1000',
            'current_battery_level' => 'nullable|numeric|min:0|max:100',
            'odometer' => 'required|numeric|min:0',
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
            'vin.required' => 'Vehicle Identification Number (VIN) is required.',
            'vin.unique' => 'This VIN is already registered to another vehicle.',
            'vin.max' => 'VIN must not exceed 17 characters.',
            'vehicle_type_id.required' => 'Please select a vehicle type.',
            'vehicle_type_id.exists' => 'Selected vehicle type is invalid.',
            'make.required' => 'Vehicle make is required.',
            'model.required' => 'Vehicle model is required.',
            'year.required' => 'Manufacturing year is required.',
            'year.min' => 'Vehicle year must be 1990 or later.',
            'year.max' => 'Vehicle year cannot be more than 2 years in the future.',
            'status.required' => 'Vehicle status is required.',
            'status.in' => 'Invalid vehicle status selected.',
            'battery_capacity.numeric' => 'Battery capacity must be a valid number.',
            'battery_capacity.max' => 'Battery capacity cannot exceed 1000 kWh.',
            'current_battery_level.numeric' => 'Battery level must be a valid percentage.',
            'current_battery_level.max' => 'Battery level cannot exceed 100%.',
            'odometer.required' => 'Odometer reading is required.',
            'odometer.numeric' => 'Odometer must be a valid number.',
            'odometer.min' => 'Odometer reading cannot be negative.',
        ];
    }
}