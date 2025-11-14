<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Result Checker PINs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Generation Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Generate New PINs</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <x-label for="quantity" value="Quantity to Generate" />
                        <x-input id="quantity" type="number" class="mt-1 block w-full" wire:model="quantity" />
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label for="usage_limit" value="Usage Limit per PIN" />
                        <x-input id="usage_limit" type="number" class="mt-1 block w-full" wire:model="usage_limit" />
                        @error('usage_limit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-button wire:click="generate" wire:loading.attr="disabled">
                            Generate PINs
                        </x-button>
                    </div>
                </div>
            </div>

            <!-- Display recently generated PINs -->
            @if(!empty($generatedPins))
                <div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 text-blue-800 dark:text-blue-200 px-4 py-3 rounded relative mb-6">
                    <h4 class="font-bold mb-2">Newly Generated PINs (Please copy and save them now):</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 text-sm font-mono">
                        @foreach($generatedPins as $pin)
                            <span>{{ $pin }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- PINs Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Generated PINs History</h3>
                <!-- Table to display all pins from pagination -->
            </div>
        </div>
    </div>
</div>