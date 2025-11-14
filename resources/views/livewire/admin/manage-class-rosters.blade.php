<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Class Rosters') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Filter Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end border-b dark:border-gray-700 pb-6 mb-6">
                    <div>
                        <x-label value="Select Class" />
                        <select wire:model="selectedClassId" class="mt-1 block w-full ...">
                            <option>Select a class...</option>
                            @foreach($schoolClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label value="Select Arm" />
                        <select wire:model="selectedArmId" class="mt-1 block w-full ...">
                            <option>Select an arm...</option>
                            @foreach($classArms as $arm)
                            <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-button wire:click="loadRoster">Load Roster</x-button>
                </div>

                <!-- Roster Display -->
                @if(!empty($students))
                    <!-- Add Bulk Import Button and Student Table here -->
                    <h3 class="text-lg font-medium">Roster for selected class</h3>
                @else
                    <p class="text-center text-gray-500 py-10">Please select a class and arm to view the student roster.</p>
                @endif
            </div>
        </div>
    </div>
</div>