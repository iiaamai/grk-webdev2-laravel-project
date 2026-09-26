<?php

namespace App\Http\Requests\Admin;

use App\Enums\VehicleStatus;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() instanceof User
            && $this->user()->can('create', Vehicle::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'plate_number' => ['required', 'string', 'max:50', 'unique:vehicles,plate_number'],
            'label' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'capacity_kg' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::enum(VehicleStatus::class)],
        ];
    }
}
