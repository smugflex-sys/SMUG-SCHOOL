<?php

namespace App\Livewire\Parent;

use App\Models\BusLocation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewBusTracking extends Component
{
    public $wardsOnBus = [];
    public $busLocations = [];

    public function mount()
    {
        $this->wardsOnBus = Auth::user()->children()
            ->whereHas('bus') // Only get children assigned to a bus
            ->with('bus.route')
            ->get();
        
        $this->loadBusLocations();
    }

    public function loadBusLocations()
    {
        $busIds = $this->wardsOnBus->pluck('bus.*.id')->flatten()->unique();

        if ($busIds->isNotEmpty()) {
            $latestLocations = BusLocation::whereIn('bus_id', $busIds)
                ->select('bus_id', \DB::raw('MAX(recorded_at) as last_update'))
                ->groupBy('bus_id');

            $this->busLocations = BusLocation::joinSub($latestLocations, 'latest', function ($join) {
                    $join->on('bus_locations.bus_id', '=', 'latest.bus_id')
                         ->on('bus_locations.recorded_at', '=', 'latest.last_update');
                })
                ->get()
                ->keyBy('bus_id')
                ->toArray();
            
            // Dispatch event to update map markers in the browser
            $this->dispatch('updateBusMarkers', ['locations' => $this->busLocations]);
        }
    }

    public function render()
    {
        return view('livewire.parent.view-bus-tracking');
    }
}