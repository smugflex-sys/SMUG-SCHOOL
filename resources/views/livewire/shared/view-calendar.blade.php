<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('School Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between mb-4">
                    <x-secondary-button wire:click="goToPreviousMonth">&lt; Prev</x-secondary-button>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}</h3>
                    <x-secondary-button wire:click="goToNextMonth">Next &gt;</x-secondary-button>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2 text-center text-sm">
                    <!-- Day Headers -->
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="font-semibold p-2 text-gray-700 dark:text-gray-300">{{ $day }}</div>
                    @endforeach

                    <!-- Blank days for start of month -->
                    @for ($i = 0; $i < $startOfMonth; $i++)
                        <div></div>
                    @endfor

                    <!-- Calendar Days -->
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-2 h-24 flex flex-col">
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $day }}</span>
                            @if(isset($events[$day]))
                                <div class="mt-1 overflow-y-auto text-xs text-left space-y-1">
                                @foreach($events[$day] as $event)
                                    <p class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded px-1 truncate">{{ $event->title }}</p>
                                @endforeach
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>