<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\MailIntegration;
use App\Support\RoleHome;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RoleHome::path($request->user()));
        }

        if (! MailIntegration::isEnabled()) {
            return back()->with('status', 'Email sending is not enabled yet (Mail placeholder).');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
