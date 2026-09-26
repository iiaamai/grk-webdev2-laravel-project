<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Support\RoleHome;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        $allowed = collect($roles)
            ->map(fn (string $role): string => $role)
            ->all();

        $userRole = $user->role instanceof UserRole
            ? $user->role->value
            : (string) $user->role;

        if (! in_array($userRole, $allowed, true)) {
            return redirect()->to(RoleHome::path($user));
        }

        return $next($request);
    }
}
