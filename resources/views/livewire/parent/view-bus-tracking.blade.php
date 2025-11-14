<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Real-Time Bus Tracking') }}
        </h2>
    </x-slot>

    <!-- Leaflet CSS for the map -->
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <!-- Map Container -->
                    <div class="lg:col-span-2 h-[400px] lg:h-[600px]" id="map" wire:ignore></div>
                    
                    <!-- Status Panel -->
                    <div class="p-6 border-l dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">My Wards' Bus Status</h3>
                        <div class="space-y-4" wire:poll.10s="loadBusLocations">
                            @forelse($wardsOnBus as $ward)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $ward->user->name }}</p>
                                    @if($ward->bus->first())
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Bus: {{ $ward->bus->first()->bus_name }} ({{ $ward->bus->first()->route->name }})
                                        </p>
                                        @if(isset($busLocations[$ward->bus->first()->id]))
                                             <p class="text-xs text-gray-500">
                                                Last updated: {{ \Carbon\Carbon::parse($busLocations[$ward->bus->first()->id]['recorded_at'])->diffForHumans() }}
                                            </p>
                                        @else
                                            <p class="text-xs text-yellow-500">Awaiting location data...</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-gray-500">Not assigned to a bus.</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500">None of your wards are currently assigned to a bus route.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS and map initialization script -->
    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            // Initialize map
            const map = L.map('map').setView([6.5244, 3.3792], 13); // Default to Lagos, Nigeria
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let markers = {};
            const busIcon = L.icon({
                iconUrl: 'https://placehold.co/40x40/16a34a/ffffff?text=BUS',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -40]
            });

            // Listen for Livewire event to update markers
            Livewire.on('updateBusMarkers', ({ locations }) => {
                // Remove old markers
                for (const busId in markers) {
                    if (!locations[busId]) {
                        map.removeLayer(markers[busId]);
                        delete markers[busId];
                    }
                }

                // Add or update new markers
                for (const busId in locations) {
                    const lat = locations[busId].latitude;
                    const lng = locations[busId].longitude;
                    
                    if (markers[busId]) {
                        // Just move the existing marker
                        markers[busId].setLatLng([lat, lng]);
                    } else {
                        // Create a new marker
                        markers[busId] = L.marker([lat, lng], {icon: busIcon}).addTo(map)
                            .bindPopup(`Bus ID: ${busId}`);
                    }
                }
            });
        });
    </script>
    @endpush
</div>