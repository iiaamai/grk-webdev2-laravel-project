<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVehicleRequest;
use App\Http\Requests\Admin\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Vehicle::class);

        $vehicles = Vehicle::query()->orderBy('plate_number')->get();

        return view('admin.fleet.index', compact('vehicles'));
    }

    public function create(): View
    {
        $this->authorize('create', Vehicle::class);

        return view('admin.fleet.create');
    }

    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        Vehicle::query()->create($request->validated());

        return redirect()
            ->route('admin.fleet.index')
            ->with('status', 'Vehicle created.');
    }

    public function edit(Vehicle $vehicle): View
    {
        $this->authorize('update', $vehicle);

        return view('admin.fleet.edit', compact('vehicle'));
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update($request->validated());

        return redirect()
            ->route('admin.fleet.index')
            ->with('status', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $this->authorize('delete', $vehicle);

        $vehicle->archive();

        return redirect()
            ->route('admin.fleet.index')
            ->with('status', 'Vehicle archived.');
    }
}
