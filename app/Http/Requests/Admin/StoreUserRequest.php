<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() instanceof User && $this->user()->isSystemAdmin();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'vehicle_type' => ['required_if:role,driver', 'nullable', 'string', 'max:255'],
            'plate' => ['required_if:role,driver', 'nullable', 'string', 'max:50'],
            'capacity_kg' => ['required_if:role,driver', 'nullable', 'integer', 'min:1'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
