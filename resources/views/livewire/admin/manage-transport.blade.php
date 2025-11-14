<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Transportation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Manage Routes -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Bus Routes</h3>
                    <x-button wire:click="openRouteModal()">Add Route</x-button>
                </div>
                <!-- Route notifications and table here -->
            </div>

            <!-- Right Column: Manage Buses -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                 <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Registered Buses</h3>
                    <x-button wire:click="openBusModal()">Add Bus</x-button>
                </div>
                <!-- Bus notifications and table here. The table should have a "Manage Roster" link -->
                 <div class="overflow-x-auto mt-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Bus Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Driver</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Route</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($buses as $bus)
                            <tr>
                                <td class="px-6 py-4">{{ $bus->bus_name }}</td>
                                <td class="px-6 py-4">{{ $bus->driver_name }}</td>
                                <td class="px-6 py-4">{{ $bus->route->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.transport.roster', $bus->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Manage Roster</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals for Route and Bus creation/editing go here -->
</div>