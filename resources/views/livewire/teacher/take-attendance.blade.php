<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daily Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                 @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4 border rounded-lg">
                    <div>
                        <x-label for="selectedClassId" value="Select Class" />
                        <select id="selectedClassId" wire:model="selectedClassId" wire:change="fetchStudents" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Class --</option>
                            @foreach($schoolClasses as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="selectedArmId" value="Select Arm" />
                        <select id="selectedArmId" wire:model="selectedArmId" wire:change="fetchStudents" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Arm --</option>
                            @foreach($classArms as $arm)
                                <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="attendanceDate" value="Attendance Date" />
                        <x-input id="attendanceDate" type="date" class="mt-1 block w-full" wire:model="attendanceDate" wire:change="loadAttendance" />
                    </div>
                </div>

                <!-- Attendance Table -->
                @if(count($students) > 0)
                <form wire:submit.prevent="saveAttendance">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $student->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select wire:model="attendance.{{ $student->id }}.status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="late">Late</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-input type="text" wire:model="attendance.{{ $student->id }}.remarks" class="w-full" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-button type="submit">Save Attendance</x-button>
                    </div>
                </form>
                @else
                    <p class="text-center text-gray-500 mt-4">Please select a class and arm to see the list of students.</p>
                @endif
            </div>
        </div>
    </div>
</div>