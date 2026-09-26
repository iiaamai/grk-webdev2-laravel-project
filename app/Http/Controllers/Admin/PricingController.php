<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePricingRequest;
use App\Http\Requests\Admin\UpdatePricingRequest;
use App\Models\Pricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Pricing::class);

        $pricings = Pricing::query()->orderBy('vehicle_type')->get();

        return view('admin.pricing.index', compact('pricings'));
    }

    public function create(): View
    {
        $this->authorize('create', Pricing::class);

        return view('admin.pricing.create');
    }

    public function store(StorePricingRequest $request): RedirectResponse
    {
        Pricing::query()->create($request->validated());

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Pricing row created.');
    }

    public function edit(Pricing $pricing): View
    {
        $this->authorize('update', $pricing);

        return view('admin.pricing.edit', compact('pricing'));
    }

    public function update(UpdatePricingRequest $request, Pricing $pricing): RedirectResponse
    {
        $pricing->update($request->validated());

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Pricing row updated.');
    }

    public function destroy(Pricing $pricing): RedirectResponse
    {
        $this->authorize('delete', $pricing);

        $pricing->archive();

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'Pricing row archived.');
    }
}
