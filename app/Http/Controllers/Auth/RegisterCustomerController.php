<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterCustomerRequest;
use App\Models\User;
use App\Support\MailIntegration;
use App\Support\RoleHome;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterCustomerController extends Controller
{
    public function create(): View
    {
        return view('auth.register-customer');
    }

    public function store(RegisterCustomerRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            ...$request->safe()->only(['name', 'email', 'mobile', 'password']),
            'role' => UserRole::Customer,
            'email_verified_at' => MailIntegration::isEnabled() ? null : now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->to(RoleHome::path($user));
    }
}
