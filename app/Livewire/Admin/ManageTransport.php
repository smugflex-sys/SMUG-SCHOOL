<?php

namespace App\Livewire\Admin;

use App\Models\TransportRoute;
use App\Models\Bus;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTransport extends Component
{
    use WithPagination;

    // Properties for Routes
    public $routeName, $routeDescription, $routeId;
    public $showRouteModal = false;
    public $isRouteEditMode = false;

    // Properties for Buses
    public $bus_name, $plate_number, $driver_name, $driver_phone, $transport_route_id;
    public $busId;
    public $showBusModal = false;
    public $isBusEditMode = false;

    // --- Route Management ---
    public function openRouteModal() { $this->reset(['routeName', 'routeDescription', 'routeId', 'isRouteEditMode']); $this->showRouteModal = true; }
    public function storeRoute() {
        $this->validate(['routeName' => 'required|string|unique:transport_routes,name']);
        TransportRoute::create(['name' => $this->routeName, 'description' => $this->routeDescription]);
        session()->flash('message', 'Route created successfully.');
        $this->showRouteModal = false;
    }
    // ... Add edit, update, delete for Routes

    // --- Bus Management ---
    public function openBusModal() { $this->reset(['bus_name', 'plate_number', 'driver_name', 'driver_phone', 'transport_route_id', 'busId', 'isBusEditMode']); $this->showBusModal = true; }
    public function storeBus() {
        $this->validate([
            'bus_name' => 'required|string',
            'plate_number' => 'required|string|unique:buses,plate_number',
            'driver_name' => 'required|string',
            'driver_phone' => 'required|string',
            'transport_route_id' => 'required|exists:transport_routes,id',
        ]);
        Bus::create([
            'bus_name' => $this->bus_name,
            'plate_number' => $this->plate_number,
            'driver_name' => $this->driver_name,
            'driver_phone' => $this->driver_phone,
            'transport_route_id' => $this->transport_route_id,
        ]);
        session()->flash('bus_message', 'Bus registered successfully.');
        $this->showBusModal = false;
    }
    // ... Add edit, update, delete for Buses

    public function render()
    {
        return view('livewire.admin.manage-transport', [
            'routes' => TransportRoute::latest()->paginate(5, ['*'], 'routesPage'),
            'buses' => Bus::with('route')->latest()->paginate(5, ['*'], 'busesPage'),
            'allRoutes' => TransportRoute::all(),
        ]);
    }
}