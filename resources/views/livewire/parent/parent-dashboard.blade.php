<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($wards->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-600 dark:text-gray-400">Your account is not yet linked to any student. Please contact the school administration.</p>
                </div>
            @else
                <!-- Ward Selector -->
                <div class="mb-6">
                    <x-label for="selectedWardId" value="Viewing Dashboard For:" />
                    <select id="selectedWardId" wire:model.live="selectedWardId" class="mt-1 block w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        @foreach($wards as $ward)
                            <option value="{{ $ward->id }}">{{ $ward->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Loading Indicator -->
                <div wire:loading class="w-full text-center text-gray-500 mb-4">
                    Loading ward's data...
                </div>

                <!-- Dashboard Widgets -->
                <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Student Info Widget -->
                    <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
                        <img class="h-24 w-24 rounded-full object-cover mb-4" src="{{ $selectedWard->user->profile_photo_url }}" alt="{{ $selectedWard->user->name }}">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $selectedWard->user->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $selectedWard->admission_no }}</p>
                        <p class="mt-2 px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">{{ $selectedWard->schoolClass->name }} {{ $selectedWard->classArm->name }}</p>
                    </div>

                    <!-- Latest Results & Fees Widgets -->
                    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Latest Result -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                            <h3 class="text-gray-500 text-sm font-medium">Latest Result</h3>
                            @if($latestResult)
                                <p class="text-gray-600 dark:text-gray-400 text-xs">{{ $latestResult->term->name }}</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($latestResult->average, 2) }}%</p>
                                <p class="text-sm text-gray-500">Position: {{ $latestResult->position }}</p>
                            @else
                                <p class="text-gray-500 mt-4">No results processed yet.</p>
                            @endif
                        </div>
                        <!-- Fee Status -->
                         <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                            <h3 class="text-gray-500 text-sm font-medium">Outstanding Fees</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">₦{{ number_format($outstandingBalance, 2) }}</p>
                             <a href="{{ route('parent.payments') }}" class="text-sm text-green-600 hover:text-green-800 mt-2 inline-block">View & Pay Invoices &rarr;</a>
                        </div>
                         <!-- Attendance Summary -->
                        <div class="sm:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                             <h3 class="text-gray-500 text-sm font-medium mb-3">Attendance This Month</h3>
                             <div class="flex justify-around text-center">
                                 <div>
                                     <p class="text-2xl font-bold text-green-600">{{ $attendanceStats['present'] }}</p>
                                     <p class="text-xs text-gray-500">Present</p>
                                 </div>
                                 <div>
                                     <p class="text-2xl font-bold text-yellow-600">{{ $attendanceStats['late'] }}</p>
                                     <p class="text-xs text-gray-500">Late</p>
                                 </div>
                                 <div>
                                     <p class="text-2xl font-bold text-red-600">{{ $attendanceStats['absent'] }}</p>
                                     <p class="text-xs text-gray-500">Absent</p>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>