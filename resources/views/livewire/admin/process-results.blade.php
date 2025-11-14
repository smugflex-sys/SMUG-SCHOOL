<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Process Term Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                    Generate Term Averages & Positions
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Select a class and term to calculate the total scores, averages, and class positions for all students. This action will overwrite any previously processed results for the selected group.
                </p>

                @if($processingMessage)
                    <div class="mb-4 p-4 text-sm rounded-lg {{ str_contains($processingMessage, 'Success') ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' }}">
                        {{ $processingMessage }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end border-t dark:border-gray-700 pt-6">
                    <div>
                        <x-label for="selectedClassId" value="Select Class" />
                        <select id="selectedClassId" wire:model="selectedClassId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Class --</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedClassId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label for="selectedTermId" value="Select Term" />
                        <select id="selectedTermId" wire:model="selectedTermId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Term --</option>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }} ({{ $term->academicSession->name }})</option>
                            @endforeach
                        </select>
                         @error('selectedTermId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-button wire:click="processResults" wire:loading.attr="disabled" wire:confirm="Are you sure you want to process results for this class? This action cannot be undone.">
                            <span wire:loading.remove wire:target="processResults">Process Results</span>
                            <span wire:loading wire:target="processResults">Processing...</span>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>