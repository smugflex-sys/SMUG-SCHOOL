<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Actions & Schedule -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Quick Actions Widget -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <a href="{{ route('teacher.attendance.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                            <div class="bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full p-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-gray-100">Take Attendance</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mark daily attendance for your classes.</p>
                        </a>
                        <a href="{{ route('teacher.scores.index') }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center text-center">
                            <div class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-full p-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-gray-100">Enter Scores</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Input student exam and assessment scores.</p>
                        </a>
                    </div>

                    <!-- Today's Schedule Widget -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Today's Schedule ({{ \Carbon\Carbon::now()->format('l, F jS') }})</h3>
                        <div class="space-y-4">
                            @forelse($todaysSchedule as $schedule)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $schedule->subject->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $schedule->schoolClass->name }} {{ $schedule->classArm->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400 py-4">You have no classes scheduled for today.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: My Classes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">My Classes & Subjects</h3>
                    <div class="space-y-6">
                        @forelse($assignedClasses as $className => $subjects)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ $className }}</h4>
                                <ul class="mt-2 space-y-2">
                                    @foreach($subjects as $classSubject)
                                        <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                            {{ $classSubject->subject->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">You are not yet assigned to any classes or subjects.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>