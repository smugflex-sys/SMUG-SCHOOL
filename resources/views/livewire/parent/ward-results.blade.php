<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Wards\' Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Ward Selector -->
                <div class="mb-6">
                    <x-label for="selectedWardId" value="Select Ward:" />
                    <select id="selectedWardId" wire:model.live="selectedWardId" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        @foreach($wards as $ward)
                            <option value="{{ $ward->id }}">{{ $ward->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-4">
                    @forelse($results as $result)
                        <div class="p-4 border dark:border-gray-700 rounded-lg flex flex-col md:flex-row justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                    {{ $result->term->name }} ({{ $result->term->academicSession->name }})
                                </p>
                                <div class="flex space-x-6 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span>Average: <span class="font-semibold">{{ number_format($result->average, 2) }}%</span></span>
                                    <span>Position: <span class="font-semibold">{{ $result->position }}</span></span>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('reports.report-card', ['studentId' => $result->student_id, 'termId' => $result->term_id]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Download Report Card
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No results have been processed for this ward yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>