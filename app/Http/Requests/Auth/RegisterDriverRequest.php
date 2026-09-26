<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'vehicle_type' => ['required', 'string', 'max:255'],
            'plate' => ['required', 'string', 'max:50'],
            'capacity_kg' => ['required', 'integer', 'min:1'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
