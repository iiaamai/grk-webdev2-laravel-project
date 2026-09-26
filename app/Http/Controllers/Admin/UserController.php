<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use App\Support\MailIntegration;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * System Admin creates a user of any role (including Staff).
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->safe()->only([
            'name',
            'email',
            'mobile',
            'password',
            'role',
            'vehicle_type',
            'plate',
            'capacity_kg',
        ]);

        $role = $data['role'] instanceof UserRole
            ? $data['role']
            : UserRole::from((string) $data['role']);

        if ($role !== UserRole::Driver) {
            $data['vehicle_type'] = null;
            $data['plate'] = null;
            $data['capacity_kg'] = null;
        }

        $data['role'] = $role;
        $data['email_verified_at'] = MailIntegration::isEnabled() ? null : now();

        User::query()->create($data);

        return redirect()
            ->route('admin.home')
            ->with('status', 'User created successfully.');
    }
}
