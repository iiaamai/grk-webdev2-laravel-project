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
        return view('portals.home', [
            'role' => $request->user()->role->value,
            'name' => $request->user()->name,
        ]);
    }
}
