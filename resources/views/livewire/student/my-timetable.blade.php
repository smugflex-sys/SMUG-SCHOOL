<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Weekly Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @foreach($daysOfWeek as $day)
                        <div class="border dark:border-gray-700 rounded-lg p-4">
                            <h3 class="font-bold text-center text-lg text-gray-900 dark:text-gray-100 mb-4">{{ $day }}</h3>
                            <div class="space-y-3">
                                @if(isset($timetable[$day]))
                                    @foreach($timetable[$day] as $entry)
                                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $entry->subject->name }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($entry->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($entry->end_time)->format('h:i A') }}</p>
                                            <p class="text-xs text-gray-500">with {{ $entry->staff->user->name }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-center text-gray-400">No classes scheduled.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>