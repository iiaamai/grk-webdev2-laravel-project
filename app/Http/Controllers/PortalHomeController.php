<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalHomeController extends Controller
{
    /**
     * Temporary portal landing until F1 layout shells.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        if ($user->isSystemAdmin()) {
            return view('portals.admin-home', [
                'name' => $user->name,
            ]);
        }

        return view('portals.home', [
            'role' => $user->role->value,
            'name' => $user->name,
        ]);
    }
}
