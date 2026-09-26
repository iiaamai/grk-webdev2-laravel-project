<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Support\MailIntegration;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

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
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->safe()->only([
            'name',
            'email',
            'mobile',
            'role',
            'vehicle_type',
            'plate',
            'capacity_kg',
            'password',
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

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->archive();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User archived.');
    }
}
