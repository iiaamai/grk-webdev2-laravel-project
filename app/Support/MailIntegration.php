<?php

namespace App\Support;

/**
 * External Mail integration gate (see docs/development/development_notes.txt).
 * While placeholder: no verification emails are sent; new users are auto-verified.
 */
class MailIntegration
{
    public static function isEnabled(): bool
    {
        return (bool) config('gk.mail_enabled', false);
    }
}
